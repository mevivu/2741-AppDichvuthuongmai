<?php

namespace App\Admin\Repositories\StoreCategory;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Models\StoreCategory;

class StoreCategoryRepository extends EloquentRepository implements StoreCategoryRepositoryInterface
{
    public function getModel(): string
    {
        return StoreCategory::class;
    }

    public function getByOrder(array $filter, array $relations = [], $sort = ['id', 'desc'])
    {
        $this->getByQueryBuilder($filter, $relations, $sort);

        return $this->instance->get();
    }

    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {

        $this->instance = $this->model->where('name', 'like', '%' . $keySearch . '%');

        $this->applyFilters($meta);

        return $this->instance->published()->orderBy('position', 'asc')->limit($limit)->get();
    }

    public function getFlatTree()
    {
        $this->getQueryBuilderOrderBy('position', 'ASC');
        $this->instance = $this->instance->published();

        $this->instance = $this->instance->withDepth()
            ->get()
            ->toFlatTree();
        return $this->instance;
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
}
