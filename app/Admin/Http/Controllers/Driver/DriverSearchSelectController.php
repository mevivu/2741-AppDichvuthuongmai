<?php

namespace App\Admin\Http\Controllers\Driver;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\UserDriver\UserDriverSearchSelectResource;
use App\Admin\Repositories\UserDriver\UserDriverRepositoryInterface;

class DriverSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        UserDriverRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(){
        $this->instance = [
            'results' => UserDriverSearchSelectResource::collection($this->instance)
        ];
    }
}
