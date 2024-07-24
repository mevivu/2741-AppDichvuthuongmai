<?php

namespace App\Api\V1\Http\Resources\Topping;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Repositories\Topping\ToppingRepositoryInterface;

class ShowToppingResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'status' => $this->status,
            'avatar' => $this->avatar
        ];
    }
}