<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\MenuAddon;
use App\Repositories\Contracts\MenuAddonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuAddonRepository extends BaseRepository implements MenuAddonRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MenuAddon());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?MenuAddon
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): MenuAddon
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): MenuAddon
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): MenuAddon
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }
}
