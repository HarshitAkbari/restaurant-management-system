<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /** @var list<string> */
    private const PERMISSIONS = [
        'dashboard.view',
        'orders.read',
        'orders.write',
        'orders.void',
        'menu.read',
        'menu.write',
        'tables.read',
        'tables.write',
        'inventory.read',
        'inventory.write',
        'staff.read',
        'staff.write',
        'staff.roles',
        'customers.read',
        'customers.write',
        'reports.read',
        'expenses.read',
        'expenses.write',
        'settings.profile',
        'settings.tax',
        'settings.payments',
        'settings.printers',
        'settings.outlets',
        'pos.access',
        'pos.pay',
        'pos.void',
        'kitchen.access',
        'loyalty.manage',
        'online.manage',
    ];

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $this->seedOwnerRole();
        $this->seedManagerRole();
        $this->seedCashierRole();
        $this->seedWaiterRole();
        $this->seedKitchenRole();
    }

    private function seedOwnerRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
        $role->syncPermissions(self::PERMISSIONS);
    }

    private function seedManagerRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $role->syncPermissions([
            'dashboard.view',
            'orders.read',
            'orders.write',
            'orders.void',
            'menu.read',
            'menu.write',
            'tables.read',
            'tables.write',
            'inventory.read',
            'inventory.write',
            'staff.read',
            'staff.write',
            'customers.read',
            'customers.write',
            'reports.read',
            'expenses.read',
            'expenses.write',
            'settings.payments',
            'settings.printers',
            'pos.access',
            'pos.pay',
            'pos.void',
            'kitchen.access',
            'loyalty.manage',
        ]);
    }

    private function seedCashierRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'cashier', 'guard_name' => 'web']);
        $role->syncPermissions([
            'dashboard.view',
            'orders.read',
            'orders.write',
            'pos.access',
            'pos.pay',
        ]);
    }

    private function seedWaiterRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'waiter', 'guard_name' => 'web']);
        $role->syncPermissions([
            'dashboard.view',
            'orders.read',
            'tables.read',
            'pos.access',
        ]);
    }

    private function seedKitchenRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'kitchen', 'guard_name' => 'web']);
        $role->syncPermissions([
            'dashboard.view',
            'kitchen.access',
        ]);
    }
}
