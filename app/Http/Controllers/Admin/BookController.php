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
        $books = $this->bookService->getAllBook();
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return BookResource
     */
    public function store(BookRequest $request)
    {
        $book = $this->bookService->addBook($request->all());
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return BookResource
     */
    public function show($id)
    {
        $book = $this->bookService->getBook($id);
        return new BookResource($book);
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
        $book = $this->bookService->updateBook($request->all(), $id);
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if(!$this->bookService->deleteBook($id)){
            return response()->json([
                "status" => "Failed",
                "message" => "Something went wrong"
            ], 500);
        }
        return response()->json([
            "status" => "Success",
            "message" => "Book successfully deleted"
        ], 204);
    }
}
