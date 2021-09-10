<?php

namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    /**
     * ReviewRepository constructor.
     * @param Review $model
     */
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function latest()
    {
        return $this->model->latest()->first();
    }
}
