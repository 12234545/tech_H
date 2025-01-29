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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'profile_photo' => 'required|image',
            'password' => 'required|exists:themes,id',
        ]);

        $imagePath = $request->file('profile_photo')->store('public/profil');
        $name = $validated['firstname'] . ' ' . $validated['lastname'];
        $article = User::create([
            'name' => $name,
            'email' => $validated['email'],
            'profile_photo' => Storage::url($imagePath),
            'password' => Hash::make($validated['password']),

        ]);

    }



}
