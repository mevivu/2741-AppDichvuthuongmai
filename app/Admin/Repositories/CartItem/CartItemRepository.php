<?php

namespace App\Admin\Repositories\CartItem;
use App\Admin\Repositories\EloquentRepository;

use App\Models\CartItem;

class CartItemRepository extends EloquentRepository implements CartItemRepositoryInterface
{
    public function getModel(): string
    {
        return CartItem::class;
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
