<?php

namespace App\Api\V1\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Resources\Auth\AuthResource;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Http\Requests\Auth\{LoginRequest, RefreshTokenRequest, RegisterRequest};
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group Phụ huynh
 */
class ParentController extends Controller
{
    private static string $GUARD_API = 'api';
    private $login;

    public function __construct(
        UserRepositoryInterface $repository,
        AuthServiceInterface    $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    protected function resolve(): bool
    {

        return Auth::attempt($this->login);

    }


    /**
     * Đăng nhập
     *
     * @bodyParam phone string required
     * Tên tài khoản là số điện thoại. Example: 0999999999
     *
     * @bodyParam password string required
     * Mật khẩu của bạn. Example: 123456
     *
     * @response {
     *      "refresh_token": "1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K"
     *      "access_token": "1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K",
     *      "expires_in": 5184000
     * }
     * @response 401 {
     *      "status": 401,
     *      "message": "Tài khoản hoặc mật khẩu không đúng."
     * }
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $this->login = $request->validated();

        if ($this->resolve()) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            $refreshToken = $this->createRefreshToken($user);
            return $this->respondWithToken($token, $refreshToken);
        }

        return response()->json([
            'status' => 401,
            'message' => __('Tài khoản hoặc mật khẩu không đúng.')
        ], 401);
    }


    /**
     * Lấy thông tin người dùng đã xác thực.
     *
     * API này trả về thông tin chi tiết của người dùng đã xác thực hiện tại
     * @authenticated
     *
     * Các trạng thái (status) của đơn hàng bao gồm:
     * - 1: Hoạt động
     * - 2: Chờ xác nhận
     * - 3: Khoá
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Lấy thông tin người dùng thành công.",
     *      "data": {
     *          "id": 1,
     *          "name": "Nguyen Van A",
     *          "email": "example@example.com",
     *          "phone": "0123456789",
     *          "created_at": "2021-01-01T00:00:00Z",
     *          "updated_at": "2021-12-01T00:00:00Z"
     *      }
     * }
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = auth(self::$GUARD_API)->user();
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new AuthResource($user)
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->service->store($request);

        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = $this->createRefreshTokenById($user);

        return $this->respondWithToken($accessToken, $refreshToken);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth(self::$GUARD_API)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        $data = $request->validated();
        $refreshToken = $data['refresh_token'];

        try {
            $decoded = JWTAuth::setToken($refreshToken)->getPayload();
            if (!$decoded->get('is_refresh_token', false)) {
                return response()->json(['message' => 'Invalid token type.'], 401);
            }

            if (time() - $decoded->get('token_generated') < config('jwt.refresh_ttl')) {
                return response()->json(['message' => 'Refresh token has already been used.'], 401);
            }

            $user = $this->repository->findOrFail($decoded->get('sub'));

            $newToken = JWTAuth::fromUser($user);
            $newRefreshToken = $this->createRefreshToken($user);

            return $this->respondWithToken($newToken, $newRefreshToken);

        } catch (Exception $e) {
            return response()->json(['message' => 'Invalid token.', 'error' => $e->getMessage()], 401);
        }
    }

    protected function respondWithToken($token, $refreshToken): JsonResponse
    {
        $ttl = config('jwt.ttl');
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'expires_in' => $ttl * 60
        ]);
    }


    private function createRefreshToken($user)
    {
        $data = [
            'user_id' => $user->id,
            'random' => rand() . time(),
            'is_refresh_token' => true,
            'exp' => time() + config('jwt.refresh_ttl'),
        ];
        return JWTAuth::getJWTProvider()->encode($data);
    }

    /**
     * Create refresh_token.
     */
    private function createRefreshTokenById($user)
    {
        $data = [
            'user_id' => $user->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        return JWTAuth::getJWTProvider()->encode($data);
    }




}
