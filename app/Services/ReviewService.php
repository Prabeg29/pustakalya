<?php


namespace App\Services;


use App\Repositories\BookRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;

class ReviewService
{
    protected $bookRepository;
    protected $reviewRepository;

    public function __construct(BookRepositoryInterface $bookRepository,
                                ReviewRepositoryInterface $reviewRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function getReview($reviewId)
    {
        return $this->reviewRepository->findById($reviewId);
    }

    public function addReview(array $reviewData, $book)
    {
        $book->reviews()->create([
            'review' => $reviewData['review'],
            'rating' => $reviewData['rating'],
            'user_id' => auth()->user()->id,
            'book_id' => $book->id
        ]);
        return $this->reviewRepository->latest();
    }

    public function updateReview(array $reviewData, $bookId, $reviewId)
    {
        $book = $this->bookRepository->findById($bookId);
        $book->reviews()->update([
            'review' => $reviewData['review'],
            'rating' => $reviewData['rating'],
            'user_id' => auth()->user()->id,
            'book_id' => $bookId
        ]);
        return $this->getReview($reviewId);
    }

    public function deleteBookReview($reviewId)
    {
        return $this->reviewRepository->delete($reviewId);
    }
}
