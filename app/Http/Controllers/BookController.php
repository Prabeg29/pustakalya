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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BookResource
     */
    public function show($id)
    {
        return new BookResource(Book::where('id', '=', $id)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return BookResource
     */
    public function update(BookRequest $request, $id)
    {
        $validatedBookData = $request->validated();

         Book::where('id', '=', $id)
            ->firstOrFail()
            ->update([
            'title' => $validatedBookData['title'],
            'description' => $validatedBookData['description'],
            'cover_image' => $validatedBookData['coverImage'] ?? null,
            'qty' => $validatedBookData['qty']
        ]);

        $book = Book::where('id', '=', $id)->firstOrFail();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $book = Book::where('id', '=', $id)->firstOrFail();
        $book->delete();
        return response()->json([
            "status" => "Success",
            "message" => "Book successfully deleted"
        ], 204);
    }
}
