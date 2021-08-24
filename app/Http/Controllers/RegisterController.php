<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;

class RegisterController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @param \UserRegisterAction $userRegisterAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request, StoreUserAction $userRegisterAction)
    {
        $arr[] = $userRegisterAction->execute($request);
        dd($arr);
        return response()->json([
            "status" => "Success",
            "user" => $user,
            "token" => $token
        ], 201);
    }
}
