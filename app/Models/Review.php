<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'rating',
        'book_id',
        'user_id'
    ];

    /**
     * Get the user who gave the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that has the review.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
