<?php

namespace App\Api\V1\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Support\AuthSupport;

class ShowOrderResource extends JsonResource
{
    use AuthSupport;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'customer_fullname' => $this->customer_fullname,
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->customer_email,
            'shipping_address' => $this->shipping_address,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'total' => $this->total,
            'payment_code' => $this->payment_code,
            'status' => $this->status,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'order_details' => $this->orderDetails->map(function($orderDetail){
                return new ShowOrderDetailResource($orderDetail);
            })
        ];
        return $data;
    }
}
