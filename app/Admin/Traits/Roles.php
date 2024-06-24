<?php

namespace App\Admin\Traits;

use App\Enums\Role\Role;

trait Roles
{
    public function getRoleCustomer(): string
    {
        return Role::Customer->value;
    }

    public function getRoleSupperAdmin(): string
    {
        return Role::Driver->value;
    }

    public function getRoleDriver(): string
    {
        return Role::Driver->value;
    }
}
