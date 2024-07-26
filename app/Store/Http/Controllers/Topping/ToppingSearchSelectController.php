<?php

namespace App\Store\Http\Controllers\Topping;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Store\Http\Resources\Topping\ToppingSearchSelectResource;
use App\Store\Repositories\Topping\ToppingRepositoryInterface;

class ToppingSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        ToppingRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => ToppingSearchSelectResource::collection($this->instance)
        ];
    }
}
