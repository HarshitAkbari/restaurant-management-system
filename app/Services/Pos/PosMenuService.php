<?php

declare(strict_types=1);

namespace App\Services\Pos;

use App\Repositories\Contracts\MenuCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PosMenuService
{
    public function __construct(
        private readonly MenuCategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function getMenuForBilling(): Collection
    {
        return $this->categoryRepository->allActiveWithAvailableItems();
    }
}
