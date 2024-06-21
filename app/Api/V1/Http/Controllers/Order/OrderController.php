<?php

namespace App\Api\V1\Http\Controllers\Order;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Order\BookOrderRequest;
use App\Api\V1\Services\Order\OrderServiceInterface;
use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Support\Response;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * @group Đơn hàng
 */
class OrderController extends Controller
{
    use Response;

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
            Log::error('Order creation failed: ' . $e->getMessage());
            return $this->jsonResponseError('', 500);
        }
    }





}
