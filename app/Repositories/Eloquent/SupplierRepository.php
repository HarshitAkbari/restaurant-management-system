<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Supplier());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Supplier
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Supplier
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Supplier
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }
}
