<?php

namespace App\Api\V1\Http\Controllers\Driver;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Auth\LoginRequest;
use App\Api\V1\Http\Requests\Auth\RefreshTokenRequest;
use App\Api\V1\Http\Requests\Driver\DriverRequest;
use App\Api\V1\Http\Requests\Driver\DriverUpdateRequest;
use App\Api\V1\Http\Resources\Auth\AuthResource;
use App\Api\V1\Http\Resources\Driver\DriverResource;
use App\Api\V1\Services\Driver\DriverServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group Người dùng
 */
class DriverController extends Controller
{
    use Response, AuthServiceApi;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    public function __construct(
        DriverServiceInterface $service,
    )
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    protected function resolve(): bool
    {

        return Auth::guard(self::$GUARD_API)->attempt($this->login);

    }

    public function update(DriverUpdateRequest $request): JsonResponse
    {
        try {
            $response = $this->service->update($request);
            return $this->jsonResponseSuccess(new DriverResource($response));
        } catch (Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return $this->jsonResponseError($e->getMessage(), 500);
        }

    }

    public function login(LoginRequest $request): JsonResponse
    {
        $this->login = $request->validated();

        if ($this->resolve()) {
            $user = Auth::guard(self::$GUARD_API)->user();
            $token = JWTAuth::fromUser($user);
            $refreshToken = $this->createRefreshToken($user);
            return $this->respondWithToken($token, $refreshToken);
        }

        return response()->json([
            'status' => 401,
            'message' => __('Tài khoản hoặc mật khẩu không đúng.')
        ], 401);
    }

    public function register(DriverRequest $request): JsonResponse
    {
        $driver = $this->service->store($request);
        if (!$driver) {
            return response()->json(['error' => 'Registration failed'], 422);
        }
        $user = $driver->user;
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = $this->createRefreshTokenById($user);

        return $this->respondWithToken($accessToken, $refreshToken);

    }

    /**
     * @throws Exception
     */
    public function show(): JsonResponse
    {
        $driver = $this->getCurrentDriver();
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new AuthResource($driver)
        ]);
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
