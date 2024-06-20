<?php

namespace App\Admin\Http\Requests\Order;

use App\Admin\Http\Requests\BaseRequest;
use App\Admin\Repositories\Area\AreaRepository;
use App\Api\V1\Rules\Area\CoordinateInArea;
use App\Enums\Area\AreaStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\Shipping\ShippingMethod;
use Illuminate\Validation\Rules\Enum;

class OrderStoreRequest extends BaseRequest
{

    protected $areaRepository;

    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    

    protected function methodPut(): array
    {
        $areas = $this->areaRepository->getBy(['status' => AreaStatus::On]);
        $areaRule = new CoordinateInArea($areas);
        return [
            
            'created_at' => ['nullable'],
            'shipping_method' => ['required', new Enum(ShippingMethod::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'sub_total' => ['required'],
            'transport_fee' => ['nullable'],
            'total' => ['required'],
            'system_revenue' => ['required'],
            'pickup_address' => ['nullable'],
            'destination_address' => ['required'],
            'coordinates' => ['nullable', $areaRule],

        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required_if' => 'A driver must be selected for manual assignment.',
        ];
    }
}
