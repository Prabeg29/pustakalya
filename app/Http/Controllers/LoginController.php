<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $user = User::firstWhere('username', $request->username);
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => "Failed",
                "message" => "Invalid credentials"
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            "status" => "Success",
            "message" => "Successful Login",
            "tokenType" => "Bearer",
            "accessToken" => $token
        ], 200);

    }
}
