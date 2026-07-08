<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RawMaterialRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?RawMaterial;

    public function findOrFail(int $id): RawMaterial;

    public function create(array $data): RawMaterial;

    public function update(int $id, array $data): RawMaterial;

    public function delete(int $id): bool;

    public function lowStock(): Collection;
}
