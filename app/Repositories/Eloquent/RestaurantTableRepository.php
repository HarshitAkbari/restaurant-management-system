<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\TableStatus;
use App\Models\RestaurantTable;
use App\Repositories\Contracts\RestaurantTableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantTableRepository extends BaseRepository implements RestaurantTableRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new RestaurantTable());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?RestaurantTable
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): RestaurantTable
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): RestaurantTable
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): RestaurantTable
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function allWithArea(): Collection
    {
        return $this->model->newQuery()
            ->with('area')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function updateStatus(int $id, TableStatus $status): RestaurantTable
    {
        return $this->update($id, ['status' => $status]);
    }
}
