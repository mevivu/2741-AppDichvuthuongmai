<?php

namespace App\Admin\Http\Controllers\Store\Category;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Repositories\StoreCategory\StoreCategoryRepositoryInterface;
use App\Admin\Http\Resources\StoreCategory\StoreCategorySearchSelectResource;

class StoreCategorySearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        StoreCategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => StoreCategorySearchSelectResource::collection($this->instance)
        ];
    }
}
