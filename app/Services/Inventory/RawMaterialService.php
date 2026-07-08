<?php

declare(strict_types=1);

namespace App\Services\Inventory;

use App\Models\RawMaterial;
use App\Repositories\Contracts\RawMaterialRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RawMaterialService
{
    public function __construct(
        private readonly RawMaterialRepositoryInterface $rawMaterialRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->rawMaterialRepository->paginate($perPage);
    }

    public function all(): Collection
    {
        return $this->rawMaterialRepository->all();
    }

    public function find(int $id): RawMaterial
    {
        return $this->rawMaterialRepository->findOrFail($id);
    }

    public function lowStock(): Collection
    {
        return $this->rawMaterialRepository->lowStock();
    }

    public function create(array $data): RawMaterial
    {
        return $this->rawMaterialRepository->create([
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'unit' => $data['unit'] ?? 'kg',
            'current_stock' => (float) ($data['current_stock'] ?? 0),
            'reorder_level' => (float) ($data['reorder_level'] ?? 0),
            'cost_per_unit' => (float) ($data['cost_per_unit'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): RawMaterial
    {
        return $this->rawMaterialRepository->update($id, [
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'unit' => $data['unit'] ?? 'kg',
            'current_stock' => (float) ($data['current_stock'] ?? 0),
            'reorder_level' => (float) ($data['reorder_level'] ?? 0),
            'cost_per_unit' => (float) ($data['cost_per_unit'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }
}
