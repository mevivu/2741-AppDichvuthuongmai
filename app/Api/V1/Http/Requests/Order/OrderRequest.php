<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Order\OrderStatus;
use BenSampo\Enum\Rules\EnumValue;

class OrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'status' => ['nullable', new EnumValue(OrderStatus::class, false)]
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'customer_fullname' => ['required', 'string'],
            'customer_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
            'customer_email' => ['required', 'email'],
            'shipping_address' => ['required'],
            'payment_code' => ['required', 'string'],
            'note' => ['nullable']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Order,id']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodDelete()
    {
        return [

        ];
    }
}