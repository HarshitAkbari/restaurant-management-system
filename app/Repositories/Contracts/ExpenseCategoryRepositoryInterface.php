<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExpenseCategoryRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?ExpenseCategory;

    public function findOrFail(int $id): ExpenseCategory;

    public function create(array $data): ExpenseCategory;

    public function update(int $id, array $data): ExpenseCategory;

    public function delete(int $id): bool;
}
