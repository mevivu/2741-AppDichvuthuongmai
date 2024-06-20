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

class OrderRequest extends BaseRequest
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
    protected function methodGet(): array
    {
        $areas = $this->areaRepository->getBy(['status' => AreaStatus::On]);
        $areaRule = new CoordinateInArea($areas);
        return [
            'distance' => ['required'],
            'payment_method' => ['required'],
            'shipping_method' => ['required'],
            'sub_total' => ['required'],
            'coordinates' => ['required', $areaRule],

        ];
    }
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $data['coordinates'] = ['lat' => floatval($this->input('lat')), 'lng' => floatval($this->input('lng'))];
        return $data;
    }

    protected function methodPost(): array
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'driver_assignment' => 'required|in:1,2',
            'driver_id' => [
                'required_if:driver_assignment,2',
                'nullable',
                'exists:user_driver_info,id'
            ],
            'store_id' => 'required|exists:stores,id',
            'shipping_method' => ['required', new Enum(ShippingMethod::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'sub_total' => 'required|numeric',
            'transport_fee' => 'nullable|numeric',
            'total' => 'required|numeric',
            'system_revenue' => 'nullable|numeric',
            'status' => ['required', new Enum(OrderStatus::class)],
            'pickup_address' => ['nullable'],
            'destination_address' => ['required'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],


        ];
    }

    protected function methodPut(): array
    {
        $areas = $this->areaRepository->getBy(['status' => AreaStatus::On]);
        $areaRule = new CoordinateInArea($areas);
        return [
            'id' => ['required', 'exists:App\Models\Order,id'],
            'customer_id' => 'required|exists:users,id',
            'driver_id' => 'nullable|exists:user_driver_info,id',
            'store_id' => 'required|exists:stores,id',
//            'shipping_address' => 'required|string',
            'shipping_method' => ['required', new Enum(ShippingMethod::class)],
            'payment_method' => ['required', new Enum(PaymentMethod::class)],
            'sub_total' => ['required'],
            'transport_fee' => ['nullable'],
            'total' => ['required'],
            'status' => ['required', new Enum(OrderStatus::class)],
            'system_revenue' => ['required'],
            'pickup_address' => ['nullable'],
            'destination_address' => ['required'],
            'coordinates' => ['required', $areaRule],
            'note' => ['nullable']

        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required_if' => 'A driver must be selected for manual assignment.',
        ];
    }
}
