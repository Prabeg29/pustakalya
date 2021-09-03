<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Http\Resources\BookResource;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $books = $this->bookService->getAllBook();
        return BookResource::collection($books);
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

}
