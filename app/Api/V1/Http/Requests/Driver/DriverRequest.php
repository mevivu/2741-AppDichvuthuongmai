<?php

namespace App\Api\V1\Http\Requests\Driver;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Driver\AutoAccept;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Validation\Rules\Enum;

class DriverRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            //userinfo
            'fullname' => ['required', 'string'],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:users,phone'],
            'email' => ['required', 'email', 'unique:users,email'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'birthday' => 'nullable',

            //driverinfo
            'id_card' => ['required', 'string', 'regex:/^\d{12}$/', 'unique:drivers,id_card'],
            'license_plate' => ['required', 'string', 'unique:vehicles,license_plate'],
            'id_card_front' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'id_card_back' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'license_plate_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'driver_license_front' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'driver_license_back' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'bank_name' => ['required', 'string'],
            'bank_account_name' => ['required', 'string'],
            'bank_account_number' => ['required', 'string', 'max:20'],
            'current_address' => ['required'],
            'current_lat' => ['required'],
            'current_lng' => ['required'],
            'auto_accept' => ['nullable ', new Enum(AutoAccept::class)],

            //vehicleinfo
            'vehicle_company' => ['required', 'string'],
            'name' => ['required', 'string'],
            'vehicle_registration_front' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_registration_back' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_front_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_back_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_side_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'vehicle_interior_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'insurance_front_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'insurance_back_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'type' => ['nullable', new Enum(VehicleType::class)],
        ];
    }
}
