<?php

namespace App\Admin\Http\Requests\Discount;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Discount\DiscountStatus;
use BenSampo\Enum\Rules\EnumValue;

class DiscountRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'code' => 'required|max:255|unique:discounts',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'max_usage' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric',
            'type' => 'required|integer',
            'discount_value' => 'required|numeric',
            'store_id' => 'nullable',
            'product_id' => 'nullable',
            'user_id' => 'nullable',
            'driver_id' => 'nullable'
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\DiscountCode,id'],
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'name' => ['required', 'string'],
            'discount' => ['required', 'numeric'],
            'apply_qty' => ['required', 'integer', 'min:1'],
            'maximum_qty' => ['required', 'integer', 'min:1'],
            'apply_date' => ['required', 'date_format:Y-m-d'],
            'expiration_date' => ['required', 'date_format:Y-m-d'],
            'service_applies' => ['nullable', 'string'],
            'conditions' => ['required', 'string'],
            'status' => ['required', new EnumValue(DiscountStatus::class, false)],
            'store_id' => 'nullable',
            'driver_id' => 'nullable',
            'user_id' => 'nullable',
        ];
    }
}
