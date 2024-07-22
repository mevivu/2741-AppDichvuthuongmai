<?php

namespace App\Store\Repositories\Discount;
use App\Admin\Repositories\EloquentRepositoryInterface;


interface DiscountRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($value = '', $meta = [], $limit = 10);

}
