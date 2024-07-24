<?php

namespace App\Api\V1\Repositories\Topping;

use App\Admin\Repositories\EloquentRepositoryInterface;


interface ToppingRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByID($id);
    public function paginate($page = 1, $limit = 10);
}