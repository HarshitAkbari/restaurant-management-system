<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Services\Inventory\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(
        private readonly SupplierService $supplierService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.inventory.suppliers.index', [
            'suppliers' => $this->supplierService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.inventory.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->supplierService->create($data);

        return redirect()
            ->route('admin.inventory.suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function edit(int $supplier): View
    {
        return view('restaurant.admin.inventory.suppliers.edit', [
            'supplier' => $this->supplierService->find($supplier),
        ]);
    }

    public function update(Request $request, int $supplier): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->supplierService->update($supplier, $data);

        return redirect()
            ->route('admin.inventory.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }
}
