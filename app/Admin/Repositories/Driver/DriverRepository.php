<?php

namespace App\Admin\Repositories\Driver;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Models\Driver;
use Carbon\Carbon;

class DriverRepository extends EloquentRepository implements DriverRepositoryInterface
{
    public function getModel(): string
    {
        return Driver::class;
    }

    public function count(){
        return $this->model->count();
    }
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10){

        $this->instance = $this->model;

        $this->getQueryBuilderFindByKey($keySearch);

        $this->applyFilters($meta);

        return $this->instance->driver()->limit($limit)->get();
    }
    protected function getQueryBuilderFindByKey($key): void
    {

        $this->instance = $this->instance->whereHas('user', function ($query) use ($key) {
            $query->where('phone', 'LIKE', "%$key%")
                ->orWhere('email', 'LIKE', "%$key%")
                ->orWhere('fullname', 'LIKE', "%$key%");
        });
    }



}
