<?php

namespace App\Api\V1\Http\Resources\Topping;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Repositories\Topping\ToppingRepositoryInterface;

class ShowToppingResources extends JsonResource
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
            'status' => $this->status,
            'price' => $this->price,
            'avatar' => asset($this->avatar),

        ];
    }
}