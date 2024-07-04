<?php

namespace App\Admin\Repositories\Vehicle;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Models\Vehicle;

class VehicleRepository extends EloquentRepository implements VehicleRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return Vehicle::class;
    }


}
