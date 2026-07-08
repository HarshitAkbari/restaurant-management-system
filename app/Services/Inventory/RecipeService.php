<?php

declare(strict_types=1);

namespace App\Services\Inventory;

use App\Models\Recipe;
use App\Models\RecipeItem;
use App\Repositories\Contracts\RecipeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RecipeService
{
    public function __construct(
        private readonly RecipeRepositoryInterface $recipeRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Recipe::query()
            ->with(['menuItem', 'items.rawMaterial'])
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id): Recipe
    {
        $recipe = $this->recipeRepository->find($id);

        if ($recipe === null) {
            abort(404);
        }

        return $recipe->load(['menuItem', 'items.rawMaterial']);
    }

    public function findByMenuItem(int $menuItemId): ?Recipe
    {
        return $this->recipeRepository->findByMenuItem($menuItemId);
    }

    public function create(array $data): Recipe
    {
        return DB::transaction(function () use ($data): Recipe {
            $recipe = $this->recipeRepository->create([
                'menu_item_id' => (int) $data['menu_item_id'],
                'name' => $data['name'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $this->syncItems($recipe, $data['items'] ?? []);

            return $recipe->load(['menuItem', 'items.rawMaterial']);
        });
    }

    public function update(int $id, array $data): Recipe
    {
        return DB::transaction(function () use ($id, $data): Recipe {
            $recipe = $this->recipeRepository->update($id, [
                'menu_item_id' => (int) $data['menu_item_id'],
                'name' => $data['name'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $this->syncItems($recipe, $data['items'] ?? []);

            return $recipe->load(['menuItem', 'items.rawMaterial']);
        });
    }

    public function delete(int $id): bool
    {
        return $this->recipeRepository->delete($id);
    }

    /**
     * @param  array<int, array{raw_material_id: int|string, quantity: float|string}>  $items
     */
    private function syncItems(Recipe $recipe, array $items): void
    {
        $recipe->items()->delete();

        foreach ($items as $item) {
            if (empty($item['raw_material_id']) || empty($item['quantity'])) {
                continue;
            }

            RecipeItem::query()->create([
                'recipe_id' => $recipe->id,
                'raw_material_id' => (int) $item['raw_material_id'],
                'quantity' => (float) $item['quantity'],
            ]);
        }
    }
}
