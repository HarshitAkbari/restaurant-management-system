<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Expense\ExpenseCategoryService;
use App\Services\Expense\ExpenseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(
        private readonly ExpenseService $expenseService,
        private readonly ExpenseCategoryService $expenseCategoryService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.expenses.index', [
            'expenses' => $this->expenseService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.expenses.create', [
            'categories' => $this->expenseCategoryService->allActive(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $this->expenseService->create($data, (int) $request->user()->id);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    public function edit(int $expense): View
    {
        return view('restaurant.admin.expenses.edit', [
            'expense' => $this->expenseService->find($expense),
            'categories' => $this->expenseCategoryService->allActive(),
        ]);
    }

    public function update(Request $request, int $expense): RedirectResponse
    {
        $data = $request->validate([
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $this->expenseService->update($expense, $data);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(int $expense): RedirectResponse
    {
        $this->expenseService->delete($expense);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
