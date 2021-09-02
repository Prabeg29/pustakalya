<?php


namespace App\Repositories\Eloquent;


use App\Models\File;
use App\Repositories\FileRepositoryInterface;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    protected $model;

    /**
     * UserRepository constructor.
     * @param File $model
     */
    public function __construct(File $model)
    {
        parent::__construct($model);
    }
}
