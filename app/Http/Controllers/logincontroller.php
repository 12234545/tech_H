<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
