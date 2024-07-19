<?php

namespace App\Api\V1\Http\Controllers\Driver;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Api\V1\Http\Requests\Driver\DriverRequest;
use App\Api\V1\Http\Requests\Driver\DriverUpdateRequest;
use App\Api\V1\Http\Resources\Auth\AuthResource;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Driver\DriverServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Traits\JwtService;
use App\Traits\UseLog;
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
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        DriverServiceInterface  $service,
        UserRepositoryInterface $userRepository
    )
    {
        $this->service = $service;
        $this->userRepository = $userRepository;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    protected function resolve(): bool
    {
        $user = $this->userRepository->findByField('phone', $this->login['phone']);
        if ($user) {
            Auth::login($user);
            return true;
        }
        return false;
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        try {
            return $this->loginUser($request);

        } catch (Exception $e) {
            $this->logError("Login failed", $e);
            return $this->jsonResponseError($e->getMessage());
        }
    }


    /**
     * Cập nhật tài xế
     *
     * API này dùng để cập nhật thông tin cho tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam fullname string optional
     * Họ và tên của tài xế. Example: Phạm Minh Mạnh
     *
     * @bodyParam email string optional
     * Email của tài xế. Example: manh@gmail.com
     *
     * @bodyParam address string optional
     * Địa chỉ của tài xế. Example: 123 Gò vấp
     *
     * @bodyParam bithday date optional
     * Ngày sinh của tài xế. Example: 2001-01-01
     *
     * @bodyParam avatar file optional
     * Avatar của tài xế. Example: avatar.png
     *
     * @bodyParam phone string optional
     * Số điện thoại của tài xế. Example: 0961592551
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     * }
     *
     * @return JsonResponse
     */
    public function update(DriverUpdateRequest $request): JsonResponse
    {
        try {
            $this->service->update($request);
            return $this->jsonResponseSuccess(null, '', 200);
        } catch (Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return $this->jsonResponseError($e->getMessage(), 500);
        }

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


}
