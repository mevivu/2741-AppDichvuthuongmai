<?php

namespace App\Store\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;
use App\Enums\Store\StoreStatus;
use Illuminate\Validation\Rules\Enum;

class ProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        return [
            'logo' => ['nullable', 'file', 'mimes:jpeg,png,jpg'],
            'store_name' => ['required', 'string'],
            'store_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:App\Models\Store,store_phone,'.auth('store')->id()],
            'tax_code' => ['nullable', 'string'],
            'address' => ['required'], 
            'address_detail' => ['nullable'], 
            'open_hours_1' => ['required', 'date_format:H:i'], 
            'close_hours_1' => ['required', 'date_format:H:i'], 
            'open_hours_2' => ['nullable', 'date_format:H:i'], 
            'close_hours_2' => ['nullable', 'date_format:H:i'], 
            'status' => ['required', new Enum(StoreStatus::class)],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric']
        ];
    }
}