<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Order());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Order
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Order
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Order
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function liveOrders(): Collection
    {
        return $this->model->newQuery()
            ->with(['table.area', 'customer', 'creator'])
            ->whereIn('status', [
                OrderStatus::Draft,
                OrderStatus::Open,
                OrderStatus::Held,
                OrderStatus::Billed,
            ])
            ->latest()
            ->get();
    }

    public function history(int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['table', 'customer', 'creator'])
            ->where('status', OrderStatus::Paid)
            ->latest()
            ->paginate($perPage);
    }

    public function voidLog(int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['table', 'customer', 'creator'])
            ->where('status', OrderStatus::Voided)
            ->latest()
            ->paginate($perPage);
    }

    public function heldOrders(): Collection
    {
        return $this->model->newQuery()
            ->with(['table.area', 'customer', 'creator'])
            ->where('status', OrderStatus::Held)
            ->latest()
            ->get();
    }

    public function findWithRelations(int $id): ?Order
    {
        return $this->model->newQuery()
            ->with(['table.area', 'customer', 'items.menuItem', 'kots.items', 'payments', 'creator'])
            ->find($id);
    }

    public function findActiveByTable(int $tableId): ?Order
    {
        return $this->model->newQuery()
            ->where('restaurant_table_id', $tableId)
            ->whereIn('status', [
                OrderStatus::Draft,
                OrderStatus::Open,
                OrderStatus::Held,
                OrderStatus::Billed,
            ])
            ->latest()
            ->first();
    }

    public function nextOrderNumber(): string
    {
        return $this->nextSequentialNumber('ORD', 'order_number');
    }

    private function nextSequentialNumber(string $prefix, string $column): string
    {
        $date = now()->format('Ymd');
        $numberPrefix = "{$prefix}-{$date}-";

        $lastRecord = $this->model->newQuery()
            ->where($column, 'like', $numberPrefix . '%')
            ->orderByDesc($column)
            ->first();

        $sequence = 1;

        if ($lastRecord !== null) {
            $lastNumber = (string) $lastRecord->{$column};
            $sequence = ((int) substr($lastNumber, -4)) + 1;
        }

        return $numberPrefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
