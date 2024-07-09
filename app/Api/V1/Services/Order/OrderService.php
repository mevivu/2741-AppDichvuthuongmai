<?php

namespace App\Api\V1\Services\Order;

use App\Api\V1\Repositories\Order\OrderRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;

class OrderService implements OrderServiceInterface
{
    use AuthSupport, AuthServiceApi;

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


    public function createBookOrder(Request $request): object
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
            DB::rollBack();
            throw $e;
//           return false;
        }
    }

    public function store(Request $request)
    {

    }

    public function cancel(Request $request)
    {

        return $this->repository->cancel($request->input('id'));

    }


    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
