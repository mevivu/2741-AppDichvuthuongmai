<?php

namespace App\Admin\Repositories\Vehicle;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Models\Vehicle;

class VehicleRepository extends EloquentRepository implements VehicleRepositoryInterface
{
    protected $select = [];

    public function getModel()
    {
        return Vehicle::class;
    }

    // public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    // {
    //     $this->getQueryBuilder();
    //     $this->instance = $this->instance->orderBy($column, $sort);
    //     return $this->instance;
    // }

    public function getQueryBuilderWithRelations($relations = ['user']){
        $this->getQueryBuilder();
        $this->instance = $this->instance->with($relations)->orderBy('id', 'desc');
        return $this->instance;
    }

    public function findOrFailWithRelations($id, array $relations = ['user'])
    {
        $this->findOrFail($id);
        $this->instance = $this->instance->load($relations);
        return $this->instance;
    }
}
