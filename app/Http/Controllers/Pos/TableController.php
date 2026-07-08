<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use App\Services\Table\TableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TableController extends Controller
{
    public function __construct(
        private readonly TableService $tableService,
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        $layout = $this->tableService->layoutWithActiveOrders();

        return view('restaurant.pos.dashboard', [
            'areas' => $layout['areas'],
            'ordersByTable' => $layout['ordersByTable'],
        ]);
    }

    public function open(int $table): RedirectResponse
    {
        $this->tableService->find($table);

        $order = $this->orderService->openForTable($table, (int) auth()->id());

        return redirect()->route('pos.orders.show', $order->id);
    }

    public function quickOrder(string $type): RedirectResponse
    {
        $orderType = match ($type) {
            'takeaway' => OrderType::Takeaway->value,
            'delivery' => OrderType::Delivery->value,
            default => OrderType::Takeaway->value,
        };

        $order = $this->orderService->createOrder([
            'type' => $orderType,
            'guest_count' => 1,
        ], (int) auth()->id());

        return redirect()->route('pos.orders.show', $order->id);
    }
}
