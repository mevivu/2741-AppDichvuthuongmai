<?php

namespace App\Admin\Services\OrderItemTopping;

use App\Admin\Repositories\OrderItemTopping\OrderItemToppingRepositoryInterface;
use App\Admin\Services\Area\AreaServiceInterface;
use Exception;
use Illuminate\Http\Request;

class OrderItemToppingService implements AreaServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(OrderItemToppingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $data = $request->validated();
        $bounds = getBoundsByName($data['address']);
        if ($bounds) {
            $data['boundaries'] = json_encode($bounds);
        }

        return $this->repository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request)
    {

        $data = $request->validated();
        $bounds = getBoundsByName($data['address']);
        if ($bounds) {
            $data['boundaries'] = json_encode($bounds);
        }

        return $this->repository->update($data['id'], $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
