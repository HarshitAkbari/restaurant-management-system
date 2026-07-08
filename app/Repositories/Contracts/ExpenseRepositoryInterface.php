<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExpenseRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Expense;

    public function findOrFail(int $id): Expense;

    public function create(array $data): Expense;

    public function update(int $id, array $data): Expense;

    public function delete(int $id): bool;

    public function paginateWithCategory(int $perPage): LengthAwarePaginator;
}
