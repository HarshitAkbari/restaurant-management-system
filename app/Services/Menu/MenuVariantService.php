<?php

declare(strict_types=1);

namespace App\Services\Menu;

use App\Models\MenuVariant;
use App\Repositories\Contracts\MenuVariantRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MenuVariantService
{
    public function __construct(
        private readonly MenuVariantRepositoryInterface $variantRepository,
    ) {
    }

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        $variants = $this->variantRepository->paginate($perPage);
        $variants->load('menuItem');

        return $variants;
    }

    public function create(array $data): MenuVariant
    {
        return $this->variantRepository->create($data);
    }

    public function update(int $id, array $data): MenuVariant
    {
        return $this->variantRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->variantRepository->delete($id);
    }

    public function findOrFail(int $id): MenuVariant
    {
        return $this->variantRepository->findOrFail($id);
    }
}
