<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreItemRequest;
use App\Http\Requests\Admin\Menu\UpdateItemRequest;
use App\Services\Menu\MenuCategoryService;
use App\Services\Menu\MenuItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function __construct(
        private readonly MenuItemService $itemService,
        private readonly MenuCategoryService $categoryService,
    ) {
    }

    public function index(): View
    {
        $items = $this->itemService->list();

        return view('restaurant.admin.menu.items.index', compact('items'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->allForSelect();

        return view('restaurant.admin.menu.items.create', compact('categories'));
    }

    public function store(StoreItemRequest $request): RedirectResponse
    {
        $this->itemService->create($request->validated());

        return redirect()
            ->route('admin.menu.items.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(int $item): View
    {
        $itemModel = $this->itemService->findOrFail($item);
        $categories = $this->categoryService->allForSelect();

        return view('restaurant.admin.menu.items.edit', [
            'item' => $itemModel,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateItemRequest $request, int $item): RedirectResponse
    {
        $this->itemService->update($item, $request->validated());

        return redirect()
            ->route('admin.menu.items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(int $item): RedirectResponse
    {
        $this->itemService->delete($item);

        return redirect()
            ->route('admin.menu.items.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    public function toggleAvailability(int $item): RedirectResponse
    {
        $updated = $this->itemService->toggleAvailability($item);

        $status = $updated->is_available ? 'available' : 'unavailable';

        return redirect()
            ->back()
            ->with('success', "Item marked as {$status}.");
    }
}
