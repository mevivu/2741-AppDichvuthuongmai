<?php

namespace App\Api\V1\Http\Requests\Product;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Product\ProductInStock;
use App\Enums\Product\ProductStatus;
use App\Enums\Product\ProductType;
use Illuminate\Validation\Rules\Enum;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        if($this->routeIs('api.v1.product.show')){
            return [
                'id' => ['required', 'exists:App\Models\Product,id']
            ];
        }elseif($this->routeIs('api.v1.product.index') || $this->routeIs('api.v1.product.auth.index')){
            return [
                'keywords' => ['nullable', 'string'],
                'page' => ['nullable'],
                'limit' => ['nullable'],
                'store_id' => ['nullable', 'exists:App\Models\Store,id']
            ];
        }
    }

    protected function methodPost()
    {
        $this->validate = [
            'product.name' => ['required', 'string'],
            'product.desc' => ['nullable'],
            'categories_id' => ['nullable', 'array'],
            'categories_id.*' => ['nullable', 'exists:App\Models\Category,id'],
            'product.avatar' => ['required'],
            'product.price' => ['nullable', 'numeric'],
            'product.promotion_price' => ['nullable', 'numeric'],
            'product.type' => ['required', new Enum(ProductType::class)],
            'product.in_stock' => ['required', new Enum(ProductInStock::class)],
            'product.is_active' => ['required', new Enum(ProductStatus::class)],
            'product.gallery' => ['nullable'],
            'toppings_id' => ['nullable', 'array'],
            'toppings_id.*' => ['nullable', 'exists:App\Models\Topping,id'],
            'discount_ids' => ['nullable', 'array'],
            'discount_ids.*' => ['nullable', 'exists:App\Models\Discount,id'],
        ];
        if ($this->input('product.type') == ProductType::Simple->value) {
            $this->validate['product.price'] = ['required', 'numeric'];
        } elseif ($this->input('product.type') == ProductType::Variable->value) {
            $this->validate['product_attribute.attribute_id'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_id.*'] = ['required', 'exists:App\Models\Attribute,id'];
            $this->validate['product_attribute.attribute_variation_id'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_variation_id.*'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_variation_id.*.*'] = ['required', 'exists:App\Models\AttributeVariation,id'];
            $this->validate['products_variations.attribute_variation_id'] = ['nullable', 'array'];
            if ($this->input('products_variations.attribute_variation_id') && count($this->input('products_variations.attribute_variation_id')) > 0) {
                $this->validate['products_variations.id'] = ['required', 'array'];
                $this->validate['products_variations.id.*'] = ['required', 'integer'];
                $this->validate['products_variations.attribute_variation_id'] = ['nullable', 'array'];
                $this->validate['products_variations.attribute_variation_id.*'] = ['required', 'array'];
                $this->validate['products_variations.attribute_variation_id.*.*'] = ['required', 'exists:App\Models\AttributeVariation,id'];
                $this->validate['products_variations.image'] = ['required', 'array'];
                $this->validate['products_variations.price'] = ['required', 'array'];
                $this->validate['products_variations.price.*'] = ['required', 'numeric'];
                $this->validate['products_variations.promotion_price'] = ['nullable', 'array'];
                $this->validate['products_variations.promotion_price.*'] = ['nullable', 'numeric'];
            }
        }
        return $this->validate;
    }

    protected function methodPut()
    {
        $this->validate = [
            'product.id' => ['required', 'exists:App\Models\Product,id'],
            'product.name' => ['nullable', 'string'],
            'product.desc' => ['nullable'],
            'categories_id' => ['nullable', 'array'],
            'categories_id.*' => ['nullable', 'exists:App\Models\Category,id'],
            'product.avatar' => ['nullable'],
            'product.price' => ['nullable', 'numeric'],
            'product.promotion_price' => ['nullable', 'numeric'],
            'product.type' => ['nullable', new Enum(ProductType::class)],
            'product.in_stock' => ['nullable', new Enum(ProductInStock::class)],
            'product.is_active' => ['nullable', new Enum(ProductStatus::class)],
            'product.gallery' => ['nullable'],
            'toppings_id' => ['nullable', 'array'],
            'toppings_id.*' => ['nullable', 'exists:App\Models\Topping,id'],
            'discount_ids' => ['nullable', 'array'],
            'discount_ids.*' => ['nullable', 'exists:App\Models\Discount,id'],
        ];
        if ($this->input('product.type') == ProductType::Simple->value) {
            $this->validate['product.price'] = ['nullable', 'numeric'];
        } elseif ($this->input('product.type') == ProductType::Variable->value) {
            $this->validate['product_attribute.attribute_id'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_id.*'] = ['required', 'exists:App\Models\Attribute,id'];
            $this->validate['product_attribute.attribute_variation_id'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_variation_id.*'] = ['required', 'array'];
            $this->validate['product_attribute.attribute_variation_id.*.*'] = ['required', 'exists:App\Models\AttributeVariation,id'];
            $this->validate['products_variations.attribute_variation_id'] = ['nullable', 'array'];
            if ($this->input('products_variations.attribute_variation_id') && count($this->input('products_variations.attribute_variation_id')) > 0) {
                $this->validate['products_variations.id'] = ['required', 'array'];
                $this->validate['products_variations.id.*'] = ['required', 'integer'];
                $this->validate['products_variations.attribute_variation_id'] = ['nullable', 'array'];
                $this->validate['products_variations.attribute_variation_id.*'] = ['required', 'array'];
                $this->validate['products_variations.attribute_variation_id.*.*'] = ['required', 'exists:App\Models\AttributeVariation,id'];
                $this->validate['products_variations.image'] = ['required', 'array'];
                $this->validate['products_variations.price'] = ['required', 'array'];
                $this->validate['products_variations.price.*'] = ['required', 'numeric'];
                $this->validate['products_variations.promotion_price'] = ['nullable', 'array'];
                $this->validate['products_variations.promotion_price.*'] = ['nullable', 'numeric'];
            }
        }
        return $this->validate;
    }
}
