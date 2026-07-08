<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Expense());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Expense
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Expense
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Expense
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Expense
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function paginateWithCategory(int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['category', 'recordedBy'])
            ->latest()
            ->paginate($perPage);
    }
}
