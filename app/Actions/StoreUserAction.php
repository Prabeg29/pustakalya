<?php


namespace App\Actions;


use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreUserAction
{
    public function execute(UserRegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ]);
        $token = $user->createToken('newUserRegistration')->plainTokenText;
        return array("user" => $user, "token" => $token);
    }
}
