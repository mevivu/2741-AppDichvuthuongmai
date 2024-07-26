<?php

namespace App\Api\V1\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Auth\LoginRequest;
use App\Api\V1\Http\Resources\Auth\AuthResource;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Traits\JwtService;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Người dùng
 */
class AuthController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
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
    /**
     * Đăng nhập
     *
     * API này dùng để đăng nhập
     *
     * @bodyParam phone string required
     * Username của người dùng. Example: 0961592551
     *
     * @response 200 {
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL2RyaXZlcnMvbG9naW4iLCJpYXQiOjE3MjEzODM2ODQsImV4cCI6MTcyNjU2NzY4NCwibmJmIjoxNzIxMzgzNjg0LCJqdGkiOiJwWnNJclVrSms2UHFzT0xrIiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.En3WpOwOpKMTMHk4PmG799dZZ0DwfrH9HraimUqSU24",
     *     "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo5LCJyYW5kb20iOiIxMzcwNzU5NTQxMTcyMTM4MzY4NCIsImlzX3JlZnJlc2hfdG9rZW4iOnRydWUsImV4cCI6MTcyMTkwOTI4NH0.abTovSfJmNOB_8ZqGpbNBFxwhGpue7OSEQgnbdPiVak",
     *     "role": "driver",
     *     "expires_in": 5184000
     * }
     *
     * @response 401 {
     *     "status": 401,
     *     "message": "Thông tin đăng nhập chưa chính xác.",
     * }
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->loginUser($request);
        } catch (Exception $e) {
            $this->logError("Login failed", $e);
            return $this->jsonResponseError($e->getMessage());
        }
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
