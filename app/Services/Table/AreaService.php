<?php

declare(strict_types=1);

namespace App\Services\Table;

use App\Models\Area;
use App\Repositories\Contracts\AreaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AreaService
{
    public function __construct(
        private readonly AreaRepositoryInterface $areaRepository,
    ) {
    }

    public function all(): Collection
    {
        return $this->areaRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->areaRepository->paginate($perPage);
    }

    public function find(int $id): Area
    {
        return $this->areaRepository->findOrFail($id);
    }

    public function create(array $data): Area
    {
        return $this->areaRepository->create([
            'name' => $data['name'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): Area
    {
        return $this->areaRepository->update($id, [
            'name' => $data['name'],
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->areaRepository->delete($id);
    }
}
