<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Order\OrderStatus;
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
            'user_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:orders,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'status' => ['required', new Enum(OrderStatus::class)],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'total' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }
}
