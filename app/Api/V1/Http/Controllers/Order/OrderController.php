<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\BookOrderRequest;
use App\Api\V1\Http\Requests\Order\RentVehicleOrderRequest;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Traits\JwtService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Đơn hàng
 */
class OrderController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    protected $auth;
    private $login;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        OrderServiceInterface    $service
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

    public function createBookOrder(BookOrderRequest $request): JsonResponse
    {
        try {
            $this->service->createBookOrder($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Order creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }

    /**
     * Thêm mới đơn thuê xe
     *
     * API này dùng để Thêm mới đơn thuê xe
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @bodyParam vehicle_id int required ID của phương tiện. Example: 1
     * @bodyParam start_date date optional Ngày bắt đầu. Example: 2024-07-26
     * @bodyParam end_date date optional Ngày kết thúc (phải sau hoặc bằng ngày bắt đầu). Example: 2024-07-27
     * @bodyParam payment_method string required Phương thức thanh toán. Example: credit_card
     * @bodyParam total float required Tổng số tiền. Example: 150.0
     * @bodyParam note string nullable Ghi chú (nếu có). Example: Giao hàng từ cửa hàng ABC đến địa chỉ XYZ
     *
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
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */
    public function createRentOrder(RentVehicleOrderRequest $request): JsonResponse
    {
        try {
            $this->service->createRentOrder($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Order creation failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Xoá đơn hàng
     *
     * API này dùng để Xoá đơn hàng
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @pathParam id int required ID của đơn hàng cần xoá. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "ERROR."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "Error."
     * }
     *
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $result = $this->service->delete($id);
            if ($result) {
                return $this->jsonResponseSuccessNoData();
            }
            return $this->jsonResponseError();
        } catch (Exception $e) {
            $this->logError('Order delete failed:', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
