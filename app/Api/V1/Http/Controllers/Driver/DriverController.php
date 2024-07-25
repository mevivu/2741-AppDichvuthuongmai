<?php

namespace App\Api\V1\Http\Controllers\Driver;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Driver\DriverRequest;
use App\Api\V1\Http\Requests\Driver\DriverUpdateRequest;
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
 * @group Tài xế
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
    /**
     * Cập nhật tài xế
     *
     * API này dùng để cập nhật tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam phone string optional
     * Số điện thoại của tài xế. Example: 0901234567
     *
     * @bodyParam fullname string optional
     * Họ và tên của tài xế. Example: Nguyễn Văn A
     *
     * @bodyParam birthday string optional
     * Họ và tên của tài xế. Example: Nguyễn Văn A
     *
     * @bodyParam address string optional
     * Địa chỉ của tài xế. Example: Nguyễn Văn A
     *
     * @bodyParam email string optional
     * Email của tài xế. Example: manh@gmail.com
     *
     * @bodyParam avatar file optional
     * Ảnh đại diện của tài xế. Example: avatar.jpg
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error.",
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

    /**
     * Đăng ký
     *
     * API này dùng để đăng ký thông tin cho tài xế
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam phone string required
     * Số điện thoại của tài xế. Example: 0901234567
     *
     * @bodyParam fullname string required
     * Họ và tên của tài xế. Example: Nguyễn Văn A
     *
     * @bodyParam email string required
     * Email của tài xế. Example: manh@gmail.com
     *
     * @bodyParam avatar file optional
     * Ảnh đại diện của tài xế. Example: avatar.jpg
     *
     * @bodyParam id_card string required
     * Số CMND/CCCD của tài xế. Example: 123456789012
     *
     * @bodyParam id_card_front file required
     * Ảnh mặt trước CMND/CCCD của tài xế. Example: id_card_front.jpg
     *
     * @bodyParam id_card_back file required
     * Ảnh mặt sau CMND/CCCD của tài xế. Example: id_card_back.jpg
     *
     * @bodyParam license_plate string required
     * Biển số xe của tài xế. Example: 51A-12345
     *
     * @bodyParam license_plate_image file required
     * Ảnh biển số xe của tài xế. Example: license_plate.jpg
     *
     * @bodyParam vehicle_company string required
     * Hãng xe của tài xế. Example: Toyota
     *
     * @bodyParam vehicle_registration_front file required
     * Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     *
     * @bodyParam vehicle_registration_back file required
     * Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     *
     * @bodyParam driver_license_front file required
     * Ảnh mặt trước bằng lái xe. Example: driver_license_front.jpg
     *
     * @bodyParam driver_license_back file required
     * Ảnh mặt sau bằng lái xe. Example: driver_license_back.jpg
     *
     * @bodyParam vehicle_front_image file required
     * Ảnh mặt trước của xe. Example: vehicle_front.jpg
     *
     * @bodyParam vehicle_back_image file required
     * Ảnh mặt sau của xe. Example: vehicle_back.jpg
     *
     * @bodyParam vehicle_side_image file required
     * Ảnh mặt bên của xe. Example: vehicle_side.jpg
     *
     * @bodyParam vehicle_interior_image file required
     * Ảnh nội thất của xe. Example: vehicle_interior.jpg
     *
     * @bodyParam insurance_front_image file required
     * Ảnh mặt trước bảo hiểm xe. Example: insurance_front.jpg
     *
     * @bodyParam insurance_back_image file required
     * Ảnh mặt sau bảo hiểm xe. Example: insurance_back.jpg
     *
     * @bodyParam bank_name string required
     * Tên ngân hàng. Example: Vietcombank
     *
     * @bodyParam bank_account_name string required
     * Tên chủ tài khoản ngân hàng. Example: Nguyễn Văn A
     *
     * @bodyParam bank_account_number string required
     * Số tài khoản ngân hàng. Example: 1234567890
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Kiểm tra lại các trường.",
     * }
     *
     * @response 422 {
     *     "status": 422,
     *     "error": "Registration failed.",
     * }
     *
     * @return JsonResponse
     */
    public function register(DriverRequest $request): JsonResponse
    {
        $driver = $this->service->store($request);
        if (!$driver) {
            return response()->json(['error' => 'Registration failed'], 422);
        }
        $user = $driver->user;
        $accessToken = JWTAuth::fromUser($user);
        $refreshToken = $this->createRefreshTokenById($user);

        return $this->respondWithToken($accessToken, $refreshToken, $user->roles[0]->name);

    }
}
