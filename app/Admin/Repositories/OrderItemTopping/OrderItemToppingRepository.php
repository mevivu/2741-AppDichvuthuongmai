<?php

namespace App\Admin\Repositories\OrderItemTopping;

use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderItemTopping;

class OrderItemToppingRepository extends EloquentRepository implements OrderItemToppingRepositoryInterface
{
    public function getModel(): string
    {
        return OrderItemTopping::class;
    }

}
