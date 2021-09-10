<?php

namespace App\Services;

use App\Exceptions\UserNotRegisteredException;
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

    /**
     * @param array $userData
     * @return array
     * @throws UserNotRegisteredException
     */
    public function registerUser(array $userData)
    {
        $user = $this->userRepository->create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'username' => $userData['username'],
            'password' => Hash::make($userData['password'])
        ]);
        if(!$user){
            throw new UserNotRegisteredException();
        }
        $token = $user->createToken('registerUser')->plainTextToken;
        return ["user" => $user, "token" => $token];
    }

    /**
     * @param array $credentials
     * @return array|bool
     */
    public function loginUser(array $loginCredentials)
    {
        if(Auth::attempt($loginCredentials)){
            $user = Auth::user();
            $token = $user->createToken('registerUser')->plainTextToken;
            return ["user" => $user, "token" => $token];
        }
        return false;
    }

    /**
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function me($userId)
    {
        return $this->userRepository->findById($userId);
    }

    /**
     * @param array $profileData
     * @param $userId
     * @return bool|\Illuminate\Database\Eloquent\Model|null
     */
    public function updateProfile(array $profileData, $userId)
    {
        $user = $this->userRepository->update($userId, $profileData);
        return $user;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function deleteUser($userId)
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getBooks($userId)
    {
        return $this->me($userId)->books;
    }

    /**
     * @param $request
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function addBooks($request, $userId)
    {
        $user = $this->userRepository->findById($userId);
        $user->books()->sync($request->bookId);
        return $user;
    }
}
