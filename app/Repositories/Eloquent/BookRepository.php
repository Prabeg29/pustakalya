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

    public function allApprovedBooksPaginated($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, $value)->paginate(15);
    }
}
