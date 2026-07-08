<?php

declare(strict_types=1);

namespace App\Services\Expense;

use App\Models\ExpenseCategory;
use App\Repositories\Contracts\ExpenseCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseCategoryService
{
    public function __construct(
        private readonly ExpenseCategoryRepositoryInterface $expenseCategoryRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->expenseCategoryRepository->paginate($perPage);
    }

    public function allActive(): Collection
    {
        return $this->expenseCategoryRepository->all()
            ->where('is_active', true)
            ->values();
    }

    public function find(int $id): ExpenseCategory
    {
        return $this->expenseCategoryRepository->findOrFail($id);
    }

    public function create(array $data): ExpenseCategory
    {
        return $this->expenseCategoryRepository->create([
            'name' => $data['name'],
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): ExpenseCategory
    {
        return $this->expenseCategoryRepository->update($id, [
            'name' => $data['name'],
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->expenseCategoryRepository->delete($id);
    }
}
