<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Enums\KotStatus;
use App\Models\Kot;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface KotRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Kot;

    public function findOrFail(int $id): Kot;

    public function create(array $data): Kot;

    public function update(int $id, array $data): Kot;

    public function delete(int $id): bool;

    public function pendingByStation(?string $station): Collection;

    public function nextKotNumber(): string;

    public function updateStatus(int $id, KotStatus $status): Kot;
}
