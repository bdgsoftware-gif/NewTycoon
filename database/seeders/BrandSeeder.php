<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Premium electronics and technology',
                'is_featured' => true,
                'website' => 'https://apple.com',
                'order' => 1,
                'logo' => null,
            ],
            [
                'name' => 'Samsung',
                'description' => 'Electronics and home appliances',
                'is_featured' => true,
                'website' => 'https://samsung.com',
                'order' => 2,
            ],
            [
                'name' => 'Sony',
                'description' => 'Audio, video, and gaming electronics',
                'is_featured' => true,
                'website' => 'https://sony.com',
                'order' => 3,
            ],
            [
                'name' => 'Nike',
                'description' => 'Athletic apparel and footwear',
                'is_featured' => true,
                'website' => 'https://nike.com',
                'order' => 4,
            ],
            [
                'name' => 'Adidas',
                'description' => 'Sports apparel and footwear',
                'website' => 'https://adidas.com',
                'order' => 5,
            ],
            [
                'name' => 'Microsoft',
                'description' => 'Software and electronics',
                'website' => 'https://microsoft.com',
                'order' => 6,
            ],
            [
                'name' => 'LG',
                'description' => 'Home appliances and electronics',
                'website' => 'https://lg.com',
                'order' => 7,
            ],
            [
                'name' => 'Canon',
                'description' => 'Cameras and imaging products',
                'website' => 'https://canon.com',
                'order' => 8,
            ],
            [
                'name' => 'Bosch',
                'description' => 'Home appliances and tools',
                'website' => 'https://bosch.com',
                'order' => 9,
            ],
            [
                'name' => 'Philips',
                'description' => 'Healthcare and consumer electronics',
                'website' => 'https://philips.com',
                'order' => 10,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
