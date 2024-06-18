<?php

namespace App\Admin\Repositories\DiscountCode;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\DiscountCode\DiscountCodeRepositoryInterface;
use App\Models\DiscountCode;

class DiscountCodeRepository extends EloquentRepository implements DiscountCodeRepositoryInterface
{
    protected $select = [];

    public function getModel()
    {
        return DiscountCode::class;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
