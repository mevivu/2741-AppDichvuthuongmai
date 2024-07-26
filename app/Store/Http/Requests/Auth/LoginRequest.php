<?php

namespace App\Store\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}