<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Book\StoreBookAction;
use App\Actions\UpdateUserAction;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return BookResource::collection(Book::paginate($request->limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BookResource|Response
     */
    public function store(BookRequest $request, StoreBookAction $action)
    {
        $book = $action->handle($request);
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param UpdateUserAction $action
     * @param Book $book
     * @return BookResource
     */
    public function update(BookRequest $request, UpdateUserAction $action, Book $book)
    {
        $book = $action->handle($request, $book);
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            "status" => "Success",
            "message" => "Book successfully deleted"
        ], 204);
    }
}
