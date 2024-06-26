<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\BookOrderRequest;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Đơn hàng
 */
class OrderController extends Controller
{
    use Response, UseLog;

    public function __construct(
        OrderRepositoryInterface $repository,
        OrderServiceInterface    $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function createBookOrder(BookOrderRequest $request): JsonResponse
    {
        try {
            $response = $this->service->createBookOrder($request);
            return $this->jsonResponseSuccess($response);
        } catch (Exception $e) {
            $this->logError('Order creation failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }


}
