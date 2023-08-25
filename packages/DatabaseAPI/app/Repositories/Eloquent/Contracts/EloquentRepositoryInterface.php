<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param string $id
     * @return Model|null
     */
    public function find(string $id): ?Model;
}
