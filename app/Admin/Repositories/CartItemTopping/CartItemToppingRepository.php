<?php

namespace App\Admin\Repositories\CartItemTopping;
use App\Admin\Repositories\EloquentRepository;

use App\Models\CartItemTopping;

class CartItemToppingRepository extends EloquentRepository implements CartItemToppingRepositoryInterface
{
    public function getModel(): string
    {
        return CartItemTopping::class;
    }


}
