<?php

namespace App\Http\Controllers;

use App\Actions\StoreUserAction;
use App\Actions\UpdateUserAction;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
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
     * Store a newly created resource in storage.
     *
     * @param UserRegisterRequest $request
     * @param StoreUserAction $storeUserAction
     * @return UserResource
     */
    public function store(UserRegisterRequest $request, StoreUserAction $action)
    {
        $user = $action->execute($request);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserProfileRequest $request
     * @param UpdateUserAction $action
     * @param User $user
     * @return UserResource
     */
    public function update(UserProfileRequest $request, UpdateUserAction $action, User $user)
    {
       if(!Gate::allows('set-admin', $user) && $request->isAdmin){
            $request->isAdmin = false;
        }
        $user = $action->handle($request, $user);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
