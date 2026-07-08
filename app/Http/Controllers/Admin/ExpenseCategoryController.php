<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Expense\ExpenseCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseCategoryController extends Controller
{
    public function __construct(
        private readonly ExpenseCategoryService $expenseCategoryService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.expenses.categories.index', [
            'categories' => $this->expenseCategoryService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.expenses.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->expenseCategoryService->create($data);

        return redirect()
            ->route('admin.expenses.categories.index')
            ->with('success', 'Expense category created successfully.');
    }

    public function edit(int $category): View
    {
        return view('restaurant.admin.expenses.categories.edit', [
            'category' => $this->expenseCategoryService->find($category),
        ]);
    }

    public function update(Request $request, int $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $this->expenseCategoryService->update($category, $data);

        return redirect()
            ->route('admin.expenses.categories.index')
            ->with('success', 'Expense category updated successfully.');
    }

    public function destroy(int $category): RedirectResponse
    {
        $this->expenseCategoryService->delete($category);

        return redirect()
            ->route('admin.expenses.categories.index')
            ->with('success', 'Expense category deleted successfully.');
    }
}
