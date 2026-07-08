<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use App\Repositories\Contracts\MenuItemRepositoryInterface;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function __construct(
        private readonly MenuCategoryRepositoryInterface $categoryRepository,
        private readonly MenuItemRepositoryInterface $menuItemRepository,
    ) {
    }

    public function categories(): JsonResponse
    {
        $categories = $this->categoryRepository->allActive();

        return response()->json([
            'data' => $categories->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'sort_order' => $category->sort_order,
            ])->values(),
        ]);
    }

    public function items(): JsonResponse
    {
        $items = $this->menuItemRepository->allAvailable();

        return response()->json([
            'data' => $items->map(fn ($item) => [
                'id' => $item->id,
                'menu_category_id' => $item->menu_category_id,
                'name' => $item->name,
                'sku' => $item->sku,
                'price' => (float) $item->price,
                'food_type' => $item->food_type->value,
                'is_veg' => $item->is_veg,
                'is_available' => $item->is_available,
                'kitchen_station' => $item->kitchen_station,
            ])->values(),
        ]);
    }
}
