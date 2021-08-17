<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password'])
        ]);
        $token = $user->createToken('newUserRegister')->plainTextToken;
        return response()->json([
            "status" => "Success",
            "user" => $user,
            "token" => $token
        ], 201);
    }
}
