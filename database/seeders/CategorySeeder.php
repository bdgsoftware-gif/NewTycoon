<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Air Conditioner',
                'image' => 'images/cat/ac.png',
            ],
            [
                'id' => 2,
                'name' => 'Fan',
                'image' => 'images/cat/fan.png',
            ],
            [
                'id' => 3,
                'name' => 'Room Comforter',
                'image' => 'images/cat/room-comporter.png',
            ],
            [
                'id' => 4,
                'name' => 'Cookware',
                'image' => 'images/cat/cookware.png',
            ],
            [
                'id' => 5,
                'name' => 'Gas Burner',
                'image' => 'images/cat/gas-burner.png',
            ],
            [
                'id' => 6,
                'name' => 'Pressure Cooker',
                'image' => 'images/cat/pressure-cooker.png',
            ],
            [
                'id' => 7,
                'name' => 'Rice Cooker',
                'image' => 'images/cat/rice-cooker.png',
            ],
            [
                'id' => 8,
                'name' => 'Electric Kettle',
                'image' => 'images/cat/electric-kettle.png',
            ],
            [
                'id' => 9,
                'name' => 'Mixer Grinder',
                'image' => 'images/cat/mixer-grinder.png',
            ],
            [
                'id' => 10,
                'name' => 'LED TV',
                'image' => 'images/cat/led-tv.png',
            ],
            [
                'id' => 11,
                'name' => 'Monitor',
                'image' => 'images/cat/monitor.png',
            ],
            [
                'id' => 12,
                'name' => 'Refrigerator',
                'image' => 'images/cat/refrigerator.png',
            ],
        ];

        $order = 1;

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['id' => $data['id']],
                [
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'description' => $data['name'] . ' products and accessories.',
                    'image' => $data['image'],
                    'parent_id' => null,
                    'order' => $order++,
                    'is_featured' => false,
                    'is_active' => true,
                    'meta_title' => $data['name'],
                    'meta_description' => 'Shop for ' . strtolower($data['name']) . ' at best prices.',
                    'meta_keywords' => strtolower(str_replace(' ', ', ', $data['name'])),
                ]
            );
        }
    }
}
