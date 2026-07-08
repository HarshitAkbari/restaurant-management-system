<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Models\MenuItem;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuItemService
{
    public function __construct(
        private readonly MenuItemRepositoryInterface $itemRepository,
    ) {
    }

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->itemRepository->paginateWithCategory($perPage);
    }

    public function create(array $data): MenuItem
    {
        return $this->itemRepository->create($data);
    }

    public function update(int $id, array $data): MenuItem
    {
        return $this->itemRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->itemRepository->delete($id);
    }

    public function findOrFail(int $id): MenuItem
    {
        return $this->itemRepository->findOrFail($id);
    }

    public function toggleAvailability(int $id): MenuItem
    {
        $item = $this->itemRepository->findOrFail($id);

        return $this->itemRepository->update($id, [
            'is_available' => ! $item->is_available,
        ]);
    }
}
