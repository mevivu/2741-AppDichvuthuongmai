<?php

namespace App\Store\Services\Product;


use App\Store\Repositories\Product\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        ProductRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $this->data = $request->validated();

        return $this->repository->create($this->data);
    }

    public function update(Request $request): object|bool
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    /**
     * @throws Exception
     */
    public function delete($id): object
    {
        return $this->repository->delete($id);
    }
}
