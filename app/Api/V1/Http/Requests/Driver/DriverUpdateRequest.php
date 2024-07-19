<?php

namespace App\Api\V1\Http\Requests\Driver;

use App\Api\V1\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class DriverUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'fullname' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'email' => [
                'nullable',
                Rule::unique('users', 'email')->ignore($this->user()->id, 'id')
            ],
            'phone' => [
                'nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                Rule::unique('users', 'phone')->ignore($this->user()->id, 'id')
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'birthday' => ['nullable'],
        ];
    }
}
