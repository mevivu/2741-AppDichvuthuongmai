<?php

namespace App\Api\V1\Http\Resources\Cart;

use App\Api\V1\Http\Resources\Product\ProductResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->product),
            'qty' => $this->qty,
            'toppings' => $this->toppings
        ];
    }
}
