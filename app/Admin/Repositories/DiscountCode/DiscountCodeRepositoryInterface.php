<?php

namespace App\Admin\Repositories\DiscountCode;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DiscountCodeRepositoryInterface extends EloquentRepositoryInterface
{
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
