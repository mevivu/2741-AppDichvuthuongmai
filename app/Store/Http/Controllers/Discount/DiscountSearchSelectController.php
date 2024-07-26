<?php

namespace App\Store\Http\Controllers\Discount;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Store\Http\Resources\Discount\DiscountSearchSelectResource;
use App\Store\Repositories\Discount\DiscountRepositoryInterface;

class DiscountSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        DiscountRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(): void
    {
        $this->instance = [
            'results' => DiscountSearchSelectResource::collection($this->instance)
        ];
    }
}
