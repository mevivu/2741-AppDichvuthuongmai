<?php

namespace App\Api\V1\Http\Requests\Topping;

use App\Api\V1\Http\Requests\BaseRequest;
use BenSampo\Enum\Rules\EnumValue;
use App\Enums\Topping\{ToppingStatus, Obligatory};

class ToppingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            // 'id' => ['required', 'exists:App\Models\Topping,id'],
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
            'avatar' => ['nullable', 'string'],

        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Topping,id'],
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
            'avatar' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodDelete()
    {
        return [
            'id' => ['required', 'exists:App\Models\Topping,id'],
        ];
    }

}