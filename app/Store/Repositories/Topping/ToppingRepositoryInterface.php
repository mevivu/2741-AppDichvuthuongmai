<?php

namespace App\Store\Repositories\Topping;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface ToppingRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $limit = 10);

}
