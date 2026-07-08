<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\KotStatus;
use App\Models\Kot;
use App\Repositories\Contracts\KotRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class KotRepository extends BaseRepository implements KotRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Kot());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Kot
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Kot
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Kot
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Kot
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function pendingByStation(?string $station): Collection
    {
        $query = $this->model->newQuery()
            ->with(['order', 'items', 'creator'])
            ->where('status', KotStatus::Pending);

        if ($station !== null) {
            $query->where('station', $station);
        }

        return $query->latest()->get();
    }

    public function nextKotNumber(): string
    {
        $date = now()->format('Ymd');
        $numberPrefix = "KOT-{$date}-";

        $lastRecord = $this->model->newQuery()
            ->where('kot_number', 'like', $numberPrefix . '%')
            ->orderByDesc('kot_number')
            ->first();

        $sequence = 1;

        if ($lastRecord !== null) {
            $sequence = ((int) substr((string) $lastRecord->kot_number, -4)) + 1;
        }

        return $numberPrefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public function updateStatus(int $id, KotStatus $status): Kot
    {
        return $this->update($id, ['status' => $status]);
    }
}
