<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserBookController extends Controller
{
    private $userService;

    /**
     * UserBookController constructor.
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
     */
    public function index($userId)
    {
        return BookResource::collection($this->userService->getBooks($userId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request, $userId)
    {
        $user = $this->userService->addBooks($request, $userId);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
