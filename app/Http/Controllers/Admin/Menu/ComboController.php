<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreComboRequest;
use App\Http\Requests\Admin\Menu\UpdateComboRequest;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use App\Services\Menu\MenuComboService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ComboController extends Controller
{
    public function __construct(
        private readonly MenuComboService $comboService,
        private readonly MenuItemRepositoryInterface $itemRepository,
    ) {
    }

    public function index(): View
    {
        $combos = $this->comboService->list();

        return view('restaurant.admin.menu.combos.index', compact('combos'));
    }

    public function create(): View
    {
        $items = $this->itemRepository->all();

        return view('restaurant.admin.menu.combos.create', compact('items'));
    }

    public function store(StoreComboRequest $request): RedirectResponse
    {
        $this->comboService->create($request->validated());

        return redirect()
            ->route('admin.menu.combos.index')
            ->with('success', 'Combo created successfully.');
    }

    public function edit(int $combo): View
    {
        $comboModel = $this->comboService->findOrFail($combo);
        $items = $this->itemRepository->all();

        return view('restaurant.admin.menu.combos.edit', [
            'combo' => $comboModel,
            'items' => $items,
        ]);
    }

    public function update(UpdateComboRequest $request, int $combo): RedirectResponse
    {
        $this->comboService->update($combo, $request->validated());

        return redirect()
            ->route('admin.menu.combos.index')
            ->with('success', 'Combo updated successfully.');
    }

    public function destroy(int $combo): RedirectResponse
    {
        $this->comboService->delete($combo);

        return redirect()
            ->route('admin.menu.combos.index')
            ->with('success', 'Combo deleted successfully.');
    }
}
