<?php

namespace App\Admin\Http\Requests\Vehicle;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Vehicle\VehicleType;
use BenSampo\Enum\Rules\EnumValue;

class VehicleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'name' => ['required', 'string'],
            'brand' => ['required','string'],
            'color' => ['required','string'],
            'seat_number' => ['required','integer'],
            'license_plate' => ['required','string', 'max:250'],
            'type' => ['required', new EnumValue(VehicleType::class, false)],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Vehicle,id'],
            'user_id' => ['required', 'exists:App\Models\User,id'],
            'name' => ['required', 'string'],
            'brand' => ['required','string'],
            'color' => ['required','string'],
            'seat_number' => ['required','integer'],
            'license_plate' => ['required','string', 'max:250'],
            'type' => ['required', new EnumValue(VehicleType::class, false)],
        ];
    }
}
