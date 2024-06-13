<?php

namespace App\Admin\Http\Requests\Driver;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;


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
            'id_card' => ['required', 'string', 'unique:drivers,id_card'],
            'license_plate' => ['nullable', 'string', 'max:20'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'feature_image' => ['nullable'],
            'address' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'auto_accept' => ['nullable ', new Enum(AutoAccept::class)],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'driver_license_front' => ['required'],
            'driver_license_back' => ['required'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_lat' => 'nullable',
            'user_lng' => 'nullable',
            'user_address' => 'nullable',

        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Driver,id'],
            'id_card' => ['required', 'string', 'unique:drivers,id_card,' . $this->id],
            'license_plate' => ['nullable', 'string', 'max:20'],
            'vehicle_company' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['nullable', 'string', 'max:255'],
            'bank_account_number' => ['nullable', 'string', 'max:50'],
            'feature_image' => ['nullable'],
            'address' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
            'auto_accept' => ['nullable ', new Enum(AutoAccept::class)],
            'order_accepted' => ['required ', new Enum(DriverStatus::class)],
            'id_card_front' => ['required'],
            'id_card_back' => ['required'],
            'vehicle_registration_front' => ['required'],
            'vehicle_registration_back' => ['required'],
            'driver_license_front' => ['required'],
            'driver_license_back' => ['required'],
            'user_info' => ['nullable', 'array'],
            'user_info.*' => ['nullable'],
            'user_lat' => 'nullable',
            'user_lng' => 'nullable',
            'user_address' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.unique' => __('This user has already registered as a driver.'),
        ];
    }
}
