<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'slug' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Full access to manage the application.',
            ],
            [
                'name' => 'moderator',
                'slug' => 'moderator',
                'display_name' => 'Moderator',
                'description' => 'Can moderate content and users.',
            ],
            [
                'name' => 'customer',
                'slug' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Regular user with standard permissions.',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                [
                    'slug' => $roleData['slug'],
                    'display_name' => $roleData['display_name'],
                    'description' => $roleData['description'],
                ]
            );
        }
    }
}
