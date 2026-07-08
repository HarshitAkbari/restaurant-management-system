<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Models\MenuCategory;
use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class MenuCategoryService
{
    public function __construct(
        private readonly MenuCategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function list(): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate(15);
    }

    public function allForSelect(): Collection
    {
        return $this->categoryRepository->all()->sortBy('sort_order')->values();
    }

    public function create(array $data): MenuCategory
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data): MenuCategory
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    public function findOrFail(int $id): MenuCategory
    {
        return $this->categoryRepository->findOrFail($id);
    }

    private function generateUniqueSlug(string $name, ?int $exceptId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $exceptId)) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $exceptId = null): bool
    {
        $query = MenuCategory::query()->where('slug', $slug);

        if ($exceptId !== null) {
            $query->where('id', '!=', $exceptId);
        }

        return $query->exists();
    }
}
