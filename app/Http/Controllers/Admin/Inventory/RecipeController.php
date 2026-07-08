<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Services\Inventory\RawMaterialService;
use App\Services\Inventory\RecipeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct(
        private readonly RecipeService $recipeService,
        private readonly RawMaterialService $rawMaterialService,
    ) {
    }

    public function index(): View
    {
        return view('restaurant.admin.inventory.recipes.index', [
            'recipes' => $this->recipeService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('restaurant.admin.inventory.recipes.create', [
            'menuItems' => MenuItem::query()->orderBy('name')->get(),
            'materials' => $this->rawMaterialService->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'menu_item_id' => ['required', 'integer', 'exists:menu_items,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.raw_material_id' => ['required_with:items', 'integer', 'exists:raw_materials,id'],
            'items.*.quantity' => ['required_with:items', 'numeric', 'min:0.001'],
        ]);

        $this->recipeService->create($data);

        return redirect()
            ->route('admin.inventory.recipes.index')
            ->with('success', 'Recipe created successfully.');
    }

    public function edit(int $recipe): View
    {
        return view('restaurant.admin.inventory.recipes.edit', [
            'recipe' => $this->recipeService->find($recipe),
            'menuItems' => MenuItem::query()->orderBy('name')->get(),
            'materials' => $this->rawMaterialService->all(),
        ]);
    }

    public function update(Request $request, int $recipe): RedirectResponse
    {
        $data = $request->validate([
            'menu_item_id' => ['required', 'integer', 'exists:menu_items,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.raw_material_id' => ['required_with:items', 'integer', 'exists:raw_materials,id'],
            'items.*.quantity' => ['required_with:items', 'numeric', 'min:0.001'],
        ]);

        $this->recipeService->update($recipe, $data);

        return redirect()
            ->route('admin.inventory.recipes.index')
            ->with('success', 'Recipe updated successfully.');
    }

    public function destroy(int $recipe): RedirectResponse
    {
        $this->recipeService->delete($recipe);

        return redirect()
            ->route('admin.inventory.recipes.index')
            ->with('success', 'Recipe deleted successfully.');
    }
}
