<?php

namespace App\Admin\Http\Requests\Discount;

use App\Admin\Http\Requests\BaseRequest;


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
            'store_ids' => 'nullable|array',
            'store_ids.*' => 'exists:stores,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'driver_ids' => 'nullable|array',
            'driver_ids.*' => 'exists:drivers,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Discount,id'],
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'max_usage' => 'nullable|integer',
            'min_order_amount' => 'nullable|numeric',
            'type' => 'required|integer',
            'discount_value' => 'required|numeric',
            'store_ids' => 'nullable|array',
            'store_ids.*' => 'exists:stores,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
            'driver_ids' => 'nullable|array',
            'driver_ids.*' => 'exists:drivers,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ];
    }
}
