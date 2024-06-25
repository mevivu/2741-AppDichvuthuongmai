<?php

namespace App\Admin\Repositories\Discount;

use App\Admin\Repositories\EloquentRepository;

use App\Models\DiscountApplication;

class DiscountApplicationRepository extends EloquentRepository implements DiscountApplicationRepositoryInterface
{
    public function getModel(): string
    {
        return DiscountApplication::class;
    }




}

