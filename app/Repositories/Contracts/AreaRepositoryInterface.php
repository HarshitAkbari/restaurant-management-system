<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AreaRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Area;

    public function findOrFail(int $id): Area;

    public function create(array $data): Area;

    public function update(int $id, array $data): Area;

    public function delete(int $id): bool;

    public function allActive(): Collection;
}
