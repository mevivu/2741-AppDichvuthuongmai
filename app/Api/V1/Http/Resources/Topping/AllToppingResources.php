<?php

namespace App\Api\V1\Http\Resources\Topping;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllToppingResources extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($topping) {

            return [
                'id' => $topping->id,
                'name' => $topping->name,
                'status' => $topping->status,
                'price' => $topping->price,
                'avatar' => asset($topping->avatar),

            ];

        });
    }
}