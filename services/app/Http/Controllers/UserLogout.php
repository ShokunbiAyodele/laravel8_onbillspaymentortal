<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserLogout extends Controller
{
    public function UserLogOut(){
        Auth::logout();
        $notification = array(
            'message'  => 'you are successfully loged out',
            'alert-type'  => 'info'
        );
        return redirect()->route('home')->with($notification);
    }
}
