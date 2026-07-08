<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pos\AddOrderItemRequest;
use App\Http\Requests\Pos\RecordPaymentRequest;
use App\Http\Requests\Pos\RemoveOrderItemRequest;
use App\Http\Requests\Pos\StoreOrderRequest;
use App\Http\Requests\Pos\UpdateOrderItemRequest;
use App\Http\Requests\Pos\VoidOrderRequest;
use App\Http\Resources\Pos\OrderBillingResource;
use App\Services\Order\OrderService;
use App\Services\Pos\PosMenuService;
use App\Services\Settings\RestaurantSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use InvalidArgumentException;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly PosMenuService $posMenuService,
        private readonly RestaurantSettingService $settingService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.pos.orders.index', [
            'orders' => $this->orderService->liveOrders(),
        ]);
    }

    public function create(): View
    {
        return redirect()->route('pos.dashboard');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $order = $this->orderService->createOrder(
            $request->validated(),
            (int) $request->user()->id,
        );

        return redirect()
            ->route('pos.orders.show', $order->id)
            ->with('success', 'Order created successfully.');
    }

    public function show(int $order): View
    {
        return view('restaurant.pos.orders.show', [
            'order' => $this->orderService->show($order),
            'menuCategories' => $this->posMenuService->getMenuForBilling(),
            'paymentMethods' => $this->settingService->enabledPaymentMethodCodes(),
        ]);
    }

    public function addItem(AddOrderItemRequest $request, int $order): RedirectResponse|JsonResponse
    {
        $this->orderService->addItem($order, $request->validated());

        if ($this->wantsJson($request)) {
            return $this->billingJsonResponse('Item added.', $order);
        }

        return back()->with('success', 'Item added.');
    }

    public function updateItem(UpdateOrderItemRequest $request, int $order, int $item): RedirectResponse|JsonResponse
    {
        $this->orderService->updateItem($order, $item, $request->validated());

        if ($this->wantsJson($request)) {
            return $this->billingJsonResponse('Item updated.', $order);
        }

        return back()->with('success', 'Item updated.');
    }

    public function removeItem(RemoveOrderItemRequest $request, int $order, int $item): RedirectResponse|JsonResponse
    {
        $this->orderService->removeItem(
            $order,
            $item,
            $request->validated('delete_reason'),
            (int) $request->user()->id,
        );

        if ($this->wantsJson($request)) {
            return $this->billingJsonResponse('Item removed.', $order);
        }

        return back()->with('success', 'Item removed.');
    }

    public function sendKot(int $order): RedirectResponse
    {
        try {
            $this->orderService->sendKot($order, (int) auth()->id());
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'KOT sent to kitchen.');
    }

    public function kotAndPrint(int $order): RedirectResponse
    {
        try {
            $kot = $this->orderService->sendKot($order, (int) auth()->id());
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('pos.orders.print.kot', ['order' => $order, 'kot' => $kot->id])
            ->with('success', 'KOT sent to kitchen.');
    }

    public function save(int $order): RedirectResponse
    {
        try {
            $this->orderService->billOrder($order);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Bill saved.');
    }

    public function saveAndPrint(int $order): RedirectResponse
    {
        try {
            $this->orderService->billOrder($order);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('pos.orders.print.bill', $order)
            ->with('success', 'Bill saved.');
    }

    public function saveAndEbill(int $order): RedirectResponse
    {
        try {
            $orderModel = $this->orderService->billOrder($order);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        $orderModel->load('customer');
        $contact = $orderModel->customer?->phone ?? $orderModel->customer?->email;

        if ($contact) {
            Log::info('eBill queued for order', [
                'order_id' => $orderModel->id,
                'contact' => $contact,
            ]);
        }

        return back()->with('success', $contact
            ? 'Bill saved and eBill queued.'
            : 'Bill saved. Add a customer to send eBill.');
    }

    public function printBill(int $order): View
    {
        return view('restaurant.pos.orders.print.bill', [
            'order' => $this->orderService->show($order),
        ]);
    }

    public function printKot(int $order, Request $request): View
    {
        $orderModel = $this->orderService->show($order);
        $kotId = $request->integer('kot');

        $kot = $kotId
            ? $orderModel->kots->firstWhere('id', $kotId)
            : $orderModel->kots->sortByDesc('id')->first();

        if ($kot === null) {
            abort(404, 'No KOT found for this order.');
        }

        $kot->load('items');

        return view('restaurant.pos.orders.print.kot', [
            'order' => $orderModel,
            'kot' => $kot,
        ]);
    }

    public function hold(int $order): RedirectResponse
    {
        $this->orderService->hold($order);

        return redirect()
            ->route('pos.hold.index')
            ->with('success', 'Order placed on hold.');
    }

    public function resume(int $order): RedirectResponse
    {
        $this->orderService->resume($order);

        return redirect()
            ->route('pos.orders.show', $order)
            ->with('success', 'Order resumed.');
    }

    public function pay(RecordPaymentRequest $request, int $order): RedirectResponse
    {
        $this->orderService->recordPayment(
            $order,
            $request->validated(),
            (int) $request->user()->id,
        );

        return back()->with('success', 'Payment recorded.');
    }

    public function void(VoidOrderRequest $request, int $order): RedirectResponse
    {
        try {
            $this->orderService->voidOrder(
                $order,
                $request->validated('void_reason'),
                (int) $request->user()->id,
            );
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('pos.orders.index')
            ->with('success', 'Order voided.');
    }

    private function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->ajax();
    }

    private function billingJsonResponse(string $message, int $orderId): JsonResponse
    {
        $order = $this->orderService->show($orderId);

        return response()->json([
            'success' => true,
            'message' => $message,
            'order' => (new OrderBillingResource($order))->resolve(),
        ]);
    }
}
