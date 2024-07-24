<?php

namespace App\Admin\Repositories\Cart;
use App\Admin\Repositories\EloquentRepository;

use App\Models\Cart;

class CartRepository extends EloquentRepository implements CartRepositoryInterface
{
    public function getModel(): string
    {
        return Cart::class;
    }

    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc'])
    {
        $this->getByQueryBuilder($filter, $relations, $sort);

        return $this->instance->get();
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10){

        $this->instance = $this->model->where('name', 'like', '%'.$keySearch.'%');

        $this->applyFilters($meta);

        return $this->instance->published()->orderBy('position', 'asc')->limit($limit)->get();
    }
}
