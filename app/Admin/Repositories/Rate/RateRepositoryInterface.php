<?php

namespace App\Admin\Repositories\Rate;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface RateRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);

    public function findBy(array $array);
}
