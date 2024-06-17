<?php

namespace App\Admin\Http\Requests\Driver;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverStatus;
use App\Models\Driver;
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
            'user_info.phone' => ['required', 'string', 'unique:users,phone'],
            'user_info.email' => ['required', 'string', 'email', 'unique:users,email'],
            'user_lat' => 'nullable',
            'user_lng' => 'nullable',
            'user_address' => 'nullable',

        ];
    }
    public function driver()
    {
        return Driver::find($this->id);
    }

    protected function methodPut(): array
    {
        $driver = $this->driver();
        $user_id = $driver ? $driver->user_id : null;
        return [
            'id' => ['required', 'exists:App\Models\Driver,id'],
            'id_card' => 'required|string|max:50|unique:drivers,id_card,' . $this->id . ',id',
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
            'user_info.phone' => ['required', 'string', 'unique:users,phone'],
            'user_info.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user_id, 'id')
            ],
            'user_lat' => 'nullable',
            'user_lng' => 'nullable',
            'user_address' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.unique' => __('This user has already registered as a driver.'),
            'user_info.phone.unique' => __('exist_phone'),
            'user_info.email.unique' => __('exist_email')
        ];
    }
}
