<?php

namespace App\Store\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function logout(Request $request){

        auth('store')->logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return redirect()->route('store.login.index')->with('success', __('logoutSuccess'));
    }
}
