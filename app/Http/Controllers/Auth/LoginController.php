<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\UserService;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(UserLoginRequest $request)
    {
        $auth = $this->userService->loginUser($request->all());
        if(!$auth)
        {
            return response()->json([
                "status" => "Login Failed",
                "message" => "Invalid Credentials"
            ], 401);
        }
        return response()->json([
            "status" => "Login Success",
            "tokenType" => "Bearer",
            "token" => $auth["token"],
            "user" => $auth["user"],
        ], 200);
    }
}
