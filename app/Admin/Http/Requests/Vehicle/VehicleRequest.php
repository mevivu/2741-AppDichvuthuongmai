<?php

namespace App\Admin\Http\Requests\Vehicle;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Vehicle\VehicleType;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class VehicleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {

        return [
            'name' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => ['required', 'string', 'max:250'],
            'type' => ['required', new Enum(VehicleType::class)],
            'avatar' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'amenities' => ['required', 'string'],
            'price' => ['required'],
            'id_card' => ['required', 'string', 'unique:drivers,id_card'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'driver_license_front' => ['nullable'],
            'driver_license_back' => ['nullable'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_info.phone' => ['required', 'string', 'unique:users,phone'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
        ];
    }

    public function vehicle()
    {
        return Vehicle::find($this->id);
    }

    protected function methodPut(): array
    {
        $vehicle = $this->vehicle();
        $driver = $vehicle->driver()->first();
        $user = $driver->user;
        return [
            'id' => ['required', 'exists:App\Models\Vehicle,id'],
            'name' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => ['required', 'string', 'max:250'],
            'type' => ['required', new Enum(VehicleType::class)],
            'avatar' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'amenities' => ['required', 'string'],
            'price' => ['required'],
            'id_card' => [
                'required',
                'string',
                'max:50',
                Rule::unique('drivers', 'id_card')->ignore($driver->id)
            ],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'driver_license_front' => ['required'],
            'driver_license_back' => ['required'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_info.phone' => [
                'required',
                'string',
                'unique:users,phone,' . $user->id
            ],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
