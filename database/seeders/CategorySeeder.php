<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Define the three-level structure
        $categories = [
            // Level 1: Main Categories
            'TV' => [
                'id' => 10,
                'image' => 'images/cat/led-tv.png',
                'children' => [
                    // Level 2: Sub-categories
                    'OLED TVs' => [
                        'image' => 'images/cat/oled-tv.png',
                        'children' => [
                            // Level 3: Sub-sub-categories
                            '55 inch OLED',
                            '65 inch OLED',
                            '77 inch OLED',
                        ]
                    ],
                    'Soundbars' => [
                        'image' => 'images/cat/soundbar.png',
                        'children' => [
                            'Premium Soundbars',
                            'Budget Soundbars',
                            'Wireless Soundbars',
                        ]
                    ]
                ]
            ],

            'Monitors' => [
                'id' => 11,
                'image' => 'images/cat/monitor.png',
                'children' => [
                    'Gaming Monitors' => [
                        'image' => 'images/cat/gaming-monitor.png',
                        'children' => [
                            '4K Gaming Monitors',
                            '240Hz Gaming Monitors',
                            'Curved Gaming Monitors',
                        ]
                    ],
                    'Smart Monitors' => [
                        'image' => 'images/cat/smart-monitor.png',
                        'children' => [
                            'Office Smart Monitors',
                            'Home Smart Monitors',
                            'Touch Screen Monitors',
                        ]
                    ]
                ]
            ],

            'Cameras' => [
                'image' => 'images/cat/camera.png',
                'children' => [
                    'Alpha Mirrorless' => [
                        'image' => 'images/cat/mirrorless.png',
                        'children' => [
                            'Full Frame Mirrorless',
                            'APS-C Mirrorless',
                            'Vlogging Cameras',
                        ]
                    ],
                    'Headphones & Audio' => [
                        'image' => 'images/cat/headphones.png',
                        'children' => [
                            'Wireless Headphones',
                            'Noise Cancelling',
                            'Studio Headphones',
                        ]
                    ]
                ]
            ],

            'Lighting' => [
                'image' => 'images/cat/lighting.png',
                'children' => [
                    'Smart Lighting' => [
                        'image' => 'images/cat/smart-lighting.png',
                        'children' => [
                            'Smart Bulbs',
                            'Light Strips',
                            'Smart Switches',
                        ]
                    ],
                    'Bulbs & Fixtures' => [
                        'image' => 'images/cat/bulbs.png',
                        'children' => [
                            'LED Bulbs',
                            'Ceiling Lights',
                            'Wall Lights',
                        ]
                    ]
                ]
            ],

            'Fans' => [
                'id' => 2,
                'image' => 'images/cat/fan.png',
                'children' => [
                    'Tower Fans' => [
                        'image' => 'images/cat/tower-fan.png',
                        'children' => [
                            'Remote Control Fans',
                            'Oscillating Tower Fans',
                            'Smart Tower Fans',
                        ]
                    ],
                    'Ceiling Fans' => [
                        'image' => 'images/cat/ceiling-fan.png',
                        'children' => [
                            'Premium Ceiling Fans',
                            'Smart Ceiling Fans',
                            'Outdoor Ceiling Fans',
                        ]
                    ]
                ]
            ],

            'Air Conditioner' => [
                'id' => 1,
                'image' => 'images/cat/ac.png',
                'children' => [
                    'Split AC' => [
                        'image' => 'images/cat/split-ac.png',
                        'children' => [
                            '1.5 Ton AC',
                            '2 Ton AC',
                            'Inverter AC',
                        ]
                    ],
                    'Window AC' => [
                        'image' => 'images/cat/window-ac.png',
                        'children' => [
                            '1 Ton Window AC',
                            '1.5 Ton Window AC',
                        ]
                    ]
                ]
            ],

            'Support' => [
                'image' => 'images/cat/support.png',
                'children' => []
            ]
        ];

        $order = 1;

        foreach ($categories as $name => $data) {
            // Create main category (Level 1)
            $mainCategory = Category::updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $name . ' products and accessories.',
                    'image' => $data['image'],
                    'parent_id' => null,
                    'order' => $order++,
                    'is_featured' => true,
                    'is_active' => true,
                    'meta_title' => $name,
                    'meta_description' => 'Shop for ' . strtolower($name) . ' at best prices.',
                    'meta_keywords' => strtolower(str_replace(' ', ', ', $name)),
                ]
            );

            // Create Level 2 categories (children)
            if (isset($data['children']) && is_array($data['children'])) {
                $childOrder = 1;
                foreach ($data['children'] as $childName => $childData) {
                    if (is_array($childData)) {
                        $childCategory = Category::updateOrCreate(
                            [
                                'name' => $childName,
                                'parent_id' => $mainCategory->id
                            ],
                            [
                                'slug' => Str::slug($childName),
                                'description' => $childName . ' products.',
                                'image' => $childData['image'] ?? null,
                                'order' => $childOrder++,
                                'is_featured' => false,
                                'is_active' => true,
                                'meta_title' => $childName,
                                'meta_description' => 'Shop for ' . strtolower($childName) . '.',
                            ]
                        );

                        // Create Level 3 categories (grandchildren)
                        if (isset($childData['children']) && is_array($childData['children'])) {
                            $grandChildOrder = 1;
                            foreach ($childData['children'] as $grandChildName) {
                                Category::updateOrCreate(
                                    [
                                        'name' => $grandChildName,
                                        'parent_id' => $childCategory->id
                                    ],
                                    [
                                        'slug' => Str::slug($grandChildName),
                                        'description' => $grandChildName . ' products.',
                                        'image' => null,
                                        'order' => $grandChildOrder++,
                                        'is_featured' => false,
                                        'is_active' => true,
                                        'meta_title' => $grandChildName,
                                        'meta_description' => 'Shop for ' . strtolower($grandChildName) . '.',
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        }
    }
}
