<?php

namespace App\Http\Controllers;

use App\Actions\StoreUserAction;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        return response()->json([
            User::paginate($request->limit)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRegisterRequest $request
     * @param StoreUserAction $storeUserAction
     * @return UserResource
     */
    public function store(UserRegisterRequest $request, StoreUserAction $storeUserAction)
    {
        $user = $storeUserAction->execute($request);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return response()->json([
            "user" => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
