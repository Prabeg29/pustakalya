<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UserNotRegisteredException;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UserRegistrationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegistrationRequest $request)
    {
        try{
            $registeredUser = $this->userService->registerUser($request->except('confirmPassword'));
        }
        catch (UserNotRegisteredException $exception){
            return response()->json([
                "message" => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        event(new Registered($registeredUser["user"]));
        return response()->json([
            "status" => "User Registration Successful",
            "user" => $registeredUser["user"],
            "token" => $registeredUser["token"]
        ], Response::HTTP_CREATED);
    }
}
