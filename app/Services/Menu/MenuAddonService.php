<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Models\MenuAddon;
use App\Repositories\Contracts\MenuAddonRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuAddonService
{
    public function __construct(
        private readonly MenuAddonRepositoryInterface $addonRepository,
    ) {
    }

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->addonRepository->paginate($perPage);
    }

    public function create(array $data): MenuAddon
    {
        return $this->addonRepository->create($data);
    }

    public function update(int $id, array $data): MenuAddon
    {
        return $this->addonRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->addonRepository->delete($id);
    }

    public function findOrFail(int $id): MenuAddon
    {
        return $this->addonRepository->findOrFail($id);
    }
}
