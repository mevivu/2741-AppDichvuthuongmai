<?php

namespace App\Admin\Services\OrderItem;


use App\Admin\Repositories\OrderItem\OrderItemRepositoryInterface;
use Illuminate\Http\Request;

class OrderItemService implements OrderItemServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;


    public function __construct(OrderItemRepositoryInterface $repository,
    )
    {
        $this->repository = $repository;

    }

    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->repository->create($data);
    }


    public function update(Request $request)
    {

        $data = $request->validated();

        return $this->repository->update($data['id'], $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }


}
