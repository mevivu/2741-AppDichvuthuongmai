<?php

namespace App\Admin\Http\Requests\DiscountCode;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\DiscountCode\DiscountCodeStatus;
use BenSampo\Enum\Rules\EnumValue;

class DiscountCodeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'name' => ['required', 'string'],
            'discount' => ['required', 'numeric'],
            'apply_qty' => ['required', 'integer', 'min:1'],
            'maximum_qty' => ['required', 'integer', 'min:1'],
            'apply_date' => ['required', 'date_format:Y-m-d'],
            'expiration_date' => ['required', 'date_format:Y-m-d'],
            'service_applies' => ['nullable', 'string'],
            'conditions' => ['required', 'string'],
            'status' => ['required', new EnumValue(DiscountCodeStatus::class, false)],
        ];
    }

    protected function methodPut()
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
            'status' => ['required', new EnumValue(DiscountCodeStatus::class, false)],
        ];
    }
}
