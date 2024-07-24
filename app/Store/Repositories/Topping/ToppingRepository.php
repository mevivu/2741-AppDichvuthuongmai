<?php

namespace App\Store\Repositories\Topping;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Topping;
use App\Traits\AuthService;

class ToppingRepository extends EloquentRepository implements ToppingRepositoryInterface
{
    use AuthService;

    public function getModel(): string
    {
        return Topping::class;
    }


    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {
        $storeId = $this->getCurrentStoreId();

        $this->instance = $this->model->where("store_id", $storeId);

        $this->getQueryBuilderFindByKey($keySearch);

        $this->applyFilters($meta);

        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey($key): void
    {
        $this->instance = $this->instance->where(function ($query) use ($key) {
            return $query->where('name', 'LIKE', '%' . $key . '%');
        });
    }

}
