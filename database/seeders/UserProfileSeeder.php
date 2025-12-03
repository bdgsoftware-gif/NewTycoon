<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'avatar' => 'https://example.com/avatars/1.png',
                'phone' => '555-0101',
                'date_of_birth' => '1990-01-15',
                'gender' => fake()->randomElement(['male', 'female', 'other']),
                'address' => '123 Main St',
                'city' => 'Cityville',
                'state' => 'CA',
                'country' => 'USA',
                'zip_code' => '90001',
                'bio' => 'Software engineer living in Cityville.',
                'website' => fake()->url(),
            ],
            [
                'avatar' => null,
                'phone' => '555-0102',
                'date_of_birth' => '1992-05-20',
                'gender' => fake()->randomElement(['male', 'female', 'other']),
                'address' => '456 Oak Ave',
                'city' => 'Townsburg',
                'state' => 'NY',
                'country' => 'USA',
                'zip_code' => '10001',
                'bio' => 'Photographer and traveler.',
                'website' => fake()->url(),
            ],
            [
                'avatar' => null,
                'phone' => '555-0103',
                'date_of_birth' => '1994-11-02',
                'gender' => fake()->randomElement(['male', 'female', 'other']),
                'address' => '789 Pine St',
                'city' => 'Mapleton',
                'state' => 'TX',
                'country' => 'USA',
                'zip_code' => '75001',
                'bio' => 'Writer and musician.',
                'website' => fake()->url(),
            ],
        ];

        foreach ($profiles as $profile) {
            $user = User::factory()->create();

            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($profile, ['user_id' => $user->id])
            );
        }
    }
}
