<?php

declare(strict_types=1);

namespace App\Services\Staff;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function allWithPermissions(): Collection
    {
        return Role::query()
            ->with('permissions')
            ->orderBy('name')
            ->get();
    }

    public function findByName(string $name): Role
    {
        $role = Role::query()->where('name', $name)->with('permissions')->first();

        if ($role === null) {
            abort(404);
        }

        return $role;
    }
}
