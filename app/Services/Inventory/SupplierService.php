<?php

declare(strict_types=1);

namespace App\Services\Inventory;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierService
{
    public function __construct(
        private readonly SupplierRepositoryInterface $supplierRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->supplierRepository->paginate($perPage);
    }

    public function allActive(): Collection
    {
        return $this->supplierRepository->all()
            ->where('is_active', true)
            ->values();
    }

    public function find(int $id): Supplier
    {
        return $this->supplierRepository->findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return $this->supplierRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): Supplier
    {
        return $this->supplierRepository->update($id, [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }
}
