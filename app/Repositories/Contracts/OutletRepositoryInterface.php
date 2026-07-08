<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Outlet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OutletRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Outlet;

    public function findOrFail(int $id): Outlet;

    public function create(array $data): Outlet;

    public function update(int $id, array $data): Outlet;

    public function delete(int $id): bool;
}
