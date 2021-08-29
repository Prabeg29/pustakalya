<?php

namespace App\Http\Controllers;

use App\Actions\Review\StoreReviewAction;
use App\Actions\UpdateUserAction;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Book $book
     * @param StoreReviewAction $action
     * @return void
     */
    public function store(Request $request, Book $book, StoreReviewAction $action)
    {
        $book = $action->handle($request, $book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Book $book, Review $review, UpdateUserAction $action)
    {
        $this->authorize('update', $review);
        $book = $action->handle($request, $book, $review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book, Review $review)
    {
        $this->authorize('update', $review);
        $review->delete();
        return response()->json(['message' => 'Review Deleted'], 204);
    }
}
