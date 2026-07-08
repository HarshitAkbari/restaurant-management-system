<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DayClose;
use App\Repositories\Contracts\DayCloseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DayCloseRepository extends BaseRepository implements DayCloseRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new DayClose());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?DayClose
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): DayClose
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): DayClose
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): DayClose
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function findByDate(string $date): ?DayClose
    {
        return $this->model->newQuery()
            ->whereDate('business_date', $date)
            ->first();
    }
}
