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
 * @group Người dùng
 */
class AuthController extends Controller
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
     * Get the authenticated User.
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




}
