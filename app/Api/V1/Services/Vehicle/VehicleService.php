<?php

namespace App\Api\V1\Services\Vehicle;

use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;
use App\Traits\UseLog;

class VehicleService implements VehicleServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected VehicleRepositoryInterface $repository;


    public function __construct(
        VehicleRepositoryInterface $repository,
    )
    {
        $this->repository = $repository;
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
        return $this->repository->update($id, ['is_deleted' => 1]);
    }
}
