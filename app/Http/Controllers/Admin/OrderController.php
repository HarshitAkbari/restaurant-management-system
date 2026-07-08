<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VoidOrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.orders.index', [
            'orders' => $this->orderService->liveOrders(),
        ]);
    }

    public function history(Request $request): View
    {
        return view('restaurant.admin.orders.history', [
            'orders' => $this->orderService->history((int) $request->get('per_page', 15)),
        ]);
    }

    public function voidLog(Request $request): View
    {
        return view('restaurant.admin.orders.void-log', [
            'orders' => $this->orderService->voidLog((int) $request->get('per_page', 15)),
        ]);
    }

    public function show(int $order): View
    {
        return view('restaurant.admin.orders.show', [
            'order' => $this->orderService->show($order),
        ]);
    }

    public function void(VoidOrderRequest $request, int $order): RedirectResponse
    {
        $this->orderService->voidOrder(
            $order,
            $request->validated('void_reason'),
            (int) $request->user()->id,
        );

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order voided successfully.');
    }
}
