<?php

namespace App\Api\V1\Http\Requests\Vehicle;

use App\Api\V1\Http\Requests\BaseRequest;

class VehicleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodGet(): array
    {
        return [
            'type' => ['nullable'],
            'vehicle_company' => ['nullable'],
            'address' => ['nullable'],
        ];
    }
}
