<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\RestaurantSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RestaurantSettingRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?RestaurantSetting;

    public function findOrFail(int $id): RestaurantSetting;

    public function create(array $data): RestaurantSetting;

    public function update(int $id, array $data): RestaurantSetting;

    public function delete(int $id): bool;

    public function firstOrCreateDefault(): RestaurantSetting;
}
