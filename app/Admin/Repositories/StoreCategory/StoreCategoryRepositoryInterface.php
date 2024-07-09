<?php

namespace App\Admin\Repositories\StoreCategory;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface StoreCategoryRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc']);
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
    public function getFlatTree();
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}
