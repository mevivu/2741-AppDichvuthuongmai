<?php

namespace App\Api\V1\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Support\AuthSupport;

class ShowProductVariationResource extends JsonResource
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
        $discount = 1 - $this->getDiscountProduct() / 100;
        $data = [
            'id' => $this->id,
            'price' => $this->price * $discount,
            'promotion_price' => $this->promotion_price * $discount ?: null,
            'image' => asset($this->image)
        ];

        return $data;
    }
}
