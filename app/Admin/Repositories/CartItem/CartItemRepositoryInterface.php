<?php

namespace App\Admin\Repositories\CartItem;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface CartItemRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
}
