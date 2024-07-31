<?php

namespace App\Api\V1\Services\Order;

use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use App\Enums\DefaultStatus;
use App\Enums\Order\OrderType;
use App\Traits\UseLog;

class OrderService implements OrderServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected OrderRepositoryInterface $repository;


    public function __construct(
        OrderRepositoryInterface $repository,
    )
    {
        $this->repository = $repository;
    }


    public function createBookOrder(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $order = $this->repository->create($data);
            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollback();
            $this->logError('Failed to process book order: ', $e);
            return false;
        }
    }

    public function createRentOrder(Request $request): object|bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $data['order_type'] = OrderType::Renting;
            $data['user_id'] = $userId;
            $order = $this->repository->create($data);
            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            $this->logError('Failed to process rent order: ', $e);
            return false;
        }
    }

    public function store(Request $request)
    {

    }


    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        return $this->repository->update($id, ['is_deleted' => DefaultStatus::Deleted]);
    }
}
