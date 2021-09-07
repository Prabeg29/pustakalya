<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        $data = $this->userService->registerUser($request->except('confirmPassword'));
        event(new Registered($data["user"]));
        return response()->json([
            "status" => "Success",
            "user" => $data["user"],
            "token" => $data["token"]
        ], 201);
    }
}
