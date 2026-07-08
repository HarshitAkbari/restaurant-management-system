<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreCategoryRequest;
use App\Http\Requests\Admin\Menu\UpdateCategoryRequest;
use App\Services\Menu\MenuCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly MenuCategoryService $categoryService,
    ) {
    }

    public function index(): View
    {
        $categories = $this->categoryService->list();

        return view('restaurant.admin.menu.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('restaurant.admin.menu.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());

        return redirect()
            ->route('admin.menu.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(int $category): View
    {
        $categoryModel = $this->categoryService->findOrFail($category);

        return view('restaurant.admin.menu.categories.edit', ['category' => $categoryModel]);
    }

    public function update(UpdateCategoryRequest $request, int $category): RedirectResponse
    {
        $this->categoryService->update($category, $request->validated());

        return redirect()
            ->route('admin.menu.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(int $category): RedirectResponse
    {
        $this->categoryService->delete($category);

        return redirect()
            ->route('admin.menu.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
