<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MenuVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuVariantRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?MenuVariant;

    public function findOrFail(int $id): MenuVariant;

    public function create(array $data): MenuVariant;

    public function update(int $id, array $data): MenuVariant;

    public function delete(int $id): bool;
}
