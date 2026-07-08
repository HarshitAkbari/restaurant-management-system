<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\OnlineOrderStatus;
use App\Http\Controllers\Controller;
use App\Services\OnlineOrder\OnlineOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class OnlineOrderController extends Controller
{
    public function __construct(
        private readonly OnlineOrderService $onlineOrderService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.online-orders.index', [
            'orders' => $this->onlineOrderService->paginate(),
            'pendingCount' => $this->onlineOrderService->pending()->count(),
        ]);
    }

    public function show(int $onlineOrder): View
    {
        return view('restaurant.admin.online-orders.show', [
            'onlineOrder' => $this->onlineOrderService->find($onlineOrder),
            'statuses' => OnlineOrderStatus::cases(),
        ]);
    }

    public function accept(Request $request, int $onlineOrder): RedirectResponse
    {
        try {
            $this->onlineOrderService->accept($onlineOrder, (int) $request->user()->id);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.online-orders.show', $onlineOrder)
            ->with('success', 'Online order accepted.');
    }

    public function reject(int $onlineOrder): RedirectResponse
    {
        try {
            $this->onlineOrderService->reject($onlineOrder);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.online-orders.index')
            ->with('success', 'Online order rejected.');
    }

    public function updateStatus(Request $request, int $onlineOrder): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $this->onlineOrderService->updateStatus($onlineOrder, $data['status']);

        return back()->with('success', 'Order status updated.');
    }
}
