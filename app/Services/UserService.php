<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'])
        ];
        $user = $this->userRepository->create($userData);
        $token = $user->createToken('registerUser')->plainTextToken;
        $data = [
            "user" => $user,
            "token" => $token
        ];
        return $data;
    }

    /**
     * @param array $credentials
     * @return array|bool
     */
    public function loginUser(array $credentials)
    {
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('registerUser')->plainTextToken;
            $data = [
                "user" => $user,
                "token" => $token
            ];
            return $data;
        }
        return false;
    }
}
