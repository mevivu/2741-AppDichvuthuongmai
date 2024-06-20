<?php

namespace App\Admin\Repositories\OrderItem;
use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderItem;

class OrderItemRepository extends EloquentRepository implements OrderItemRepositoryInterface
{

    public function getModel(): string
    {
        return OrderItem::class;
    }

}
