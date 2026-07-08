<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Table\StoreAreaRequest;
use App\Http\Requests\Admin\Table\UpdateAreaRequest;
use App\Services\Table\AreaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function __construct(
        private readonly AreaService $areaService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.tables.areas.index', [
            'areas' => $this->areaService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.tables.areas.create');
    }

    public function store(StoreAreaRequest $request): RedirectResponse
    {
        $this->areaService->create($request->validated());

        return redirect()
            ->route('admin.tables.areas.index')
            ->with('success', 'Area created successfully.');
    }

    public function edit(int $area): View
    {
        return view('restaurant.admin.tables.areas.edit', [
            'area' => $this->areaService->find($area),
        ]);
    }

    public function update(UpdateAreaRequest $request, int $area): RedirectResponse
    {
        $this->areaService->update($area, $request->validated());

        return redirect()
            ->route('admin.tables.areas.index')
            ->with('success', 'Area updated successfully.');
    }

    public function destroy(int $area): RedirectResponse
    {
        $this->areaService->delete($area);

        return redirect()
            ->route('admin.tables.areas.index')
            ->with('success', 'Area deleted successfully.');
    }
}
