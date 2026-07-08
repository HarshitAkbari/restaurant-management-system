<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MenuCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuCategoryRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?MenuCategory;

    public function findOrFail(int $id): MenuCategory;

    public function create(array $data): MenuCategory;

    public function update(int $id, array $data): MenuCategory;

    public function delete(int $id): bool;

    public function allActive(): Collection;

    public function allActiveWithAvailableItems(): Collection;
}
