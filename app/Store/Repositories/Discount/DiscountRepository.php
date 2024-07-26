<?php

namespace App\Store\Repositories\Discount;

use App\Admin\Repositories\EloquentRepository;
use App\Models\Discount;
use App\Traits\AuthService;

class DiscountRepository extends EloquentRepository implements DiscountRepositoryInterface
{
    use AuthService;

    public function getModel(): string
    {
        return Discount::class;
    }


    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10)
    {
        $storeId = $this->getCurrentStoreId();

        $this->instance = $this->model->whereHas('discount_applications', function ($query) use ($storeId) {
            $query->where('store_id', $storeId);
        });

        $this->getQueryBuilderFindByKey($keySearch);

        $this->applyFilters($meta);

        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey($key): void
    {
        $this->instance = $this->instance->where(function ($query) use ($key) {
            return $query->where('code', 'LIKE', '%' . $key . '%');
        });
    }

}
