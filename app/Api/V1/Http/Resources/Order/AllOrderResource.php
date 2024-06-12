<?php

namespace App\Api\V1\Http\Resources\Order;

use App\Enums\Product\ProductType;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllOrderResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($order){
            $data = [
                'id' => $order->id,
                'total' => $order->total,
                'status' => $order->status,
                'product' => new ShowOrderDetailResource($order->orderDetail)
            ];

            return $data;      
        });
    }
}
