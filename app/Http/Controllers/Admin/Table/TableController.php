<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Table\StoreTableRequest;
use App\Http\Requests\Admin\Table\UpdateTableRequest;
use App\Services\Table\TableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TableController extends Controller
{
    public function __construct(
        private readonly TableService $tableService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.tables.tables.index', [
            'tables' => $this->tableService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.tables.tables.create', [
            'areas' => $this->tableService->activeAreas(),
        ]);
    }

    public function store(StoreTableRequest $request): RedirectResponse
    {
        $this->tableService->create($request->validated());

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Table created successfully.');
    }

    public function edit(int $table): View
    {
        return view('restaurant.admin.tables.tables.edit', [
            'table' => $this->tableService->find($table),
            'areas' => $this->tableService->activeAreas(),
        ]);
    }

    public function update(UpdateTableRequest $request, int $table): RedirectResponse
    {
        $this->tableService->update($table, $request->validated());

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Table updated successfully.');
    }

    public function destroy(int $table): RedirectResponse
    {
        $this->tableService->delete($table);

        return redirect()
            ->route('admin.tables.index')
            ->with('success', 'Table deleted successfully.');
    }

    public function layout(): View
    {
        return view('restaurant.admin.tables.tables.layout', [
            'areas' => $this->tableService->layout(),
        ]);
    }
}
