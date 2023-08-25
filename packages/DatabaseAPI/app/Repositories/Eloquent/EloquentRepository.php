<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param string $id
     * @return Model|null
     */
    public function find(string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(?int $page): LengthAwarePaginator
    {
        return $this->model->paginate($page);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
