<?php

namespace App\Api\V1\Http\Requests\Topping;

use App\Api\V1\Http\Requests\BaseRequest;
use BenSampo\Enum\Rules\EnumValue;
<<<<<<< HEAD
use App\Enums\Topping\{Obligatory, ToppingStatus};
=======
use App\Enums\Topping\{ToppingStatus, Obligatory};
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc

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
<<<<<<< HEAD
            'limit' => ['nullable', 'integer', 'min:1']
=======
            'limit' => ['nullable', 'integer', 'min:1'],

>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
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
<<<<<<< HEAD
            'name' => ['required', 'string'],
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
            'price' => ['required', 'numeric'],
            'avatar' => ['nullable', 'string'],
=======
            // 'id' => ['required', 'exists:App\Models\Topping,id'],
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
            'avatar' => ['nullable', 'string'],

>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
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
<<<<<<< HEAD
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
            'price' => ['required', 'numeric'],
=======
            'price' => ['required', 'numeric'],
            'status' => ['required', new EnumValue(ToppingStatus::class, false)],
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
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