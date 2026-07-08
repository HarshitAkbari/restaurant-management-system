<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SupplierRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Supplier;

    public function findOrFail(int $id): Supplier;

    public function create(array $data): Supplier;

    public function update(int $id, array $data): Supplier;

    public function delete(int $id): bool;
}
