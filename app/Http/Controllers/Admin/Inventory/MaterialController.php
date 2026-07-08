<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Services\Inventory\RawMaterialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function __construct(
        private readonly RawMaterialService $rawMaterialService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.inventory.materials.index', [
            'materials' => $this->rawMaterialService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.inventory.materials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:50'],
            'unit' => ['nullable', 'string', 'max:30'],
            'current_stock' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
            'cost_per_unit' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->rawMaterialService->create($data);

        return redirect()
            ->route('admin.inventory.materials.index')
            ->with('success', 'Raw material created successfully.');
    }

    public function edit(int $material): View
    {
        return view('restaurant.admin.inventory.materials.edit', [
            'material' => $this->rawMaterialService->find($material),
        ]);
    }

    public function update(Request $request, int $material): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:50'],
            'unit' => ['nullable', 'string', 'max:30'],
            'current_stock' => ['nullable', 'numeric', 'min:0'],
            'reorder_level' => ['nullable', 'numeric', 'min:0'],
            'cost_per_unit' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->rawMaterialService->update($material, $data);

        return redirect()
            ->route('admin.inventory.materials.index')
            ->with('success', 'Raw material updated successfully.');
    }
}
