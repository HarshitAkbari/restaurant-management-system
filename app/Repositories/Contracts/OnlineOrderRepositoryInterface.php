<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Enums\OnlineOrderStatus;
use App\Models\OnlineOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OnlineOrderRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?OnlineOrder;

    public function findOrFail(int $id): OnlineOrder;

    public function create(array $data): OnlineOrder;

    public function update(int $id, array $data): OnlineOrder;

    public function delete(int $id): bool;

    public function pending(): Collection;

    public function updateStatus(int $id, OnlineOrderStatus $status): OnlineOrder;
}
