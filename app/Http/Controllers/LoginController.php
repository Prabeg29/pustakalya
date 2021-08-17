<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $validatedLoginData = $request->validated();
        $user = User::firstWhere('username', $validatedLoginData['username']);
        if(!$user || !Hash::check($validatedLoginData['password'], $user->password)) {
            return response()->json([
                "status" => "Failed",
                "message" => "Invalid credentials"
            ], 401);
        }
        return response()->json([
            "status" => "Success",
            "message" => "Successful Login",
            "token" => $user->tokens[0]->token
        ], 200);

    }
}
