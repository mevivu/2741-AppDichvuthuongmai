<?php

namespace App\Api\V1\Http\Requests\Order;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Validation\Rules\Enum;


class RentVehicleOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'start_latitude' => ['required', 'numeric'],
            'start_longitude' => ['required', 'numeric'],
            'end_latitude' => ['nullable', 'numeric'],
            'end_longitude' => ['nullable', 'numeric'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }


}
