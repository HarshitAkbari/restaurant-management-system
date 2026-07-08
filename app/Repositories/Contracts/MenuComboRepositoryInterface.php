<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MenuCombo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MenuComboRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?MenuCombo;

    public function findOrFail(int $id): MenuCombo;

    public function create(array $data): MenuCombo;

    public function update(int $id, array $data): MenuCombo;

    public function delete(int $id): bool;
}
