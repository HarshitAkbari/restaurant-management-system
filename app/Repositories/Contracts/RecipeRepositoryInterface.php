<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RecipeRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Recipe;

    public function findOrFail(int $id): Recipe;

    public function create(array $data): Recipe;

    public function update(int $id, array $data): Recipe;

    public function delete(int $id): bool;

    public function findByMenuItem(int $menuItemId): ?Recipe;
}
