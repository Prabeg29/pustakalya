<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Services\UserService;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(UserLoginRequest $request)
    {
        $loggedInUserData = $this->userService->loginUser($request->all());
        if(!$loggedInUserData)
        {
            return response()->json([
                "status" => "Login Failed",
                "message" => "Invalid Credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            "status" => "Login Success",
            "tokenType" => "Bearer",
            "token" => $loggedInUserData["token"],
            "user" => $loggedInUserData["user"],
        ], Response::HTTP_OK);
    }
}
