<?php

declare(strict_types=1);

namespace App\Services\Table;

use App\Enums\TableStatus;
use App\Models\Area;
use App\Models\Order;
use App\Models\RestaurantTable;
use App\Repositories\Contracts\AreaRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\RestaurantTableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TableService
{
    public function __construct(
        private readonly RestaurantTableRepositoryInterface $tableRepository,
        private readonly AreaRepositoryInterface $areaRepository,
        private readonly OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function all(): Collection
    {
        return $this->tableRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return RestaurantTable::query()
            ->with('area')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function find(int $id): RestaurantTable
    {
        return $this->tableRepository->findOrFail($id);
    }

    public function create(array $data): RestaurantTable
    {
        return $this->tableRepository->create([
            'area_id' => $data['area_id'],
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'capacity' => (int) ($data['capacity'] ?? 2),
            'status' => $data['status'] ?? TableStatus::Free->value,
            'pos_x' => (int) ($data['pos_x'] ?? 0),
            'pos_y' => (int) ($data['pos_y'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): RestaurantTable
    {
        return $this->tableRepository->update($id, [
            'area_id' => $data['area_id'],
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'capacity' => (int) ($data['capacity'] ?? 2),
            'pos_x' => (int) ($data['pos_x'] ?? 0),
            'pos_y' => (int) ($data['pos_y'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->tableRepository->delete($id);
    }

    /** @return Collection<int, Area> */
    public function layout(): Collection
    {
        return Area::query()
            ->with(['tables' => fn ($query) => $query->orderBy('name')])
            ->orderBy('sort_order')
            ->get();
    }

    public function updateStatus(int $id, TableStatus|string $status): RestaurantTable
    {
        if (is_string($status)) {
            $status = TableStatus::from($status);
        }

        return $this->tableRepository->updateStatus($id, $status);
    }

    public function allWithArea(): Collection
    {
        return $this->tableRepository->allWithArea();
    }

    public function activeAreas(): Collection
    {
        return $this->areaRepository->allActive();
    }

    /**
     * @return array{areas: Collection<int, Area>, ordersByTable: array<int, Order>}
     */
    public function layoutWithActiveOrders(): array
    {
        $areas = Area::query()
            ->where('is_active', true)
            ->with(['tables' => fn ($query) => $query->where('is_active', true)->orderBy('name')])
            ->orderBy('sort_order')
            ->get();

        $ordersByTable = [];

        foreach ($this->orderRepository->liveOrders() as $order) {
            if ($order->restaurant_table_id !== null) {
                $ordersByTable[$order->restaurant_table_id] = $order;
            }
        }

        return [
            'areas' => $areas,
            'ordersByTable' => $ordersByTable,
        ];
    }
}
