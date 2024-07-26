<?php

namespace App\Store\Repositories\Product;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface ProductRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $limit = 10);

}
