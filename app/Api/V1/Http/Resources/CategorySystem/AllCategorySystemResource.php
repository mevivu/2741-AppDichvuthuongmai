<?php

namespace App\Api\V1\Http\Resources\CategorySystem;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllCategorySystemResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($category_system) {

            return [
                'id' => $category_system->id,
                'name' => $category_system->name,
                'avatar' => $category_system->avatar
            ];

        });
    }
}