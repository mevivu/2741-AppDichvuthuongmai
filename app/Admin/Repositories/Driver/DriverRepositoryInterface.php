<?php

namespace App\Admin\Repositories\Driver;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DriverRepositoryInterface extends EloquentRepositoryInterface
{

    public function count();
    public function searchAllLimit($value = '', $meta = [], $limit = 10);


}
