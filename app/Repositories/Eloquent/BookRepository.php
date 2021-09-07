<?php


namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }
}
