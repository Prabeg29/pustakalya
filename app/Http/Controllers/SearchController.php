<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;
        $result = Book::with(['authors',  'genres'])
            ->where('title', 'like', "%$search%")
            ->orWhere(function($query) use ($search) {
                $query->whereHas('authors', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->orWhere(function($query) use ($search){
                $query->whereHas('genres', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->get();

        return BookResource::collection($result);
    }
}
