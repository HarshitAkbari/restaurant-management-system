<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Enums\TableStatus;
use App\Models\RestaurantTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RestaurantTableRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?RestaurantTable;

    public function findOrFail(int $id): RestaurantTable;

    public function create(array $data): RestaurantTable;

    public function update(int $id, array $data): RestaurantTable;

    public function delete(int $id): bool;

    public function allWithArea(): Collection;

    public function updateStatus(int $id, TableStatus $status): RestaurantTable;
}
