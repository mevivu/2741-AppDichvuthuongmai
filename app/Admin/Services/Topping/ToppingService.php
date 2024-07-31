<?php

namespace App\Admin\Services\Topping;

use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Models\Topping;
use Illuminate\Http\Request;


class ToppingService implements ToppingServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(ToppingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $obligatory = $request->filled('obligatory') ? 0 : 1;
        $this->data = $request->validated();
        $this->data['obligatory'] = $obligatory;
        if (isset($this->data['products_id'])) {
            $products = $this->data['products_id'];
            unset($this->data['products_id']);
        } else {
            $products = array();
        }

        $topping = $this->repository->create($this->data);
        // Lấy ID của topping mới tạo

        $this->repository->attachProducts($topping, $products);
        return $topping;
    }

    public function update(Request $request)
    {
        $obligatory = $request->filled('obligatory') ? 0 : 1;
        $this->data = $request->validated();
        $this->data['obligatory'] = $obligatory;
        if (isset($this->data['products_id'])) {
            $products = $this->data['products_id'];
            unset($this->data['products_id']);
        } else {
            $products = array();
        }
        $topping = $this->repository->update($this->data['id'], $this->data);

        $this->repository->syncProducts($topping, $products);

        return $topping;
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
    public function counttopping($id)
    {
        $result = Topping::where('store_id', $id)->get();
        return $result;
    }

}