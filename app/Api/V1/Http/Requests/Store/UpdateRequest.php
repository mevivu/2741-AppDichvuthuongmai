<?php

namespace App\Api\V1\Http\Requests\Store;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\Gender;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'username' => ['required', 'string'],
            'store_name' => 'required|string|max:255',
            // 'store_phone' => 'required|string|max:20',
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email', 'unique:App\Models\User,email,' . $this->user()->id],
            'contact_phone' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address' => ['nullable'],
            'address_detail' => ['nullable'],
            'tax_code' => ['nullable'],
            'lng' => ['nullable'],
            'lat' => ['nullable'],
        ];
    }
}
