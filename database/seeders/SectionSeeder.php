<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\AdBanner;

class SectionSeeder extends Seeder
{
    public function run()
    {
        // 1. Create/Update Banners
        $promoBanner = AdBanner::updateOrCreate(
            ['title' => 'Main Promo Banner'],
            [
                'images' => ['ads-banner/banner1.jpg'],
                'link' => '/offers',
                'is_active' => true
            ]
        );

        $saleBanner = AdBanner::updateOrCreate(
            ['title' => 'Secondary Summer Sale'],
            [
                'images' => ['ads-banner/banner2.jpg', 'ads-banner/banner3.jpg'],
                'link' => '/summer-sale',
                'is_active' => true
            ]
        );


        // 2. Create the 3 Product Slider Sections
        $productTypes = [
            [
                'name' => 'Homepage New Arrivals',
                'title' => 'New Arrivals',
                'type' => 'new_arrivals',
                'order' => 1
            ],
            [
                'name' => 'Homepage Best Sells',
                'title' => 'Best Selling Products',
                'type' => 'best_sells',
                'order' => 2
            ],
            [
                'name' => 'Homepage Recommended',
                'title' => 'Recommended For You',
                'type' => 'recommended',
                'order' => 3
            ],
        ];

        foreach ($productTypes as $item) {
            $section = Section::create([
                'name'     => $item['name'],
                'title'    => $item['title'],
                'type'     => 'product_slider',
                'order'    => $item['order'],
                'settings' => [
                    'product_type'   => $item['type'],
                    'slidesPerView'  => 5,
                    'autoPlay'       => false,
                    'showNavigation' => true,
                ],
            ]);

            // Optional: Attach a banner to the 'New Arrivals' slider specifically
            if ($item['type'] === 'new_arrivals') {
                $section->banners()->attach($promoBanner->id, [
                    'order'    => 0,
                    'position' => 2, // appears after 2nd product
                ]);
            } else if ($item['type'] === 'best_sells') {
                $section->banners()->attach($saleBanner->id, [
                    'order'    => 0,
                    'position' => 3, // appears after 3rd product
                ]);
            } else if ($item['type'] === 'recommended') {
                $section->banners()->attach($saleBanner->id, [
                    'order'    => 0,
                    'position' => 1, // appears after 1st product
                ]);
            }
        }

        // 3. Create a Pure Banner Section (Standalone)
        $midBannerSection = Section::create([
            'name'  => 'Homepage Mid Banner',
            'type'  => 'banner',
            'order' => 4,
        ]);

        // Attach both banners to this section
        $midBannerSection->banners()->attach([
            $promoBanner->id => ['order' => 1],
            $saleBanner->id  => ['order' => 2],
        ]);
    }
}
