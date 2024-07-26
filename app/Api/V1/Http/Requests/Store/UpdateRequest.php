<?php

namespace App\Api\V1\Http\Requests\Store;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Support\AuthServiceApi;
use App\Enums\Store\StoreStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends BaseRequest
{
    use AuthServiceApi;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        $store = $this->getCurrentStoreUser();
        return [
            'category_id' => ['nullable', 'exists:store_categories,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'store_name' => ['nullable', 'string'],
            'store_phone' => [
                'nullable', 'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
                Rule::unique('stores', 'store_phone')->ignore($store->id, 'id')
            ],
            'contact_email' => [
                'nullable', 'email',
                Rule::unique('stores', 'contact_email')->ignore($store->id, 'id')
            ],
            'logo' => ['nullable'],
            'address' => ['nullable', 'string'],
            'tax_code' => ['nullable', 'string'],
            'open_hours_1' => ['nullable', 'date_format:H:i'],
            'close_hours_1' => ['nullable', 'date_format:H:i'],
            'open_hours_2' => ['nullable', 'date_format:H:i'],
            'close_hours_2' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable ', new Enum(StoreStatus::class)],
            'priority' => ['nullable', 'integer'],
            'lng' => ['nullable', 'numeric'],
            'lat' => ['nullable', 'numeric'],
        ];
    }
}
