<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create users with profiles using factory
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'phone' => '01714532308',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $admin->roles()->attach(Role::where('name', 'Admin')->first());

        $moderator = User::factory()->create([
            'name' => 'Moderator User',
            'phone' => '01714932315',
            'email' => 'moderator@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $moderator->roles()->attach(Role::where('name', 'Moderator')->first());

        $customer = User::factory()->create([
            'name' => 'Customer User',
            'phone' => '01714582315',
            'email' => 'customer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
        $customer->roles()->attach(Role::where('name', 'Customer')->first());
    }
}
