<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Recipe;
use App\Repositories\Contracts\RecipeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepository extends BaseRepository implements RecipeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Recipe());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Recipe
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Recipe
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Recipe
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Recipe
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function findByMenuItem(int $menuItemId): ?Recipe
    {
        return $this->model->newQuery()
            ->with(['items.rawMaterial', 'menuItem'])
            ->where('menu_item_id', $menuItemId)
            ->first();
    }
}
