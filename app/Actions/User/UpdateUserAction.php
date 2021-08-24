<?php


namespace App\Actions;


use App\Http\Requests\UserProfileRequest;
use App\Models\User;

class UpdateUserAction
{
    public function handle(UserProfileRequest $request, User $user)
    {
        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "is_admin" => $request->isAdmin,
            "avatar" => $request->avatar
        ]);
        return $user;
    }
}
