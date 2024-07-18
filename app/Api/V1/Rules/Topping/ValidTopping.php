<?php

namespace App\Api\V1\Rules\Topping;


use App\Api\V1\Repositories\Product\ProductRepository;
use Illuminate\Contracts\Validation\Rule;

class ValidTopping implements Rule
{

    protected string $message;
    protected $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
        $this->message = __("invalid_topping");
    }


    public function passes($attribute, $value): bool
    {
        $discountRepository = app(ProductRepository::class);
        $product = $discountRepository->findOrFail($this->productId);

        return $product->toppings()->where('toppings.id', $value)->exists();
    }

    public function message(): string
    {
        return $this->message;
    }
}
