<?php

namespace App\Api\V1\Http\Requests\Store;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Store\StoreStatus;
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
            'category_id' => ['nullable', 'exists:store_categories,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'store_name' => ['required', 'string'],
            'store_phone' => ['required', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/', 'unique:stores,store_phone'],
            'contact_email' => ['nullable', 'email', 'unique:stores,contact_email'],
            'logo' => ['nullable'],
            'address' => ['nullable', 'string'],
            'tax_code' => ['nullable', 'string'],
            'open_hours_1' => ['nullable', 'date_format:H:i'],
            'close_hours_1' => ['nullable', 'date_format:H:i'],
            'open_hours_2' => ['nullable', 'date_format:H:i'],
            'close_hours_2' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable ', new Enum(StoreStatus::class)],
            'priority' => ['nullable', 'integer'],
            'lng' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
        ];
    }
}
