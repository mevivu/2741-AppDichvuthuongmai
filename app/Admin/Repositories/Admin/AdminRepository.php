<?php

namespace App\Admin\Repositories\Admin;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{

    protected $select = [];

    public function getModel(){
        return Admin::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->with('roles')->orderBy($column, $sort);
        return $this->instance;
    }
	public function getAllRoles() {
		return Role::all();
	}
	
	public function getAllRolesByGuardName($guardName) {
		return Role::where('guard_name', $guardName)->get();
	}
	
	public function syncAdminRoles($adminid, $rolesRequestArray) {
		$admin = Admin::findOrFail($adminid); // Tìm trong Model Admin có admin id không
		$admin->syncRoles($rolesRequestArray); // Đồng bộ lại các Roles của Admin
        return 1;
	}

}