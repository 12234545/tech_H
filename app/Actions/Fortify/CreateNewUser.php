<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        /*
        Validator::make($input, [

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'profile-photo-required'=> ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

        ])->validate();
        */



        $name = $input['firstname'] . ' ' . $input['lastname'];



    return User::create([
        'name' => $name,
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'description' => $input['description']
    ]);
        }



}
