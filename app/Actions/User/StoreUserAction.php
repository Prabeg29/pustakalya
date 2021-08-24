<?php


namespace App\Actions;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreUserAction
{
    private $user;

    /**
     * @param UserRegisterRequest $request
     * @return mixed
     */
    public function execute(UserRegisterRequest $request)
    {
        $this->user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ]);
        return $this->user;
    }
}
