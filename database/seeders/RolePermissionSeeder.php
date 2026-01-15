<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
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

        // Get all permissions
        $allPermissions = Permission::pluck('id')->toArray();
        $moderatorPermissions = Permission::whereIn('name', [
            'view_users',
            'view_products',
            'view_categories',
            'view_brands',
            'view_orders',
            'manage_content',
            'upload_media',
        ])->pluck('id')->toArray();

        $customerPermissions = Permission::whereIn('name', [
            'view_own_orders',
            'place_order',
            'manage_wishlist',
            'write_reviews',
        ])->pluck('id')->toArray();

        // Assign permissions
        Role::where('name', 'admin')->first()->permissions()->sync($allPermissions);
        Role::where('name', 'moderator')->first()->permissions()->sync($moderatorPermissions);
        Role::where('name', 'customer')->first()->permissions()->sync($customerPermissions);
    }
}
