<?php


namespace App\Repositories;


interface BookRepositoryInterface extends EloquentRepositoryInterface
{
    public function allApprovedBooksPaginated($field, $value, $columns = ['*']);
}
