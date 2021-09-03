<?php


namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\EloquentRepositoryInterface;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * @inheritDoc
     */
    public function firstOrCreate(array $payload): ?Model
    {
        return $this->model->firstOrCreate($payload);
    }

    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $modelId): ?Model
    {
        return $this->model->findOrFail($modelId);
    }

    /**
     * @inheritDoc
     */
    public function update(int $modelId, array $payload): ?Model
    {
        $model = $this->findById($modelId);
        $model->update($payload);

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }
}
