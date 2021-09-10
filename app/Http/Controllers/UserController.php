<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        return UserResource::collection(User::paginate($request->limit));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($userId)
    {
        $user = $this->userService->me($userId);
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserProfileRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserProfileRequest $request, $userId)
    {
        $user = Auth::user();
        if(!Gate::allows('set-admin', $user) && $request->isAdmin){
            $request->isAdmin = false;
        }
        $user = $this->userService->updateProfile($request->all(), $userId);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($userId)
    {
        $user = Auth::user();
        $this->authorize('delete', $user);
        if($this->userService->deleteUser()){
            return response()->json([], 204);
        }
    }
}
