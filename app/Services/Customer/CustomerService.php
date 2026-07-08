<?php

declare(strict_types=1);

namespace App\Services\Customer;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function search(?string $term, int $perPage = 15): LengthAwarePaginator
    {
        return $this->customerRepository->search($term, $perPage);
    }

    public function find(int $id): Customer
    {
        $customer = $this->customerRepository->find($id);

        if ($customer === null) {
            abort(404);
        }

        return $customer->loadCount('orders');
    }

    public function create(array $data): Customer
    {
        return $this->customerRepository->create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'loyalty_points' => (int) ($data['loyalty_points'] ?? 0),
            'notes' => $data['notes'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }

    public function update(int $id, array $data): Customer
    {
        return $this->customerRepository->update($id, [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'loyalty_points' => (int) ($data['loyalty_points'] ?? 0),
            'notes' => $data['notes'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);
    }
}
