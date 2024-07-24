<?php

namespace App\Admin\Repositories\Topping;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Models\Topping;
use App\Models\Role;
use App\Models\Permission;

class ToppingRepository extends EloquentRepository implements ToppingRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return Topping::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->with('roles')->orderBy($column, $sort);
        return $this->instance;
    }
    public function getAllRoles()
    {
        return Role::all();
    }

    public function getAllRolesByGuardName($guardName)
    {
        return Role::where('guard_name', $guardName)->get();
    }
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model->where('name', 'like', '%' . $keySearch . '%');

        $this->applyFilters($meta);
        return $this->instance->limit($limit)->get();
    }

    public function getFlatTree()
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance
            ->get();
        return $this->instance;
    }
    public function getFlatTreeNotInNode(array $nodeId)
    {
        $this->getQueryBuilderOrderBy('position', 'ASC');
        $this->instance = $this->instance->whereNotIn('id', $nodeId)
            ->withDepth()
            ->get()
            ->toFlatTree();
        return $this->instance;
    }

}