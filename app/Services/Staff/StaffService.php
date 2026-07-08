<?php

declare(strict_types=1);

namespace App\Services\Staff;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id): User
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            abort(404);
        }

        return $user->load('roles');
    }

    public function create(array $data): User
    {
        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'is_active' => (bool) ($data['is_active'] ?? true),
            'preferred_landing' => $data['preferred_landing'] ?? null,
        ]);

        if (! empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user->load('roles');
    }

    public function update(int $id, array $data): User
    {
        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'preferred_landing' => $data['preferred_landing'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user = $this->userRepository->update($id, $payload);

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user->load('roles');
    }

    public function deactivate(int $id): User
    {
        return $this->userRepository->update($id, ['is_active' => false]);
    }
}
