<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MenuAddon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuAddonRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?MenuAddon;

    public function findOrFail(int $id): MenuAddon;

    public function create(array $data): MenuAddon;

    public function update(int $id, array $data): MenuAddon;

    public function delete(int $id): bool;
}
