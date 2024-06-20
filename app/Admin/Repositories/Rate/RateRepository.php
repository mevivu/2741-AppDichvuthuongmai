<?php

namespace App\Admin\Repositories\Rate;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Rate\RateRepositoryInterface;
use App\Models\Rates;

class RateRepository extends EloquentRepository implements RateRepositoryInterface
{
    public function getModel(){
        return Rates::class;
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
    public function findBy(array $filter, array $relations = [])
    {

        $this->instance = $this->model;

        $this->applyFilters($filter);

        $this->instance = $this->instance->with($relations)->first();

        return $this->instance;
    }
}
