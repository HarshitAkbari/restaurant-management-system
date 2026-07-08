<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\RawMaterial;
use App\Repositories\Contracts\RawMaterialRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RawMaterialRepository extends BaseRepository implements RawMaterialRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new RawMaterial());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?RawMaterial
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): RawMaterial
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): RawMaterial
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): RawMaterial
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function lowStock(): Collection
    {
        return $this->model->newQuery()
            ->where('is_active', true)
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->orderBy('name')
            ->get();
    }
}
