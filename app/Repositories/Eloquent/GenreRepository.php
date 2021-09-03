<?php


namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Repositories\GenreRepositoryInterface;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param Genre $model
     */
    public function __construct(Genre $model)
    {
        parent::__construct($model);
    }
}
