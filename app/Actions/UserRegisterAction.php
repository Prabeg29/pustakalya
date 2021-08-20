<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegisterAction
{
    public function execute(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => Hash::make($request['password'])
        ]);
        $token = $user->createToken('newUserRegister')->plainTextToken;

        return array($user, $token);
    }
}
