<?php

namespace App\Store\Http\Requests\Topping;

use App\Admin\Http\Requests\BaseRequest;



class ToppingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:191',
            'price' => 'required',
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => 'required',
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:191',
            'price' => 'required',

        ];
    }
}

