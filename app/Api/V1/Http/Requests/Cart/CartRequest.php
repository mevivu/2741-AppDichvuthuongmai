<?php

namespace App\Api\V1\Http\Requests\Cart;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Rules\Topping\ValidTopping;

class CartRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'page' => 'required|integer',
            'limit' => 'sometimes|required|integer|min:1',
        ];
    }

    protected function methodPost(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'topping_ids' => 'nullable|array',
            'topping_ids.*.id' => [
                'required',
                'exists:toppings,id',
                new ValidTopping($this->input('product_id'))
            ],
            'topping_ids.*.quantity' => 'required|integer|min:1'
        ];
    }

    protected function methodPut(): array
    {
        return [
            'id' => 'required|exists:cart_items,id',
            'qty' => 'required|integer|min:1',
        ];
    }

    protected function methodDelete(): array
    {
        return [
            'id' => 'required|exists:cart_items,id',
        ];
    }
}
