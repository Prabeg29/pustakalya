<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookReviewRequest;
use App\Http\Resources\BookReviewResource;
use App\Services\BookService;
use App\Services\ReviewService;
use Illuminate\Http\Response;

class BookReviewController extends Controller
{
    private $bookService;
    private $reviewService;

    public function __construct(BookService $bookService, ReviewService $reviewService)
    {
        $this->bookService = $bookService;
        $this->reviewService = $reviewService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookReviewRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(BookReviewRequest $request, $bookId)
    {
        $book = $this->bookService->getBook($bookId);
        $this->authorize('update', $book);
        $review = $this->reviewService->addReview($request->all(), $book);
        return (new BookReviewResource($review))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookReviewRequest $request
     * @param $bookId
     * @return BookReviewResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BookReviewRequest $request, $bookId, $reviewId)
    {
        $review = $this->reviewService->getReview($reviewId);
        $this->authorize('update', $review);
        $review = $this->reviewService->updateReview($request->all(), $bookId, $reviewId);
        return (new BookReviewResource($review));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($bookId, $reviewId)
    {
        $review = $this->reviewService->getReview($reviewId);
        $this->authorize('delete', $review);
        if($this->reviewService->deleteBookReview($reviewId)){
            return response()->json([], 204);
        }
    }
}
