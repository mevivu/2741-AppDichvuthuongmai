<?php

namespace App\Store\Http\Controllers\Product;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\Product\ProductSearchSelectResource;
use App\Store\Repositories\Product\ProductRepositoryInterface;

class ProductSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        ProductRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => ProductSearchSelectResource::collection($this->instance)
        ];
    }
}
