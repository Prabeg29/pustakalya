<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function search(Request $request)
    {
        return BookResource::collection($this->bookService->searchForApprovedBooks($request->search));
    }
}
