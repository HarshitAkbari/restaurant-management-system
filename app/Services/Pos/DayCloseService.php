<?php

declare(strict_types=1);

namespace App\Services\Pos;

use App\Enums\OrderStatus;
use App\Models\DayClose;
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\DayCloseRepositoryInterface;
use RuntimeException;

class DayCloseService
{
    public function __construct(
        private readonly DayCloseRepositoryInterface $dayCloseRepository,
    ) {
    }

    /**
     * @return array{
     *     business_date: string,
     *     total_sales: float,
     *     total_orders: int,
     *     payment_breakdown: array<string, float>,
     *     already_closed: bool
     * }
     */
    public function preview(string $date): array
    {
        $existing = $this->dayCloseRepository->findByDate($date);
        $orders = Order::query()
            ->where('status', OrderStatus::Paid)
            ->whereDate('paid_at', $date)
            ->get();

        $payments = Payment::query()
            ->whereIn('order_id', $orders->pluck('id'))
            ->get();

        $breakdown = [];

        foreach ($payments as $payment) {
            $method = $payment->method instanceof \BackedEnum
                ? $payment->method->value
                : (string) $payment->method;
            $breakdown[$method] = ($breakdown[$method] ?? 0) + (float) $payment->amount;
        }

        return [
            'business_date' => $date,
            'total_sales' => (float) $orders->sum('total_amount'),
            'total_orders' => $orders->count(),
            'payment_breakdown' => $breakdown,
            'already_closed' => $existing !== null,
            'existing' => $existing,
        ];
    }

    public function close(array $data, int $userId): DayClose
    {
        $date = $data['business_date'] ?? today()->toDateString();

        if ($this->dayCloseRepository->findByDate($date) !== null) {
            throw new RuntimeException('Day close already exists for this date.');
        }

        $preview = $this->preview($date);
        $closingCash = (float) ($data['closing_cash'] ?? 0);
        $openingCash = (float) ($data['opening_cash'] ?? 0);
        $expectedCash = $openingCash + (float) ($preview['payment_breakdown']['cash'] ?? 0);

        return $this->dayCloseRepository->create([
            'business_date' => $date,
            'opening_cash' => $openingCash,
            'closing_cash' => $closingCash,
            'expected_cash' => $expectedCash,
            'cash_variance' => $closingCash - $expectedCash,
            'total_sales' => $preview['total_sales'],
            'total_orders' => $preview['total_orders'],
            'payment_breakdown' => $preview['payment_breakdown'],
            'notes' => $data['notes'] ?? null,
            'closed_by' => $userId,
            'closed_at' => now(),
        ]);
    }
}
