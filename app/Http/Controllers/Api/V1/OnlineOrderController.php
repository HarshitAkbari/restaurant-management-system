<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use App\Services\OnlineOrder\OnlineOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineOrderController extends Controller
{
    public function __construct(
        private readonly OnlineOrderService $onlineOrderService,
        private readonly MenuCategoryRepositoryInterface $categoryRepository,
        private readonly MenuItemRepositoryInterface $menuItemRepository,
    ) {
    }

    public function menu(): JsonResponse
    {
        return response()->json([
            'categories' => $this->categoryRepository->allActive()->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
            ])->values(),
            'items' => $this->menuItemRepository->allAvailable()->map(fn ($i) => [
                'id' => $i->id,
                'category_id' => $i->menu_category_id,
                'name' => $i->name,
                'price' => (float) $i->price,
            ])->values(),
        ]);
    }

    public function index(): JsonResponse
    {
        $orders = $this->onlineOrderService->paginate();

        return response()->json([
            'data' => collect($orders->items())->map(fn ($order) => $this->format($order))->values(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $total = collect($data['items'])->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);

        $order = \App\Models\OnlineOrder::query()->create([
            'channel' => 'direct',
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'status' => 'pending',
            'total_amount' => $total,
            'items' => $data['items'],
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json(['data' => $this->format($order)], 201);
    }

    /**
     * @return array<string, mixed>
     */
    private function format(object $order): array
    {
        return [
            'id' => $order->id,
            'external_id' => $order->external_id,
            'channel' => $order->channel,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'status' => $order->status?->value ?? $order->status,
            'total_amount' => (float) $order->total_amount,
            'items' => $order->items,
            'created_at' => $order->created_at?->toIso8601String(),
        ];
    }
}
