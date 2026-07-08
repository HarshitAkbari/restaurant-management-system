<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderService->history((int) $request->get('per_page', 15));

        return response()->json([
            'data' => collect($orders->items())->map(fn ($order) => $this->formatOrder($order))->values(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => ['nullable', 'string'],
            'restaurant_table_id' => ['nullable', 'integer', 'exists:restaurant_tables,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = $this->orderService->createOrder($data, (int) $request->user()->id);

        return response()->json([
            'data' => $this->formatOrder($order),
        ], 201);
    }

    public function show(int $order): JsonResponse
    {
        $order = $this->orderService->show($order);

        return response()->json([
            'data' => $this->formatOrder($order, detailed: true),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function formatOrder(object $order, bool $detailed = false): array
    {
        $payload = [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'type' => $order->type?->value ?? $order->type,
            'status' => $order->status?->value ?? $order->status,
            'restaurant_table_id' => $order->restaurant_table_id,
            'customer_id' => $order->customer_id,
            'subtotal' => (float) $order->subtotal,
            'discount_amount' => (float) $order->discount_amount,
            'tax_amount' => (float) $order->tax_amount,
            'service_charge' => (float) $order->service_charge,
            'total_amount' => (float) $order->total_amount,
            'notes' => $order->notes,
            'created_at' => $order->created_at?->toIso8601String(),
        ];

        if ($detailed && $order->relationLoaded('items')) {
            $payload['items'] = $order->items->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'line_total' => (float) $item->line_total,
            ])->values();
        }

        return $payload;
    }
}
