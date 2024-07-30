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
    ) {
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
     * @bodyParam avatar file optional Ảnh đại diện của tài xế. Example: avatar.jpg
     * @bodyParam id_card string optional Số CMND/CCCD của tài xế. Example: 123456789012
     * @bodyParam id_card_front file optional Ảnh mặt trước CMND/CCCD của tài xế. Example: id_card_front.jpg
     * @bodyParam id_card_back file optional Ảnh mặt sau CMND/CCCD của tài xế. Example: id_card_back.jpg
     * @bodyParam license_plate string optional Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam fullname string optional Họ và tên của tài xế. Example: Nguyễn Văn A
     * @bodyParam email string optional Email của tài xế. Example: example@example.com
     * @bodyParam phone string optional Số điện thoại của tài xế. Example: 0901234567
     * @bodyParam lat string optional Vĩ độ. Example: 10.762622
     * @bodyParam lng string optional Kinh độ. Example: 106.660172
     * @bodyParam address string optional Địa chỉ của tài xế. Example: 123 Đường ABC, Quận 1, TP.HCM
     * @bodyParam birthday string optional Ngày sinh của tài xế. Example: 1990-01-01
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
     * @bodyParam driver_license_front file optional Ảnh mặt trước giấy phép lái xe của tài xế. Example: driver_license_front.jpg
     * @bodyParam driver_license_back file optional Ảnh mặt sau giấy phép lái xe của tài xế. Example: driver_license_back.jpg
     * @bodyParam bank_name string optional Tên ngân hàng. Example: Vietcombank
     * @bodyParam bank_account_name string optional Tên tài khoản ngân hàng. Example: Nguyễn Văn A
     * @bodyParam bank_account_number string optional Số tài khoản ngân hàng. Example: 0123456789
     * @bodyParam current_address string optional Địa chỉ hiện tại. Example: 456 Đường XYZ, Quận 2, TP.HCM
     * @bodyParam current_lat string optional Vĩ độ hiện tại. Example: 10.762622
     * @bodyParam current_lng string optional Kinh độ hiện tại. Example: 106.660172
     * @bodyParam auto_accept boolean optional Tự động chấp nhận chuyến đi (Tự động: 1, Tắt: 2, Khoá: 3). Example: 1
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string optional Tên xe. Example: Vios
     * @bodyParam price integer optional Giá thuê. Example: 500000
     * @bodyParam vehicle_registration_front file optional Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file optional Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam vehicle_front_image file optional Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file optional Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file optional Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file optional Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * @bodyParam insurance_front_image file optional Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file optional Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
     * @bodyParam color string optional Màu xe. Example: Đen
     * @bodyParam seat_number integer optional Số ghế. Example: 4
     * @bodyParam type string optional Loại xe (Chưa phân loại: 1, Xe gắn máy: 2, Ô tô: 3, Xe tải: 4, Xe tải đông lạnh: 5). Example: 1
     *
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
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
     * @bodyParam avatar file optional Ảnh đại diện của tài xế. Example: avatar.jpg
     * @bodyParam id_card string required Số CMND/CCCD của tài xế. Example: 123456789012
     * @bodyParam id_card_front file required Ảnh mặt trước CMND/CCCD của tài xế. Example: id_card_front.jpg
     * @bodyParam id_card_back file required Ảnh mặt sau CMND/CCCD của tài xế. Example: id_card_back.jpg
     * @bodyParam license_plate string required Biển số xe của tài xế. Example: 51A-12345
     * @bodyParam fullname string required Họ và tên của tài xế. Example: Nguyễn Văn A
     * @bodyParam email string required Email của tài xế. Example: example@example.com
     * @bodyParam phone string required Số điện thoại của tài xế. Example: 0901234567
     * @bodyParam lat string optional Vĩ độ. Example: 10.762622
     * @bodyParam lng string optional Kinh độ. Example: 106.660172
     * @bodyParam address string optional Địa chỉ của tài xế. Example: 123 Đường ABC, Quận 1, TP.HCM
     * @bodyParam birthday string optional Ngày sinh của tài xế. Example: 1990-01-01
     * @bodyParam license_plate_image file optional Ảnh biển số xe của tài xế. Example: license_plate_image.jpg
     * @bodyParam driver_license_front file required Ảnh mặt trước giấy phép lái xe của tài xế. Example: driver_license_front.jpg
     * @bodyParam driver_license_back file required Ảnh mặt sau giấy phép lái xe của tài xế. Example: driver_license_back.jpg
     * @bodyParam bank_name string optional Tên ngân hàng. Example: Vietcombank
     * @bodyParam bank_account_name string optional Tên tài khoản ngân hàng. Example: Nguyễn Văn A
     * @bodyParam bank_account_number string optional Số tài khoản ngân hàng. Example: 0123456789
     * @bodyParam current_address string required Địa chỉ hiện tại. Example: 456 Đường XYZ, Quận 2, TP.HCM
     * @bodyParam current_lat string required Vĩ độ hiện tại. Example: 10.762622
     * @bodyParam current_lng string required Kinh độ hiện tại. Example: 106.660172
     * @bodyParam auto_accept boolean optional Tự động chấp nhận chuyến đi (Tự động: 1, Tắt: 2, Khoá: 3). Example: 1
     * @bodyParam vehicle_company string optional Hãng xe. Example: Toyota
     * @bodyParam name string required Tên xe. Example: Vios
     * @bodyParam price integer required Giá thuê. Example: 500000
     * @bodyParam vehicle_registration_front file required Ảnh mặt trước đăng ký xe. Example: vehicle_registration_front.jpg
     * @bodyParam vehicle_registration_back file required Ảnh mặt sau đăng ký xe. Example: vehicle_registration_back.jpg
     * @bodyParam vehicle_front_image file required Ảnh mặt trước xe. Example: vehicle_front_image.jpg
     * @bodyParam vehicle_back_image file required Ảnh mặt sau xe. Example: vehicle_back_image.jpg
     * @bodyParam vehicle_side_image file required Ảnh bên hông xe. Example: vehicle_side_image.jpg
     * @bodyParam vehicle_interior_image file required Ảnh nội thất xe. Example: vehicle_interior_image.jpg
     * @bodyParam insurance_front_image file required Ảnh mặt trước bảo hiểm xe. Example: insurance_front_image.jpg
     * @bodyParam insurance_back_image file required Ảnh mặt sau bảo hiểm xe. Example: insurance_back_image.jpg
     * @bodyParam color string required Màu xe. Example: Đen
     * @bodyParam seat_number integer required Số ghế. Example: 4
     * @bodyParam type string optional Loại xe (Chưa phân loại: 1, Xe gắn máy: 2, Ô tô: 3, Xe tải: 4, Xe tải đông lạnh: 5). Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Kiểm tra lại các trường."
     * }
     *
     * @response 422 {
     *     "status": 422,
     *     "error": "Registration failed."
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

        return $this->respondWithToken($accessToken, $refreshToken, $user);
    }
}
