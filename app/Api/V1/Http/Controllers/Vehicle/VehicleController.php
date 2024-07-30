<?php

namespace App\Api\V1\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Vehicle\VehicleRequest;
use App\Api\V1\Http\Resources\Vehicle\VehicleResource;
use App\Api\V1\Http\Resources\Vehicle\VehicleResourceCollection;
use App\Api\V1\Services\Vehicle\VehicleServiceInterface;
use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Traits\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Phương tiện
 */
class VehicleController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        VehicleRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        VehicleServiceInterface    $service
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->middleware('auth:api');
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
     * Lấy Danh sách xe cho thuê
     *
     * Các loại (type) của xe bao gồm:
     * - 1: Chưa được phân loại
     * - 2: Gắn máy
     * - 3: Xe ô tô
     * - 4: Xe tải
     * - 5: Xe tải đông lạnh
     *
     * Các trạng thái (status) của xe bao gồm:
     * - 1: Chờ xác nhận
     * - 2: Đã thuê
     * - 3: Không hoạt động
     * - 4: Đang sửa chữa
     *
     * API này trả về danh sách xe cho thuê
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @queryParam address string optional Địa chỉ khu vực. Example: 123 Gò Vấp
     * @queryParam type int optional Loại xe. Example: 1
     * @queryParam vehicle_company string optional Hãng xe. Example: Audi
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "vehicles": [
     *              {
     *                  "id": 1,
     *                  "driver_id": 5,
     *                  "name": "Toyota",
     *                  "color": "Xanh dương",
     *                  "type": 3,
     *                  "seat_number": 7,
     *                  "license_plate": "11111",
     *                  "license_plate_image": "public/uploads/images/drivers//h2vUHlF0HsnFVmN5LssabTr1GgWCw9GSuhwFG5c6.jpg",
     *                  "vehicle_company": "123",
     *                  "vehicle_registration_front": "/public/assets/images/default-image.png",
     *                  "vehicle_registration_back": "/public/assets/images/default-image.png",
     *                  "vehicle_front_image": null,
     *                  "vehicle_back_image": null,
     *                  "vehicle_side_image": null,
     *                  "vehicle_interior_image": null,
     *                  "insurance_front_image": null,
     *                  "insurance_back_image": null,
     *                  "amenities": "Tiện ích",
     *                  "description": "Mô tả",
     *                  "created_at": "2024-07-18T09:28:57.000000Z",
     *                  "updated_at": "2024-07-18T09:28:57.000000Z",
     *                  "price": 999999
     *              }
     *          ]
     *      }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */
    public function view(VehicleRequest $request): JsonResponse
    {
        $vehicles = $this->repository->searchVehicle($request);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new VehicleResourceCollection($vehicles)
        ]);
    }

    /**
     * Lấy thông tin chi tiết xe
     *
     * Các loại (type) của xe bao gồm:
     * - 1: Chưa được phân loại
     * - 2: Gắn máy
     * - 3: Xe ô tô
     * - 4: Xe tải
     * - 5: Xe tải đông lạnh
     *
     * Các trạng thái (status) của xe bao gồm:
     * - 1: Chờ xác nhận
     * - 2: Đã thuê
     * - 3: Không hoạt động
     * - 4: Đang sửa chữa
     *
     * API này trả về thông tin chi tiết xe
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @pathParam id int required ID của phương tiện. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 1,
     *          "driver_id": 5,
     *          "name": "Toyota",
     *          "color": "Xanh dương",
     *          "type": 3,
     *          "seat_number": 7,
     *          "license_plate": "11111",
     *          "license_plate_image": "public/uploads/images/drivers//h2vUHlF0HsnFVmN5LssabTr1GgWCw9GSuhwFG5c6.jpg",
     *          "vehicle_company": "Audi",
     *          "vehicle_registration_front": "/public/assets/images/default-image.png",
     *          "vehicle_registration_back": "/public/assets/images/default-image.png",
     *          "vehicle_front_image": null,
     *          "vehicle_back_image": null,
     *          "vehicle_side_image": null,
     *          "vehicle_interior_image": null,
     *          "insurance_front_image": null,
     *          "insurance_back_image": null,
     *          "amenities": "Tiện ích",
     *          "description": "Mô tả",
     *          "created_at": "2024-07-18T09:28:57.000000Z",
     *          "updated_at": "2024-07-18T09:28:57.000000Z",
     *          "price": 999999
     *      }
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $vehicles = $this->repository->findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new VehicleResource($vehicles)
        ]);
    }
}
