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
        return BookResource::collection($this->bookService->getAllApprovedBooksPaginated());
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
        $this->authorize('view', $book);
        return new BookResource($book);
    }
}
