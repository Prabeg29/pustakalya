<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * @param array $payload
     * @return Model|null
     */
    public function firstOrCreate(array $payload): ?Model;
    /**
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return mixed
     */
    public function paginate($perPage = 10, array $columns = ['*'], array $relations = []);

    /**
     * @param int $modelId
     * @return Model|null
     */
    public function findById(int $modelId): ?Model;

    /**
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): ?Model;

    /**
     * @param int $modelId
     * @return bool
     */
    public function delete(int $modelId): bool;
}
