<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return BookResource::collection($this->bookService->getAllBooksPaginated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return JsonResponse|object
     */
    public function store(BookRequest $request)
    {
        return (new BookResource($this->bookService->addBook($request->all())))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return BookResource
     */
    public function show($id)
    {
        return new BookResource($this->bookService->getBook($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param $id
     * @return BookResource
     */
    public function update(BookRequest $request, $id)
    {
        return new BookResource($this->bookService->updateBook($request->all(), $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if($this->bookService->deleteBook($id)){
            return response()->json([
                "status" => "Failed",
                "message" => "Something went wrong"
            ], 500);
        }
    }
}
