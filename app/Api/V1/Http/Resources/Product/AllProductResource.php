<?php

namespace App\Api\V1\Http\Resources\Product;

use App\Enums\Product\ProductType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Api\V1\Support\AuthSupport;

class AllProductResource extends ResourceCollection
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
        return $this->collection->map(function($product) use ($discount){
            $discount = $product->is_user_discount == true ? $discount : 1;
            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'in_stock' => $product->in_stock,
                'avatar' => asset($product->avatar)
            ];
            if($product->type == ProductType::Simple()){

                $data['price'] = $product->price * $discount;
                $data['promotion_price'] = $product->promotion_price * $discount ?: null;

            }elseif($product->productVariations){
                if($product->productVariations->count() == 1){
                    $data['price'] = $product->productVariations[0]->price * $discount;
                    $data['promotion_price'] = $product->productVariations[0]->promotion_price * $discount ?: null;

                }elseif($product->productVariations->count() > 1){
                    $price_variation = array_column($product->productVariations->toArray(), 'price');
                    $promotion_price_variation = array_column($product->productVariations->toArray(), 'promotion_price');

                    $data['min_promotion_price'] = min($promotion_price_variation) * $discount ?: null;
                    $data['min_price'] = min($price_variation) * $discount;
                    $data['max_price'] = max($price_variation) * $discount;
                }
            }
            return $data;
        });
    }
}
