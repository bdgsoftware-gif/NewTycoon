<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure base roles exist
        $roles = [
            'admin' => 'Administrator',
            'moderator' => 'Moderator',
            'customer' => 'Customer',
        ];

        foreach ($roles as $name => $display) {
            Role::firstOrCreate(
                ['name' => $name],
                ['display_name' => $display]
            );
        }

        // Create permissions
        $permissions = [
            ['name' => 'view_orders', 'display_name' => 'View Orders'],
            ['name' => 'update_orders', 'display_name' => 'Update Orders'],
            ['name' => 'manage_products', 'display_name' => 'Manage Products'],

            ['name' => 'view_own_orders', 'display_name' => 'View Own Orders'],
            ['name' => 'place_order', 'display_name' => 'Place Order'],

            ['name' => 'manage_users', 'display_name' => 'Manage Users'],
            ['name' => 'manage_roles', 'display_name' => 'Manage Roles'],
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
            ['name' => 'manage_settings', 'display_name' => 'Manage Settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => null,
                ]
            );
        }

        // Reload roles after creation
        $adminRole = Role::where('name', 'admin')->first();
        $moderatorRole = Role::where('name', 'moderator')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Assign: Admin gets all permissions
        $adminRole->permissions()->sync(Permission::pluck('id')->toArray());

        // Assign: Moderator
        $moderatorRole->permissions()->sync(
            Permission::whereIn('name', [
                'view_orders',
                'update_orders',
                'manage_products',
            ])->pluck('id')->toArray()
        );

        // Assign: Customer
        $customerRole->permissions()->sync(
            Permission::whereIn('name', [
                'view_own_orders',
                'place_order',
            ])->pluck('id')->toArray()
        );
    }
}
