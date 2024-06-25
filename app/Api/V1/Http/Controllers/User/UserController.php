<?php

namespace App\Api\V1\Http\Controllers\User;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Auth\RefreshTokenRequest;
use App\Api\V1\Http\Requests\Auth\RegisterRequest;
use App\Api\V1\Services\User\UserServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group Người dùng
 */

class UserController extends Controller
{
    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;
    public function __construct(
        UserServiceInterface   $service,
    )
    {
        $this->service = $service;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    protected function resolve(): bool
    {

        return Auth::guard(self::$GUARD_API)->attempt($this->login);

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
