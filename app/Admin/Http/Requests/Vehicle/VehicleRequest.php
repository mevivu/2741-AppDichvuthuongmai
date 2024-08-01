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
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => ['required', 'string', 'unique:vehicles,license_plate'],
            'type' => ['required', new Enum(VehicleType::class)],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'price' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'vehicle_front_image' => ['nullable'],
            'vehicle_back_image' => ['nullable'],
            'vehicle_side_image' => ['nullable'],
            'vehicle_interior_image' => ['nullable'],
            'insurance_front_image' => ['nullable'],
            'insurance_back_image' => ['nullable'],

            'id_card' => ['required', 'string', 'unique:vehicle_owners,id_card'],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'avatar' => ['nullable', 'string'],
            'phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:vehicle_owners,phone'],
            'email' => ['required', 'email', 'unique:vehicle_owners,email'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
            'fullname' => ['required', 'string'],
            'birthday' => ['nullable', 'date'],
            'area_id' => ['nullable', 'integer', 'exists:areas,id'],
        ];
    }


    public function vehicle()
    {
        return Vehicle::find($this->id);
    }

    protected function methodPut(): array
    {
        $vehicle = $this->vehicle();
        $vehicleOwner = $vehicle->vehicle_owner()->first();
        return [
            'id' => ['required', 'exists:App\Models\Vehicle,id'],
            'name' => ['required', 'string'],
            'color' => ['required', 'string'],
            'seat_number' => ['required', 'integer'],
            'license_plate' => [
                'nullable', 'string',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id)
            ],
            'type' => ['required', new Enum(VehicleType::class)],
            'avatar' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'amenities' => ['required', 'string'],
            'id_card' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vehicle_owners', 'id_card')->ignore($vehicleOwner->id)
            ],
            'phone' => [
                'required',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                Rule::unique('vehicle_owners', 'phone')->ignore($vehicleOwner->id)
            ],
            'email' => [
                'required',
                Rule::unique('vehicle_owners', 'email')->ignore($vehicleOwner->id)
            ],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'vehicle_front_image' => ['nullable'],
            'vehicle_back_image' => ['nullable'],
            'vehicle_side_image' => ['nullable'],
            'vehicle_interior_image' => ['nullable'],
            'insurance_front_image' => ['nullable'],
            'insurance_back_image' => ['nullable'],
            'lat' => 'nullable',
            'lng' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
