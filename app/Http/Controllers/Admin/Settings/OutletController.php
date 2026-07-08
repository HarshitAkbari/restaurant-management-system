<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Services\Settings\OutletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutletController extends Controller
{
    public function __construct(
        private readonly OutletService $outletService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.settings.outlets.index', [
            'outlets' => $this->outletService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.settings.outlets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'is_primary' => ['sometimes', 'boolean'],
        ]);

        $this->outletService->create($data);

        return redirect()
            ->route('admin.settings.outlets.index')
            ->with('success', 'Outlet created successfully.');
    }

    public function edit(int $outlet): View
    {
        return view('restaurant.admin.settings.outlets.edit', [
            'outlet' => $this->outletService->find($outlet),
        ]);
    }

    public function update(Request $request, int $outlet): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'is_primary' => ['sometimes', 'boolean'],
        ]);

        $this->outletService->update($outlet, $data);

        return redirect()
            ->route('admin.settings.outlets.index')
            ->with('success', 'Outlet updated successfully.');
    }

    public function destroy(int $outlet): RedirectResponse
    {
        $this->outletService->delete($outlet);

        return redirect()
            ->route('admin.settings.outlets.index')
            ->with('success', 'Outlet deleted successfully.');
    }
}
