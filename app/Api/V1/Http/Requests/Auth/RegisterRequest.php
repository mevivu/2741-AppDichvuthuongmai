<?php

namespace App\Api\V1\Http\Requests\Auth;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Store\BossType;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'store_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:stores,store_phone'],
            'password' => ['required', 'string', 'confirmed'],
            'type' => ['required', new Enum(BossType::class)],
            'store_name' => ['required', 'string'],
            'contact_email' => ['required', 'email', 'unique:stores,contact_email'],
            'lat' => ['required'],
            'lng' => ['required'],
            'address' => ['required','string'],
        ];
    }
}
