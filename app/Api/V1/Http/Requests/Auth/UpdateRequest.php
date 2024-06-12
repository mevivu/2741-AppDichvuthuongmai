<?php

namespace App\Api\V1\Http\Requests\Auth;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\UserGender;
use BenSampo\Enum\Rules\EnumValue;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        return [
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\User,email,'.$this->user()->id],
            'gender' => ['required', new EnumValue(UserGender::class, false)],
            'address' => ['nullable'],
        ];
    }
}