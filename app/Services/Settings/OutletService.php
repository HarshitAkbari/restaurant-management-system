<?php

declare(strict_types=1);

namespace App\Services\Settings;

use App\Models\Outlet;
use App\Repositories\Contracts\OutletRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OutletService
{
    public function __construct(
        private readonly OutletRepositoryInterface $outletRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->outletRepository->paginate($perPage);
    }

    public function find(int $id): Outlet
    {
        return $this->outletRepository->findOrFail($id);
    }

    public function create(array $data): Outlet
    {
        if (! empty($data['is_primary'])) {
            Outlet::query()->update(['is_primary' => false]);
        }

        return $this->outletRepository->create([
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'is_primary' => (bool) ($data['is_primary'] ?? false),
        ]);
    }

    public function update(int $id, array $data): Outlet
    {
        if (! empty($data['is_primary'])) {
            Outlet::query()->where('id', '!=', $id)->update(['is_primary' => false]);
        }

        return $this->outletRepository->update($id, [
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'is_primary' => (bool) ($data['is_primary'] ?? false),
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->outletRepository->delete($id);
    }
}
