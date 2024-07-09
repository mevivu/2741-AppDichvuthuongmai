<?php

namespace App\Admin\Http\Requests\Topping;

use App\Admin\Http\Requests\BaseRequest;
// use App\Enums\DefaultStatus;
// use App\Enums\Product\StockStatus;
// use Illuminate\Validation\Rules\Enum;


class ToppingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => 'required|string|max:191',
            'type' => 'nullable|integer',
            'avatar' => 'required',
            'price' => 'required|integer',
            'status' => 'required',
            'obligatory' => 'nullable',
            'position' => 'nullable',
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => 'required',
            'name' => 'required|string|max:191',
            'type' => 'nullable|integer',
            'avatar' => 'required',
            'price' => 'required|integer',
            'status' => 'required',
            'obligatory' => 'nullable',
            'position' => 'nullable',

        ];
    }
}

