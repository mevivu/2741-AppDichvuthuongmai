<?php

namespace App\Admin\Repositories\Vehicle;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Enums\Vehicle\VehicleStatus;
use App\Models\Vehicle;

class VehicleRepository extends EloquentRepository implements VehicleRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return Vehicle::class;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {
        $this->instance = $this->model->where('status', '=', VehicleStatus::Pending)
            ->where('name', 'like', '%' . $keySearch . '%')
            ->whereDoesntHave('driver');

        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }
}
