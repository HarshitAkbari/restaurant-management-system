<?php

declare(strict_types=1);

namespace App\Services\Expense;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseService
{
    public function __construct(
        private readonly ExpenseRepositoryInterface $expenseRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->expenseRepository->paginateWithCategory($perPage);
    }

    public function find(int $id): Expense
    {
        $expense = $this->expenseRepository->find($id);

        if ($expense === null) {
            abort(404);
        }

        return $expense->load(['category', 'recordedBy']);
    }

    public function create(array $data, int $userId): Expense
    {
        return $this->expenseRepository->create([
            'expense_category_id' => (int) $data['expense_category_id'],
            'title' => $data['title'],
            'amount' => (float) $data['amount'],
            'expense_date' => $data['expense_date'],
            'payment_method' => $data['payment_method'] ?? null,
            'notes' => $data['notes'] ?? null,
            'recorded_by' => $userId,
        ]);
    }

    public function update(int $id, array $data): Expense
    {
        return $this->expenseRepository->update($id, [
            'expense_category_id' => (int) $data['expense_category_id'],
            'title' => $data['title'],
            'amount' => (float) $data['amount'],
            'expense_date' => $data['expense_date'],
            'payment_method' => $data['payment_method'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->expenseRepository->delete($id);
    }
}
