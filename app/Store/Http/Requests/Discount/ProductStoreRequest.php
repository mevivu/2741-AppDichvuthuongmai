<?php

namespace App\Store\Http\Requests\Discount;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\DefaultStatus;
use App\Enums\Product\StockStatus;
use Illuminate\Validation\Rules\Enum;


class ProductStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'name' => ['required', 'string'],
            'store_id' => ['required', 'exists:stores,id'],
            'category_id' => ['required', 'exists:store_categories,id'],
            'sku' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:1'],
            'price_selling' => ['nullable'],
            'price_promotion' => ['nullable'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'in_stock' => ['required', new Enum(StockStatus::class)],
            'desc' => ['required', 'string'],
            'feature_image' => ['nullable', 'file'],
            'discount_ids' => ['nullable','array'],
            'topping_ids' => ['nullable','array'],
            'gallery' => ['nullable'],

        ];
    }

    protected function methodPut(): array
    {
        return [
            'id'=>['required'],
            'name' => ['required', 'string'],
            'sku' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:1'],
            'price_selling' => ['nullable'],
            'price_promotion' => ['nullable'],
            'status' => ['required', new Enum(DefaultStatus::class)],
            'in_stock' => ['required', new Enum(StockStatus::class)],
            'desc' => ['required', 'string'],
            'feature_image' => ['nullable', 'file'],
            'discount_ids' => ['nullable','array'],
            'topping_ids' => ['nullable','array']
        ];
    }
}

