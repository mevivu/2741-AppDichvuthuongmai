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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }
}
