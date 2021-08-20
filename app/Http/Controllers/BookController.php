<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return BookResource|\Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $validatedBookData = $request->validated();

        $book = Book::create([
            'title' => $validatedBookData['title'],
            'description' => $validatedBookData['description'],
            'cover_image' => $validatedBookData['coverImage'] ?? null,
            'qty' => $validatedBookData['qty']
        ]);

        $authorNames = explode(",", $validatedBookData["authors"]);
        $authorIds = [];
        foreach ($authorNames as $authorName)
        {
            $author = Author::firstOrCreate(["name" => $authorName]);
            $authorIds[] = $author->id;
        }
        $book->authors()->sync($authorIds);

        $genreNames = explode(",", $validatedBookData["genres"]);
        $genreIds = [];
        foreach ($genreNames as $genreName)
        {
            $genre = Genre::firstOrCreate(["name" => $genreName]);
            $genreIds[] = $genre->id;
        }
        $book->genres()->sync($genreIds);

        return new BookResource($book);
    }



}
