<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\LoyaltySetting;
use App\Repositories\Contracts\LoyaltySettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LoyaltySettingRepository extends BaseRepository implements LoyaltySettingRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new LoyaltySetting());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?LoyaltySetting
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): LoyaltySetting
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): LoyaltySetting
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): LoyaltySetting
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function firstOrCreateDefault(): LoyaltySetting
    {
        $setting = $this->model->newQuery()->first();

        if ($setting !== null) {
            return $setting;
        }

        return $this->create([
            'is_enabled' => false,
            'points_per_rupee' => 1,
            'rupee_per_point' => 0.25,
            'min_redeem_points' => 100,
        ]);
    }
}
