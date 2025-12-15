<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterColumn;
use App\Models\FooterLink;
use App\Models\FooterSetting;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        // Create footer settings
        FooterSetting::create([
            'brand_name' => 'TYCOON',
            'brand_description' => 'Your premier destination for cutting-edge technology and electronics. We bring you the latest innovations with exceptional quality and service.',
            'product_image' => 'images/cat/pressure-cooker.png',
            'product_link' => '/products/featured',
            'payment_methods' => [
                'https://cdn-icons-png.flaticon.com/512/196/196578.png',
                'https://cdn-icons-png.flaticon.com/512/196/196561.png',
                'https://cdn-icons-png.flaticon.com/512/196/196539.png',
                'https://cdn-icons-png.flaticon.com/512/888/888871.png',
                'https://cdn-icons-png.flaticon.com/512/888/888879.png',
                'https://cdn-icons-png.flaticon.com/512/888/888870.png',
            ],
            'social_links' => [
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#'
            ]
        ]);

        // Create columns and links
        $columns = [
            [
                'title' => 'About Tycoon',
                'links' => [
                    ['title' => 'About Us', 'url' => '/about-us'],
                    ['title' => 'Technology & Innovation', 'url' => '/technology-and-innovation'],
                    ['title' => 'Quality & Certifications', 'url' => '/certifications'],
                    ['title' => 'Brand Partners', 'url' => '/partners'],
                    ['title' => 'Sustainability', 'url' => '/sustainability'],
                ]
            ],
            [
                'title' => 'Support & Service',
                'links' => [
                    ['title' => 'Contact Support', 'url' => '/support'],
                    ['title' => 'Warranty Policy', 'url' => '/warranty'],
                    ['title' => 'Service Centers', 'url' => '/service-centers'],
                    ['title' => 'Product Manuals', 'url' => '/manuals'],
                    ['title' => 'Spare Parts', 'url' => '/spare-parts'],
                ]
            ],
            [
                'title' => 'Customer Help',
                'links' => [
                    ['title' => 'How to Order', 'url' => '/how-to-order'],
                    ['title' => 'Delivery Information', 'url' => '/shipping'],
                    ['title' => 'Return & Replacement', 'url' => '/returns'],
                    ['title' => 'FAQ', 'url' => '/faq'],
                ]
            ],
            [
                'title' => 'Products',
                'links' => [
                    ['title' => 'All Products', 'url' => '/products'],
                    ['title' => 'All Categories', 'url' => '/categories'],
                    ['title' => 'New Arrivals', 'url' => '/new-arrivals'],
                    ['title' => 'Best Sellers', 'url' => '/best-sellers'],
                    ['title' => 'Special Offers', 'url' => '/offers'],
                ]
            ],
            [
                'title' => 'Legal & Policies',
                'links' => [
                    ['title' => 'Privacy Policy', 'url' => '/privacy'],
                    ['title' => 'Terms & Conditions', 'url' => '/terms'],
                ]
            ],
        ];



        foreach ($columns as $index => $columnData) {
            $column = FooterColumn::create([
                'title' => $columnData['title'],
                'sort_order' => $index + 1,
                'is_active' => true
            ]);

            foreach ($columnData['links'] as $linkIndex => $linkData) {
                FooterLink::create([
                    'footer_column_id' => $column->id,
                    'title' => $linkData['title'],
                    'url' => $linkData['url'],
                    'sort_order' => $linkIndex + 1,
                    'is_active' => true
                ]);
            }
        }
    }
}
