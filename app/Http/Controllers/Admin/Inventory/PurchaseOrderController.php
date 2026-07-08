<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Services\Inventory\PurchaseOrderService;
use App\Services\Inventory\RawMaterialService;
use App\Services\Inventory\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class PurchaseOrderController extends Controller
{
    public function __construct(
        private readonly PurchaseOrderService $purchaseOrderService,
        private readonly SupplierService $supplierService,
        private readonly RawMaterialService $rawMaterialService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.inventory.purchase-orders.index', [
            'purchaseOrders' => $this->purchaseOrderService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.inventory.purchase-orders.create', [
            'suppliers' => $this->supplierService->allActive(),
            'materials' => $this->rawMaterialService->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'ordered_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.raw_material_id' => ['required', 'integer', 'exists:raw_materials,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.001'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ]);

        $this->purchaseOrderService->create($data, (int) $request->user()->id);

        return redirect()
            ->route('admin.inventory.purchase-orders.index')
            ->with('success', 'Purchase order created successfully.');
    }

    public function show(int $purchaseOrder): View
    {
        return view('restaurant.admin.inventory.purchase-orders.show', [
            'purchaseOrder' => $this->purchaseOrderService->find($purchaseOrder),
        ]);
    }

    public function receive(Request $request, int $purchaseOrder): RedirectResponse
    {
        try {
            $this->purchaseOrderService->receive($purchaseOrder);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.inventory.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order received and stock updated.');
    }
}
