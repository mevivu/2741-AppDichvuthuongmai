<?php

namespace App\Admin\Services\DiscountCode;

use App\Admin\Services\DiscountCode\DiscountCodeServiceInterface;
use App\Admin\Repositories\DiscountCode\DiscountCodeRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Module;
use Spatie\Permission\Models\Permission;


class DiscountCodeService implements DiscountCodeServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(DiscountCodeRepositoryInterface $repository)
    {

        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $this->data = $request->validated();

        return $this->repository->create($this->data);
    }

    public function update(Request $request)
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    public function delete($id)
    {

        return $this->repository->delete($id);
    }
}
