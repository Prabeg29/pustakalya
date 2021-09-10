<?php

namespace App\Repositories;

interface ReviewRepositoryInterface extends EloquentRepositoryInterface {
    public function latest();
}

