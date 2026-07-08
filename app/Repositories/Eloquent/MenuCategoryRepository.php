<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\MenuCategory;
use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuCategoryRepository extends BaseRepository implements MenuCategoryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MenuCategory());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?MenuCategory
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): MenuCategory
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): MenuCategory
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): MenuCategory
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

    public function allActiveWithAvailableItems(): Collection
    {
        return $this->model->newQuery()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['items' => function ($query): void {
                $query->where('is_active', true)
                    ->where('is_available', true)
                    ->orderBy('sort_order');
            }])
            ->get();
    }
}
