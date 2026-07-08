<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\OnlineOrderStatus;
use App\Models\OnlineOrder;
use App\Repositories\Contracts\OnlineOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OnlineOrderRepository extends BaseRepository implements OnlineOrderRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new OnlineOrder());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?OnlineOrder
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): OnlineOrder
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): OnlineOrder
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): OnlineOrder
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function pending(): Collection
    {
        return $this->model->newQuery()
            ->where('status', OnlineOrderStatus::Pending)
            ->latest()
            ->get();
    }

    public function updateStatus(int $id, OnlineOrderStatus $status): OnlineOrder
    {
        return $this->update($id, ['status' => $status]);
    }
}
