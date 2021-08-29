<?php


namespace App\Actions\Review;


use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class UpdateReviewAction
{
    public function handle(Request $request, Book $book, Review $review)
    {
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = auth()->user()->id;

        $book->reviews()->save($review);

        return $book;
    }
}
