<?php

namespace App\Admin\Services\Vehicle;

use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use Illuminate\Http\Request;


class VehicleService implements VehicleServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(VehicleRepositoryInterface $repository)
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