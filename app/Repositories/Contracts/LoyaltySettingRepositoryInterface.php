<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\LoyaltySetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface LoyaltySettingRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?LoyaltySetting;

    public function findOrFail(int $id): LoyaltySetting;

    public function create(array $data): LoyaltySetting;

    public function update(int $id, array $data): LoyaltySetting;

    public function delete(int $id): bool;

    public function firstOrCreateDefault(): LoyaltySetting;
}
