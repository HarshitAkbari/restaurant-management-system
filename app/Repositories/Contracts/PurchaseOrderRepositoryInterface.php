<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PurchaseOrderRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?PurchaseOrder;

    public function findOrFail(int $id): PurchaseOrder;

    public function create(array $data): PurchaseOrder;

    public function update(int $id, array $data): PurchaseOrder;

    public function delete(int $id): bool;

    public function nextPoNumber(): string;
}
