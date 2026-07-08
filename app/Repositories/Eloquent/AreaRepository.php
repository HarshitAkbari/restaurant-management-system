<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Area;
use App\Repositories\Contracts\AreaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AreaRepository extends BaseRepository implements AreaRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Area());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Area
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Area
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Area
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Area
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function allActive(): Collection
    {
        return $this->model->newQuery()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
