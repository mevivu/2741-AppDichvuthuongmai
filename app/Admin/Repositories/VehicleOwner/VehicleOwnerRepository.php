<?php

namespace App\Admin\Repositories\VehicleOwner;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\VehicleOwner\VehicleOwnerRepositoryInterface;
use App\Models\VehicleOwner;

class VehicleOwnerRepository extends EloquentRepository implements VehicleOwnerRepositoryInterface
{
    protected $select = [];

    public function getModel(): string
    {
        return VehicleOwner::class;
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model->where('name', 'like', '%' . $keySearch . '%');

        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }
}
