<?php

namespace App\Admin\Repositories\Vehicle;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface VehicleRepositoryInterface extends EloquentRepositoryInterface
{
    // public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
	public function getQueryBuilderWithRelations($relations = ['user']);
	public function findOrFailWithRelations($id, array $relations = ['user']);
}
