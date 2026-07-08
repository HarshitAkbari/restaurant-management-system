<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreAddonRequest;
use App\Http\Requests\Admin\Menu\UpdateAddonRequest;
use App\Services\Menu\MenuAddonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AddonController extends Controller
{
    public function __construct(
        private readonly MenuAddonService $addonService,
    ) {
    }

    public function index(): View
    {
        $addons = $this->addonService->list();

        return view('restaurant.admin.menu.addons.index', compact('addons'));
    }

    public function create(): View
    {
        return view('restaurant.admin.menu.addons.create');
    }

    public function store(StoreAddonRequest $request): RedirectResponse
    {
        $this->addonService->create($request->validated());

        return redirect()
            ->route('admin.menu.addons.index')
            ->with('success', 'Add-on created successfully.');
    }

    public function edit(int $addon): View
    {
        $addonModel = $this->addonService->findOrFail($addon);

        return view('restaurant.admin.menu.addons.edit', ['addon' => $addonModel]);
    }

    public function update(UpdateAddonRequest $request, int $addon): RedirectResponse
    {
        $this->addonService->update($addon, $request->validated());

        return redirect()
            ->route('admin.menu.addons.index')
            ->with('success', 'Add-on updated successfully.');
    }

    public function destroy(int $addon): RedirectResponse
    {
        $this->addonService->delete($addon);

        return redirect()
            ->route('admin.menu.addons.index')
            ->with('success', 'Add-on deleted successfully.');
    }
}
