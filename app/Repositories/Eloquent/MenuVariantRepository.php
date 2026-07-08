<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\MenuVariant;
use App\Repositories\Contracts\MenuVariantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuVariantRepository extends BaseRepository implements MenuVariantRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MenuVariant());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?MenuVariant
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): MenuVariant
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): MenuVariant
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): MenuVariant
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }
}
