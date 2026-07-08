<?php

declare(strict_types=1);

namespace App\Services\Inventory;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Repositories\Contracts\PurchaseOrderRepositoryInterface;
use App\Repositories\Contracts\RawMaterialRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PurchaseOrderService
{
    public function __construct(
        private readonly PurchaseOrderRepositoryInterface $purchaseOrderRepository,
        private readonly RawMaterialRepositoryInterface $rawMaterialRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return PurchaseOrder::query()
            ->with(['supplier', 'creator', 'items.rawMaterial'])
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id): PurchaseOrder
    {
        $po = $this->purchaseOrderRepository->find($id);

        if ($po === null) {
            abort(404);
        }

        return $po->load(['supplier', 'creator', 'items.rawMaterial']);
    }

    public function create(array $data, int $userId): PurchaseOrder
    {
        return DB::transaction(function () use ($data, $userId): PurchaseOrder {
            $items = $data['items'] ?? [];
            $totalAmount = $this->calculateTotal($items);

            $po = $this->purchaseOrderRepository->create([
                'po_number' => $this->purchaseOrderRepository->nextPoNumber(),
                'supplier_id' => (int) $data['supplier_id'],
                'status' => 'ordered',
                'total_amount' => $totalAmount,
                'ordered_at' => $data['ordered_at'] ?? now()->toDateString(),
                'notes' => $data['notes'] ?? null,
                'created_by' => $userId,
            ]);

            $this->createItems($po, $items);

            return $po->load(['supplier', 'creator', 'items.rawMaterial']);
        });
    }

    public function receive(int $id): PurchaseOrder
    {
        return DB::transaction(function () use ($id): PurchaseOrder {
            $po = $this->find($id);

            if ($po->status === 'received') {
                throw new RuntimeException('Purchase order has already been received.');
            }

            foreach ($po->items as $item) {
                $material = $this->rawMaterialRepository->find($item->raw_material_id);

                if ($material === null) {
                    continue;
                }

                $newStock = (float) $material->current_stock + (float) $item->quantity;

                $this->rawMaterialRepository->update($material->id, [
                    'current_stock' => $newStock,
                    'cost_per_unit' => (float) $item->unit_cost,
                ]);
            }

            return $this->purchaseOrderRepository->update($id, [
                'status' => 'received',
                'received_at' => now()->toDateString(),
            ])->load(['supplier', 'creator', 'items.rawMaterial']);
        });
    }

    /**
     * @param  array<int, array{raw_material_id: int|string, quantity: float|string, unit_cost: float|string}>  $items
     */
    private function calculateTotal(array $items): float
    {
        $total = 0.0;

        foreach ($items as $item) {
            if (empty($item['raw_material_id']) || empty($item['quantity'])) {
                continue;
            }

            $quantity = (float) $item['quantity'];
            $unitCost = (float) ($item['unit_cost'] ?? 0);
            $total += $quantity * $unitCost;
        }

        return round($total, 2);
    }

    /**
     * @param  array<int, array{raw_material_id: int|string, quantity: float|string, unit_cost: float|string}>  $items
     */
    private function createItems(PurchaseOrder $po, array $items): void
    {
        foreach ($items as $item) {
            if (empty($item['raw_material_id']) || empty($item['quantity'])) {
                continue;
            }

            $quantity = (float) $item['quantity'];
            $unitCost = (float) ($item['unit_cost'] ?? 0);

            PurchaseOrderItem::query()->create([
                'purchase_order_id' => $po->id,
                'raw_material_id' => (int) $item['raw_material_id'],
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'line_total' => round($quantity * $unitCost, 2),
            ]);
        }
    }
}
