<?php

namespace App\Admin\Repositories\Cart;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface CartRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
}
