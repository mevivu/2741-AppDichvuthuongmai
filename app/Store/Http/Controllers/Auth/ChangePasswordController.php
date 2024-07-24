<?php

namespace App\Store\Http\Controllers\Auth;

use App\Admin\Http\Controllers\BaseController;
use App\Store\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends BaseController
{
    //
    public function getView(){
        return [
            'index' => 'stores.auth.password.index'
        ];
    }

    public function index(){

        return view($this->view['index'], [
            'breadcrums' => $this->crums->add(__('passwordChange'))
        ]);
    }

    public function update(ChangePasswordRequest $request){

        $data['password'] = bcrypt($request->input('password'));

        auth('store')->user()->update($data);
        
        return back()->with('success', __('notifySuccess'));
    }
}
