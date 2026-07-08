<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuItemRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?MenuItem;

    public function findOrFail(int $id): MenuItem;

    public function create(array $data): MenuItem;

    public function update(int $id, array $data): MenuItem;

    public function delete(int $id): bool;

    public function allAvailable(): Collection;

    public function paginateWithCategory(int $perPage): LengthAwarePaginator;

    public function findWithRelations(int $id): ?MenuItem;
}
