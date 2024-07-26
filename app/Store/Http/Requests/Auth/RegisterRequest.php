<?php

namespace App\Store\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'category_id' => ['required', 'exists:App\Models\StoreCategory,id'],
            'area_id' => ['required', 'exists:App\Models\Area,id'],
            'username' => [
                'required', 
                'string', 'min:3', 'max:50',
                'unique:App\Models\Store,username', 
                'regex:/^[A-Za-z0-9_-]+$/',
                function ($attribute, $value, $fail) {
                    if (in_array(strtolower($value), ['admin', 'user', 'password'])) {
                        $fail('The '.$attribute.' cannot be a common keyword.');
                    }
                },
            ],
            'password' => ['required', 'string', 'confirmed'],
            'tax_code' => ['required', 'string'],
            'store_name' => ['required', 'string'],
            'store_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\Store,store_phone'],
            'contact_name' => ['required', 'string'],
            'contact_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/'],
            'address' => ['required'],
            'address_detail' => ['nullable'], 
            'open_hours_1' => ['required', 'date_format:H:i'], 
            'close_hours_1' => ['required', 'date_format:H:i'], 
            'open_hours_2' => ['nullable', 'date_format:H:i'], 
            'close_hours_2' => ['nullable', 'date_format:H:i'], 
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric']
        ];
    }
}
