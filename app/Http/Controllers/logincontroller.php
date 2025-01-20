<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class logincontroller extends Controller
{
    public function login(){
        return view('auth/login');
    }
    public function singUp(){
        return view('auth/singUp');
    }

    public function logOut(){
        Auth::logout();
        return redirect()->route('login');
    }


}
