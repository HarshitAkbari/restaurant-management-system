<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\PurchaseOrder;
use App\Repositories\Contracts\PurchaseOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseOrderRepository extends BaseRepository implements PurchaseOrderRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new PurchaseOrder());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?PurchaseOrder
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): PurchaseOrder
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): PurchaseOrder
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): PurchaseOrder
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function nextPoNumber(): string
    {
        $date = now()->format('Ymd');
        $numberPrefix = "PO-{$date}-";

        $lastRecord = $this->model->newQuery()
            ->where('po_number', 'like', $numberPrefix . '%')
            ->orderByDesc('po_number')
            ->first();

        $sequence = 1;

        if ($lastRecord !== null) {
            $sequence = ((int) substr((string) $lastRecord->po_number, -4)) + 1;
        }

        return $numberPrefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
