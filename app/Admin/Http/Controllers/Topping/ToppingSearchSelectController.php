<?php

namespace App\Admin\Http\Controllers\Topping;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\Topping\ToppingRepositoryInterface;
use App\Admin\Http\Resources\Topping\ToppingSearchSelectResource;

class ToppingSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        ToppingRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(){
        $this->instance = [
            'results' => ToppingSearchSelectResource::collection($this->instance)
        ];
    }
}
