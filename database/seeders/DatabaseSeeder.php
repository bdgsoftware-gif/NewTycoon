<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,              // 1st: Create roles
            PermissionSeeder::class,        // 2nd: Create permissions
            RolePermissionSeeder::class,    // 3rd: Link roles & permissions
            UserSeeder::class,              // 4th: Create users with roles
            UserProfileSeeder::class,       // 5th: Create user profiles
        ]);
    }
}
