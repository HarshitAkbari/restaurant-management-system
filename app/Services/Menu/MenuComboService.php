<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Models\MenuCombo;
use App\Repositories\Contracts\MenuComboRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuComboService
{
    public function __construct(
        private readonly MenuComboRepositoryInterface $comboRepository,
    ) {
    }

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        $combos = $this->comboRepository->paginate($perPage);
        $combos->load('items');

        return $combos;
    }

    public function create(array $data): MenuCombo
    {
        $itemIds = $data['item_ids'] ?? [];
        unset($data['item_ids']);

        $combo = $this->comboRepository->create($data);
        $this->syncItems($combo, $itemIds);

        return $combo->load('items');
    }

    public function update(int $id, array $data): MenuCombo
    {
        $itemIds = $data['item_ids'] ?? null;
        unset($data['item_ids']);

        $combo = $this->comboRepository->update($id, $data);

        if ($itemIds !== null) {
            $this->syncItems($combo, $itemIds);
        }

        return $combo->load('items');
    }

    public function delete(int $id): bool
    {
        return $this->comboRepository->delete($id);
    }

    public function findOrFail(int $id): MenuCombo
    {
        $combo = $this->comboRepository->findOrFail($id);
        $combo->load('items');

        return $combo;
    }

    /**
     * @param  list<int|string>  $itemIds
     */
    private function syncItems(MenuCombo $combo, array $itemIds): void
    {
        $syncData = [];

        foreach ($itemIds as $itemId) {
            $syncData[(int) $itemId] = ['quantity' => 1];
        }

        $combo->items()->sync($syncData);
    }
}
