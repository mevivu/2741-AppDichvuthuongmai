<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipping\ShippingMethod;
use Illuminate\Validation\Rules\Enum;


class BookOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'note' => ['nullable'],
            'start_latitude' => ['required','numeric'],
            'start_longitude' => ['required','numeric'],
            'start_address' => ['required'],
            'end_latitude' => ['required','numeric'],
            'end_longitude' => ['required','numeric'],
            'end_address' => ['required'],
            'shipping_method' => ['required',new Enum(ShippingMethod::class)],
            'payment_method' => ['required',new Enum(PaymentMethod::class)],
            'total' => ['required','numeric'],
            'distance' => ['nullable'],
            'total_time' => ['required','numeric'],
            'driver_id' => ['required','exists:drivers,id'],
        ];
    }


}
