<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'phone' => '01714532308',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        // Create Moderator
        $moderator = User::factory()->create([
            'name' => 'Moderator User',
            'phone' => '01714932315',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $moderator->roles()->attach(Role::where('name', 'moderator')->first());

        // Create 10 Customers
        for ($i = 1; $i <= 10; $i++) {
            $customer = User::factory()->create([
                'name' => 'Customer User ' . $i,
                'phone' => '0171' . rand(1000000, 9999999),
                'email' => 'customer' . $i . '@example.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
            ]);
            $customer->roles()->attach(Role::where('name', 'customer')->first());
        }

        // Create some vendors
        $vendor = User::factory()->create([
            'name' => 'Vendor User',
            'phone' => '01714982315',
            'email' => 'vendor@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $vendor->roles()->attach(Role::where('name', 'customer')->first());

        // Create 3 more vendors
        for ($i = 1; $i <= 3; $i++) {
            $vendor = User::factory()->create([
                'name' => 'Vendor ' . $i,
                'phone' => '0172' . rand(1000000, 9999999),
                'email' => 'vendor' . $i . '@example.com',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
            ]);
            $vendor->roles()->attach(Role::where('name', 'customer')->first());
        }
    }
}
