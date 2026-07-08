<?php

declare(strict_types=1);

namespace App\Services\Report;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * @return array{orders: Collection<int, Order>, totals: array<string, float|int>}
     */
    public function sales(string $from, string $to): array
    {
        $orders = Order::query()
            ->with(['customer', 'creator'])
            ->where('status', OrderStatus::Paid)
            ->whereDate('paid_at', '>=', $from)
            ->whereDate('paid_at', '<=', $to)
            ->orderByDesc('paid_at')
            ->get();

        return [
            'orders' => $orders,
            'totals' => [
                'count' => $orders->count(),
                'subtotal' => (float) $orders->sum('subtotal'),
                'discount' => (float) $orders->sum('discount_amount'),
                'tax' => (float) $orders->sum('tax_amount'),
                'service_charge' => (float) $orders->sum('service_charge'),
                'total' => (float) $orders->sum('total_amount'),
            ],
        ];
    }

    /**
     * @return SupportCollection<int, object>
     */
    public function itemWise(string $from, string $to): SupportCollection
    {
        return OrderItem::query()
            ->select([
                'order_items.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.line_total) as total_revenue'),
            ])
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', OrderStatus::Paid)
            ->whereDate('orders.paid_at', '>=', $from)
            ->whereDate('orders.paid_at', '<=', $to)
            ->groupBy('order_items.name')
            ->orderByDesc('total_revenue')
            ->get();
    }

    /**
     * @return array{orders: Collection<int, Order>, totals: array<string, float>}
     */
    public function tax(string $from, string $to): array
    {
        $orders = Order::query()
            ->where('status', OrderStatus::Paid)
            ->whereDate('paid_at', '>=', $from)
            ->whereDate('paid_at', '<=', $to)
            ->orderByDesc('paid_at')
            ->get();

        return [
            'orders' => $orders,
            'totals' => [
                'taxable_amount' => (float) $orders->sum('subtotal'),
                'tax_collected' => (float) $orders->sum('tax_amount'),
                'service_charge' => (float) $orders->sum('service_charge'),
                'grand_total' => (float) $orders->sum('total_amount'),
            ],
        ];
    }

    /**
     * @return SupportCollection<int, object>
     */
    public function staff(string $from, string $to): SupportCollection
    {
        return Order::query()
            ->select([
                'users.id as user_id',
                'users.name as staff_name',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total_amount) as total_sales'),
            ])
            ->join('users', 'users.id', '=', 'orders.created_by')
            ->where('orders.status', OrderStatus::Paid)
            ->whereDate('orders.paid_at', '>=', $from)
            ->whereDate('orders.paid_at', '<=', $to)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_sales')
            ->get();
    }

    /**
     * @return Collection<int, RawMaterial>
     */
    public function inventory(): Collection
    {
        return RawMaterial::query()
            ->orderBy('name')
            ->get();
    }
}
