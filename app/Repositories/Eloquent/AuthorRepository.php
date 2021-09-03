<?php


namespace App\Repositories\Eloquent;


use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param Author $model
     */
    public function __construct(Author $model)
    {
        parent::__construct($model);
    }
}
