<?php

declare(strict_types=1);

namespace App\Services\OnlineOrder;

use App\Enums\OnlineOrderStatus;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\OnlineOrder;
use App\Repositories\Contracts\OnlineOrderRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use RuntimeException;

class OnlineOrderService
{
    public function __construct(
        private readonly OnlineOrderRepositoryInterface $onlineOrderRepository,
        private readonly OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return OnlineOrder::query()->latest()->paginate($perPage);
    }

    public function pending(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->onlineOrderRepository->pending();
    }

    public function find(int $id): OnlineOrder
    {
        $order = $this->onlineOrderRepository->find($id);

        if ($order === null) {
            abort(404);
        }

        return $order->load('order');
    }

    public function accept(int $id, int $userId): OnlineOrder
    {
        $onlineOrder = $this->find($id);

        if ($onlineOrder->status !== OnlineOrderStatus::Pending) {
            throw new RuntimeException('Only pending online orders can be accepted.');
        }

        $internalOrder = $this->orderRepository->create([
            'order_number' => $this->orderRepository->nextOrderNumber(),
            'type' => OrderType::Online,
            'status' => OrderStatus::Open,
            'created_by' => $userId,
            'total_amount' => $onlineOrder->total_amount,
            'notes' => $onlineOrder->notes,
        ]);

        return $this->onlineOrderRepository->update($id, [
            'status' => OnlineOrderStatus::Accepted,
            'order_id' => $internalOrder->id,
            'accepted_at' => now(),
        ]);
    }

    public function reject(int $id): OnlineOrder
    {
        $onlineOrder = $this->find($id);

        if ($onlineOrder->status !== OnlineOrderStatus::Pending) {
            throw new RuntimeException('Only pending online orders can be rejected.');
        }

        return $this->onlineOrderRepository->update($id, [
            'status' => OnlineOrderStatus::Rejected,
            'rejected_at' => now(),
        ]);
    }

    public function updateStatus(int $id, OnlineOrderStatus|string $status): OnlineOrder
    {
        if (is_string($status)) {
            $status = OnlineOrderStatus::from($status);
        }

        return $this->onlineOrderRepository->updateStatus($id, $status);
    }
}
