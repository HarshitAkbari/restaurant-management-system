<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Customer());
    }

    public function all(array $columns = ['*']): Collection
    {
        return parent::all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return parent::paginate($perPage, $columns);
    }

    public function find(int $id): ?Customer
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id): Customer
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Customer
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): Customer
    {
        return parent::update($id, $data);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function search(?string $term, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->where('is_active', true);

        if ($term !== null && $term !== '') {
            $query->where(function ($builder) use ($term): void {
                $builder->where('name', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
