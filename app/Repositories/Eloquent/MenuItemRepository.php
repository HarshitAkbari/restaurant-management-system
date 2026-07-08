<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\MenuItem;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuItemRepository extends BaseRepository implements MenuItemRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MenuItem());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?MenuItem
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): MenuItem
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): MenuItem
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): MenuItem
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function allAvailable(): Collection
    {
        return $this->model->newQuery()
            ->where('is_available', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function paginateWithCategory(int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with('category')
            ->latest()
            ->paginate($perPage);
    }

    public function findWithRelations(int $id): ?MenuItem
    {
        return $this->model->newQuery()
            ->with(['category', 'variants', 'addons', 'recipe.items'])
            ->find($id);
    }
}
