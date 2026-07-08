<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Order;

    public function findOrFail(int $id): Order;

    public function create(array $data): Order;

    public function update(int $id, array $data): Order;

    public function delete(int $id): bool;

    public function liveOrders(): Collection;

    public function history(int $perPage): LengthAwarePaginator;

    public function voidLog(int $perPage): LengthAwarePaginator;

    public function heldOrders(): Collection;

    public function findWithRelations(int $id): ?Order;

    public function findActiveByTable(int $tableId): ?Order;

    public function nextOrderNumber(): string;
}
