<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\TableStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemRemoval;
use App\Models\Payment;
use App\Models\Kot;
use App\Models\KotItem;
use App\Repositories\Contracts\KotRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\RestaurantSettingRepositoryInterface;
use App\Repositories\Contracts\RestaurantTableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class OrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly RestaurantTableRepositoryInterface $tableRepository,
        private readonly RestaurantSettingRepositoryInterface $settingRepository,
        private readonly KotRepositoryInterface $kotRepository,
    ) {
    }

    public function liveOrders(): Collection
    {
        return $this->orderRepository->liveOrders();
    }

    public function history(int $perPage = 15): LengthAwarePaginator
    {
        return $this->orderRepository->history($perPage);
    }

    public function voidLog(int $perPage = 15): LengthAwarePaginator
    {
        return $this->orderRepository->voidLog($perPage);
    }

    public function show(int $id): Order
    {
        $order = $this->orderRepository->findWithRelations($id);

        if ($order === null) {
            abort(404);
        }

        return $order;
    }

    public function heldOrders(): Collection
    {
        return $this->orderRepository->heldOrders();
    }

    public function createOrder(array $data, int $userId): Order
    {
        return DB::transaction(function () use ($data, $userId): Order {
            $order = $this->orderRepository->create([
                'order_number' => $this->orderRepository->nextOrderNumber(),
                'status' => OrderStatus::Open,
                'type' => $data['type'] ?? OrderType::DineIn->value,
                'restaurant_table_id' => $data['restaurant_table_id'] ?? null,
                'customer_id' => $data['customer_id'] ?? null,
                'guest_count' => (int) ($data['guest_count'] ?? 1),
                'created_by' => $userId,
                'notes' => $data['notes'] ?? null,
            ]);

            if (! empty($data['restaurant_table_id'])) {
                $this->tableRepository->updateStatus(
                    (int) $data['restaurant_table_id'],
                    TableStatus::Occupied,
                );
            }

            return $order;
        });
    }

    public function openForTable(int $tableId, int $userId): Order
    {
        $existing = $this->orderRepository->findActiveByTable($tableId);

        if ($existing !== null) {
            return $existing;
        }

        return $this->createOrder([
            'type' => OrderType::DineIn->value,
            'restaurant_table_id' => $tableId,
            'guest_count' => 1,
        ], $userId);
    }

    public function addItem(int $orderId, array $data): OrderItem
    {
        return DB::transaction(function () use ($orderId, $data): OrderItem {
            $order = $this->orderRepository->findOrFail($orderId);
            $quantity = (int) ($data['quantity'] ?? 1);
            $unitPrice = (float) ($data['unit_price'] ?? 0);

            $item = $order->items()->create([
                'menu_item_id' => $data['menu_item_id'] ?? null,
                'menu_variant_id' => $data['menu_variant_id'] ?? null,
                'name' => $data['name'],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $quantity * $unitPrice,
                'addons' => $data['addons'] ?? null,
                'notes' => $data['notes'] ?? null,
                'kot_sent' => false,
            ]);

            $this->recalculateTotals($order->fresh(['items']));

            return $item;
        });
    }

    public function updateItem(int $orderId, int $itemId, array $data): OrderItem
    {
        return DB::transaction(function () use ($orderId, $itemId, $data): OrderItem {
            $order = $this->orderRepository->findOrFail($orderId);
            $item = $order->items()->findOrFail($itemId);

            $quantity = (int) ($data['quantity'] ?? $item->quantity);
            $unitPrice = (float) ($data['unit_price'] ?? $item->unit_price);

            $item->update([
                'name' => $data['name'] ?? $item->name,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $quantity * $unitPrice,
                'menu_item_id' => $data['menu_item_id'] ?? $item->menu_item_id,
                'menu_variant_id' => $data['menu_variant_id'] ?? $item->menu_variant_id,
                'addons' => $data['addons'] ?? $item->addons,
                'notes' => array_key_exists('notes', $data) ? $data['notes'] : $item->notes,
            ]);

            $this->recalculateTotals($order->fresh(['items']));

            return $item->fresh();
        });
    }

    public function removeItem(int $orderId, int $itemId, string $reason, int $userId): void
    {
        DB::transaction(function () use ($orderId, $itemId, $reason, $userId): void {
            $order = $this->orderRepository->findOrFail($orderId);
            $item = $order->items()->findOrFail($itemId);

            OrderItemRemoval::query()->create([
                'order_id' => $order->id,
                'order_item_id' => $item->id,
                'item_name' => $item->name,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'line_total' => $item->line_total,
                'reason' => $reason,
                'removed_by' => $userId,
            ]);

            $item->delete();
            $this->recalculateTotals($order->fresh(['items']));
        });
    }

    public function recalculateTotals(Order $order): void
    {
        $order->loadMissing('items');
        $settings = $this->settingRepository->firstOrCreateDefault();

        $subtotal = (float) $order->items->sum('line_total');
        $discount = (float) ($order->discount_amount ?? 0);
        $taxable = max($subtotal - $discount, 0);
        $taxPercent = (float) $settings->cgst_percent + (float) $settings->sgst_percent;
        $taxAmount = round($taxable * $taxPercent / 100, 2);
        $serviceCharge = round($taxable * (float) $settings->service_charge_percent / 100, 2);
        $total = round($taxable + $taxAmount + $serviceCharge, 2);

        $this->orderRepository->update($order->id, [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'service_charge' => $serviceCharge,
            'total_amount' => $total,
        ]);
    }

    public function sendKot(int $orderId, int $userId): Kot
    {
        return DB::transaction(function () use ($orderId, $userId): Kot {
            $order = $this->orderRepository->findWithRelations($orderId);

            if ($order === null) {
                abort(404);
            }

            $order->load(['items.menuItem']);
            $unsentItems = $order->items->where('kot_sent', false);

            if ($unsentItems->isEmpty()) {
                throw new InvalidArgumentException('No items pending for KOT.');
            }

            $station = $unsentItems->first()?->menuItem?->kitchen_station;

            $kot = $this->kotRepository->create([
                'order_id' => $order->id,
                'kot_number' => $this->kotRepository->nextKotNumber(),
                'station' => $station,
                'status' => 'pending',
                'created_by' => $userId,
            ]);

            foreach ($unsentItems as $item) {
                KotItem::query()->create([
                    'kot_id' => $kot->id,
                    'order_item_id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'notes' => $item->notes,
                ]);

                $item->update(['kot_sent' => true]);
            }

            if ($order->status === OrderStatus::Open) {
                $this->orderRepository->update($order->id, ['status' => OrderStatus::Open]);
            }

            return $kot->fresh(['items', 'order']);
        });
    }

    public function hold(int $orderId): Order
    {
        return $this->orderRepository->update($orderId, [
            'status' => OrderStatus::Held,
            'held_at' => now(),
        ]);
    }

    public function billOrder(int $orderId): Order
    {
        return DB::transaction(function () use ($orderId): Order {
            $order = $this->orderRepository->findWithRelations($orderId);

            if ($order === null) {
                abort(404);
            }

            if (! $order->status->isActive()) {
                throw new InvalidArgumentException('This order cannot be billed.');
            }

            if ($order->items->isEmpty()) {
                throw new InvalidArgumentException('Add at least one item before saving the bill.');
            }

            if ($order->status === OrderStatus::Billed) {
                return $order;
            }

            return $this->orderRepository->update($orderId, [
                'status' => OrderStatus::Billed,
                'billed_at' => now(),
            ]);
        });
    }

    public function resume(int $orderId): Order
    {
        return $this->orderRepository->update($orderId, [
            'status' => OrderStatus::Open,
            'held_at' => null,
        ]);
    }

    public function recordPayment(int $orderId, array $data, int $userId): Payment
    {
        return DB::transaction(function () use ($orderId, $data, $userId): Payment {
            $order = $this->orderRepository->findWithRelations($orderId);

            if ($order === null) {
                abort(404);
            }

            $payment = Payment::query()->create([
                'order_id' => $order->id,
                'method' => $data['method'],
                'amount' => (float) $data['amount'],
                'reference' => $data['reference'] ?? null,
                'received_by' => $userId,
            ]);

            $order->load('payments');
            $paidTotal = (float) $order->payments->sum('amount');

            if ($paidTotal >= (float) $order->total_amount) {
                $this->orderRepository->update($order->id, [
                    'status' => OrderStatus::Paid,
                    'paid_at' => now(),
                ]);

                $this->freeTable($order);
            } elseif ($order->status !== OrderStatus::Billed) {
                $this->orderRepository->update($order->id, [
                    'status' => OrderStatus::Billed,
                    'billed_at' => now(),
                ]);
            }

            return $payment;
        });
    }

    public function voidOrder(int $orderId, string $reason, int $userId): Order
    {
        return DB::transaction(function () use ($orderId, $reason): Order {
            $order = $this->orderRepository->findOrFail($orderId);

            if ($order->status === OrderStatus::Paid) {
                throw new RuntimeException('Paid orders cannot be voided.');
            }

            $updated = $this->orderRepository->update($orderId, [
                'status' => OrderStatus::Voided,
                'void_reason' => $reason,
                'voided_at' => now(),
            ]);

            $this->freeTable($updated);

            return $updated;
        });
    }

    /**
     * @return array{today_sales: float, open_orders_count: int, occupied_tables_count: int}
     */
    public function dashboardStats(): array
    {
        $todaySales = (float) Order::query()
            ->where('status', OrderStatus::Paid)
            ->whereDate('paid_at', today())
            ->sum('total_amount');

        $openOrdersCount = $this->orderRepository->liveOrders()->count();

        $occupiedTablesCount = $this->tableRepository->all()
            ->where('status', TableStatus::Occupied)
            ->count();

        return [
            'today_sales' => $todaySales,
            'open_orders_count' => $openOrdersCount,
            'occupied_tables_count' => $occupiedTablesCount,
        ];
    }

    private function freeTable(Order $order): void
    {
        if ($order->restaurant_table_id === null) {
            return;
        }

        $this->tableRepository->updateStatus(
            (int) $order->restaurant_table_id,
            TableStatus::Free,
        );
    }
}
