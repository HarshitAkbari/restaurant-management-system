<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\RestaurantSetting;
use App\Repositories\Contracts\RestaurantSettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantSettingRepository extends BaseRepository implements RestaurantSettingRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new RestaurantSetting());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?RestaurantSetting
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): RestaurantSetting
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): RestaurantSetting
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): RestaurantSetting
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function firstOrCreateDefault(): RestaurantSetting
    {
        $setting = $this->model->newQuery()->first();

        if ($setting !== null) {
            return $setting;
        }

        return $this->create([
            'name' => 'My Restaurant',
            'currency' => 'INR',
            'timezone' => 'Asia/Kolkata',
            'cgst_percent' => 2.50,
            'sgst_percent' => 2.50,
            'service_charge_percent' => 0,
        ]);
    }
}
