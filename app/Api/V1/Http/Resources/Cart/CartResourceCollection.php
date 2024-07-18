<?php

namespace App\Api\V1\Http\Resources\Cart;

use App\Api\V1\Http\Resources\Store\StoreResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $groupedByStore = $this->collection->groupBy(function ($cartItem) {
            return $cartItem->product->store->id;
        });

        $carts = $groupedByStore->map(function ($cartItems) {
            $store = $cartItems->first()->product->store;
            $cartItemsFormatted = $cartItems->map(function ($cartItem) {
                return new CartItemResource($cartItem);
            });

            return [
                'store' => new StoreResource($store),
                'cart_items' => $cartItemsFormatted
            ];
        });

        return [
            'carts' => $carts->values()->all()
        ];
    }
}
