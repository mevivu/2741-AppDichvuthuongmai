<?php

namespace App\Admin\Repositories\Store;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface StoreRepositoryInterface extends EloquentRepositoryInterface
{
    public function count();
    public function searchAllLimit($value = '', $meta = [], $limit = 10);
}
