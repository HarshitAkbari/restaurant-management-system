<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\DayClose;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DayCloseRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?DayClose;

    public function findOrFail(int $id): DayClose;

    public function create(array $data): DayClose;

    public function update(int $id, array $data): DayClose;

    public function delete(int $id): bool;

    public function findByDate(string $date): ?DayClose;
}
