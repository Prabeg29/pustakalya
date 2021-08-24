<?php


namespace App\Actions\Book;


use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;

class StoreBookAction
{
    public function handle(BookRequest $request)
    {
        $book = Book::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'cover_image' => $request['coverImage'] ?? null,
            'qty' => $request['qty']
        ]);

        $authorNames = explode(",", $request["authors"]);
        $authorIds = [];
        foreach ($authorNames as $authorName)
        {
            $author = Author::firstOrCreate(["name" => $authorName]);
            $authorIds[] = $author->id;
        }
        $book->authors()->sync($authorIds);

        $genreNames = explode(",", $request["genres"]);
        $genreIds = [];
        foreach ($genreNames as $genreName)
        {
            $genre = Genre::firstOrCreate(["name" => $genreName]);
            $genreIds[] = $genre->id;
        }
        $book->genres()->sync($genreIds);

        return $book;
    }
}
