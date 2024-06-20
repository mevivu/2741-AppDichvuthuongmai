<?php

namespace App\Admin\Repositories\Order;
use App\Admin\Repositories\EloquentRepository;
use App\Models\OrderItem;

class OrderItemRepository extends EloquentRepository implements OrderItemRepositoryInterface
{

    public function getModel(): string
    {
        return OrderItem::class;
    }
    public function getitem($id){
        $result = OrderItem::where('order_id',$id)->get();
        return  $result;
    }
    
}
