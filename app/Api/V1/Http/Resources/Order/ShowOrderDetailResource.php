<?php

namespace App\Api\V1\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Api\V1\Support\AuthSupport;
use App\Enums\Product\ProductType;

class ShowOrderDetailResource extends JsonResource
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
            'id' => $this->detail['product']['id'],
            'name' => $this->detail['product']['name'],
            'qty' => $this->qty,
            'unit_price' => $this->unit_price,
            'slug' => $this->detail['product']['slug'],
            'avatar' => $this->detail['product']['avatar']
        ];
        if($this->detail['product']['type'] == ProductType::Variable){
            $data['attribute_variations']  = collect($this->detail['productVariation']['attribute_variations'])->map(function($item){
                return [
                    'id' => $item['id'],
                    'name' => $item['name']
                ];
            });
        }
        return $data;
    }
}
