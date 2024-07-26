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

    public function createRentOrder(RentVehicleOrderRequest $request): JsonResponse
    {
        try {
            $this->service->createRentOrder($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Order creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }

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
            return $this->jsonResponseError('', 500);
        }
    }
}
