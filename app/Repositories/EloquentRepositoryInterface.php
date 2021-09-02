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
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

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
    public function update(int $modelId, array $payload): bool;

    /**
     * @param int $modelId
     * @return bool
     */
    public function delete(int $modelId): bool;
}
