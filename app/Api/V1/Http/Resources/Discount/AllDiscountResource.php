<?php

namespace App\Api\V1\Http\Resources\Discount;

use Illuminate\Http\Resources\Json\JsonResource;

class AllDiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'max_usage' => $this->max_usage,
            'min_order_amount' => $this->min_order_amount,
            'type' => $this->type,
            'discount_value' => $this->discount_value,
            'status' => $this->status,
        ];
    }
}
