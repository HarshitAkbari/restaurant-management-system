<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreVariantRequest;
use App\Http\Requests\Admin\Menu\UpdateVariantRequest;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use App\Services\Menu\MenuVariantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VariantController extends Controller
{
    public function __construct(
        private readonly MenuVariantService $variantService,
        private readonly MenuItemRepositoryInterface $itemRepository,
    ) {
    }

    public function index(): View
    {
        $variants = $this->variantService->list();

        return view('restaurant.admin.menu.variants.index', compact('variants'));
    }

    public function create(): View
    {
        $items = $this->itemRepository->all();

        return view('restaurant.admin.menu.variants.create', compact('items'));
    }

    public function store(StoreVariantRequest $request): RedirectResponse
    {
        $this->variantService->create($request->validated());

        return redirect()
            ->route('admin.menu.variants.index')
            ->with('success', 'Variant created successfully.');
    }

    public function edit(int $variant): View
    {
        $variantModel = $this->variantService->findOrFail($variant);
        $items = $this->itemRepository->all();

        return view('restaurant.admin.menu.variants.edit', [
            'variant' => $variantModel,
            'items' => $items,
        ]);
    }

    public function update(UpdateVariantRequest $request, int $variant): RedirectResponse
    {
        $this->variantService->update($variant, $request->validated());

        return redirect()
            ->route('admin.menu.variants.index')
            ->with('success', 'Variant updated successfully.');
    }

    public function destroy(int $variant): RedirectResponse
    {
        $this->variantService->delete($variant);

        return redirect()
            ->route('admin.menu.variants.index')
            ->with('success', 'Variant deleted successfully.');
    }
}
