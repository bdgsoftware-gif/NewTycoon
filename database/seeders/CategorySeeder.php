<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Image mapping for categories
     */
    private $imageMapping = [
        // Parent categories (Level 1)
        'air-conditioner' => 'ac',
        'fan' => 'fan',
        'room-comforter' => 'comforter',
        'cookware' => 'cookware',
        'gas-burner' => 'gas-burner',
        'pressure-cooker' => 'pressure-cooker',
        'rice-cooker' => 'rice-cooker',
        'electric-kettle' => 'kettle',
        'mixer-grinder' => 'mixer',
        'led-tv' => 'led-tv',
        'monitor' => 'monitor',
        'refrigerator' => 'refrigerator',

        // Level 2 - Air Conditioner
        'split-ac' => 'split-ac',
        'window-ac' => 'window-ac',
        'portable-ac' => 'portable-ac',
        'inverter-ac' => 'inverter-ac',

        // Level 2 - Fan
        'ceiling-fan' => 'ceiling-fan',
        'tower-fan' => 'tower-fan',
        'table-fan' => 'table-fan',
        'wall-fan' => 'wall-fan',

        // Level 2 - Room Comforter
        'air-cooler' => 'air-cooler',
        'heater' => 'heater',
        'humidifier' => 'humidifier',
        'air-purifier' => 'air-purifier',

        // Level 2 - Cookware
        'cookware-sets' => 'cookware-set',
        'fry-pans' => 'fry-pan',
        'saucepans' => 'saucepan',
        'cooking-utensils' => 'utensils',

        // Level 2 - Gas Burner
        'gas-stoves' => 'gas-stove',
        'induction-cooktops' => 'induction',
        'table-top-burners' => 'table-burner',
        'outdoor-burners' => 'outdoor-burner',

        // Level 2 - Pressure Cooker
        'stainless-steel-cookers' => 'ss-cooker',
        'aluminum-cookers' => 'aluminum-cooker',
        'electric-cookers' => 'electric-cooker',
        'non-stick-cookers' => 'nonstick-cooker',

        // Level 2 - Rice Cooker
        'basic-rice-cookers' => 'basic-rice-cooker',
        'multi-cookers' => 'multi-cooker',
        'microwave-rice-cookers' => 'microwave-cooker',
        'smart-rice-cookers' => 'smart-cooker',

        // Level 2 - Electric Kettle
        'glass-kettles' => 'glass-kettle',
        'stainless-kettles' => 'stainless-kettle',
        'cordless-kettles' => 'cordless-kettle',
        'temperature-control-kettles' => 'temp-kettle',

        // Level 2 - Mixer Grinder
        'heavy-duty-mixers' => 'heavy-mixer',
        'compact-mixers' => 'compact-mixer',
        'blender-mixers' => 'blender',
        'food-processors' => 'food-processor',

        // Level 2 - LED TV
        'smart-tvs' => 'smart-tv',
        'android-tvs' => 'android-tv',
        'oled-tvs' => 'oled-tv',
        '4k-ultra-hd-tvs' => '4k-tv',

        // Level 2 - Monitor
        'gaming-monitors' => 'gaming-monitor',
        'office-monitors' => 'office-monitor',
        'curved-monitors' => 'curved-monitor',
        'touchscreen-monitors' => 'touch-monitor',

        // Level 2 - Refrigerator
        'single-door-fridges' => 'single-fridge',
        'double-door-fridges' => 'double-fridge',
        'side-by-side-fridges' => 'side-fridge',
        'mini-refrigerators' => 'mini-fridge',
    ];

    public function run(): void
    {
        // Define the category structure
        $categories = [
            'Air Conditioner' => [
                'children' => [
                    'Split AC' => [
                        'children' => [
                            '1 Ton Split AC',
                            '1.5 Ton Split AC',
                            '2 Ton Split AC',
                            'Inverter Split AC',
                        ]
                    ],
                    'Window AC' => [
                        'children' => [
                            '1 Ton Window AC',
                            '1.5 Ton Window AC',
                            '2 Ton Window AC',
                        ]
                    ],
                    'Portable AC' => [
                        'children' => [
                            '12000 BTU Portable AC',
                            '14000 BTU Portable AC',
                            'Portable AC with Heater',
                        ]
                    ],
                    'Inverter AC' => [
                        'children' => [
                            '5 Star Inverter AC',
                            '3 Star Inverter AC',
                            'Dual Inverter AC',
                        ]
                    ]
                ]
            ],

            'Fan' => [
                'children' => [
                    'Ceiling Fan' => [
                        'children' => [
                            'Premium Ceiling Fans',
                            'Energy Saving Fans',
                            'Remote Control Fans',
                            'Decorative Fans',
                        ]
                    ],
                    'Tower Fan' => [
                        'children' => [
                            'Oscillating Tower Fans',
                            'Bladeless Tower Fans',
                            'Smart Tower Fans',
                        ]
                    ],
                    'Table Fan' => [
                        'children' => [
                            'USB Table Fans',
                            'Rechargeable Fans',
                            'High Speed Fans',
                        ]
                    ],
                    'Wall Fan' => [
                        'children' => [
                            'Industrial Wall Fans',
                            'Exhaust Fans',
                            'Bracket Fans',
                        ]
                    ]
                ]
            ],

            'Room Comforter' => [
                'children' => [
                    'Air Cooler' => [
                        'children' => [
                            'Desert Air Coolers',
                            'Personal Air Coolers',
                            'Tower Air Coolers',
                        ]
                    ],
                    'Heater' => [
                        'children' => [
                            'Oil Filled Heaters',
                            'Fan Heaters',
                            'Ceramic Heaters',
                        ]
                    ],
                    'Humidifier' => [
                        'children' => [
                            'Ultrasonic Humidifiers',
                            'Warm Mist Humidifiers',
                            'Cool Mist Humidifiers',
                        ]
                    ],
                    'Air Purifier' => [
                        'children' => [
                            'HEPA Air Purifiers',
                            'Ionizer Purifiers',
                            'Smart Air Purifiers',
                        ]
                    ]
                ]
            ],

            'Cookware' => [
                'children' => [
                    'Cookware Sets' => [
                        'children' => [
                            'Stainless Steel Sets',
                            'Non-Stick Cookware Sets',
                            'Ceramic Cookware Sets',
                        ]
                    ],
                    'Fry Pans' => [
                        'children' => [
                            'Non-Stick Fry Pans',
                            'Cast Iron Pans',
                            'Ceramic Fry Pans',
                        ]
                    ],
                    'Saucepans' => [
                        'children' => [
                            'Stainless Saucepans',
                            'Copper Bottom Saucepans',
                            'Glass Saucepan',
                        ]
                    ],
                    'Cooking Utensils' => [
                        'children' => [
                            'Spatulas & Turners',
                            'Ladles & Spoons',
                            'Kitchen Tongs',
                        ]
                    ]
                ]
            ],

            'Gas Burner' => [
                'children' => [
                    'Gas Stoves' => [
                        'children' => [
                            '2 Burner Gas Stove',
                            '3 Burner Gas Stove',
                            '4 Burner Gas Stove',
                            'Auto Ignition Stoves',
                        ]
                    ],
                    'Induction Cooktops' => [
                        'children' => [
                            'Single Induction',
                            'Double Induction',
                            'Touch Control Induction',
                        ]
                    ],
                    'Table Top Burners' => [
                        'children' => [
                            'Single Burner',
                            'Double Burner',
                            'Portable Burners',
                        ]
                    ],
                    'Outdoor Burners' => [
                        'children' => [
                            'Camping Burners',
                            'BBQ Burners',
                            'High Pressure Burners',
                        ]
                    ]
                ]
            ],

            'Pressure Cooker' => [
                'children' => [
                    'Stainless Steel Cookers' => [
                        'children' => [
                            '3 Liter Pressure Cooker',
                            '5 Liter Pressure Cooker',
                            '7 Liter Pressure Cooker',
                        ]
                    ],
                    'Aluminum Cookers' => [
                        'children' => [
                            'Traditional Pressure Cooker',
                            'Hard Anodized Cooker',
                            'Lightweight Cooker',
                        ]
                    ],
                    'Electric Cookers' => [
                        'children' => [
                            'Digital Pressure Cooker',
                            'Multi-Cooker',
                            'Slow Cooker',
                        ]
                    ],
                    'Non-Stick Cookers' => [
                        'children' => [
                            'Granite Coated Cooker',
                            'Ceramic Coated Cooker',
                            'Marble Coated Cooker',
                        ]
                    ]
                ]
            ],

            'Rice Cooker' => [
                'children' => [
                    'Basic Rice Cookers' => [
                        'children' => [
                            '1 Liter Rice Cooker',
                            '1.8 Liter Rice Cooker',
                            '3 Liter Rice Cooker',
                        ]
                    ],
                    'Multi-Cookers' => [
                        'children' => [
                            'Rice & Steamer Cooker',
                            'Slow Cooker Combo',
                            'Pressure Rice Cooker',
                        ]
                    ],
                    'Microwave Rice Cookers' => [
                        'children' => [
                            'Microwave Safe Cookers',
                            'Steam Rice Cookers',
                            'Quick Rice Cookers',
                        ]
                    ],
                    'Smart Rice Cookers' => [
                        'children' => [
                            'Fuzzy Logic Cookers',
                            'WiFi Enabled Cookers',
                            'Programmable Cookers',
                        ]
                    ]
                ]
            ],

            'Electric Kettle' => [
                'children' => [
                    'Glass Kettles' => [
                        'children' => [
                            '1.5 Liter Glass Kettle',
                            '1.8 Liter Glass Kettle',
                            'LED Light Kettles',
                        ]
                    ],
                    'Stainless Kettles' => [
                        'children' => [
                            'Stainless Steel Kettle',
                            'Coated Stainless Kettle',
                            'Premium Kettles',
                        ]
                    ],
                    'Cordless Kettles' => [
                        'children' => [
                            '360° Cordless Kettle',
                            'Fast Boil Kettles',
                            'Safety Kettles',
                        ]
                    ],
                    'Temperature Control Kettles' => [
                        'children' => [
                            'Variable Temp Kettles',
                            'Keep Warm Kettles',
                            'Gooseneck Kettles',
                        ]
                    ]
                ]
            ],

            'Mixer Grinder' => [
                'children' => [
                    'Heavy Duty Mixers' => [
                        'children' => [
                            '1000W Mixer Grinder',
                            '750W Mixer Grinder',
                            'Commercial Mixers',
                        ]
                    ],
                    'Compact Mixers' => [
                        'children' => [
                            '3 Jar Mixer',
                            '500W Mixer Grinder',
                            'Mini Mixer Grinder',
                        ]
                    ],
                    'Blender Mixers' => [
                        'children' => [
                            'Juicer Mixer Grinder',
                            'Smoothie Blender',
                            'Immersion Blender',
                        ]
                    ],
                    'Food Processors' => [
                        'children' => [
                            'Chopper & Grinder',
                            'Dough Maker',
                            'Multi-function Processor',
                        ]
                    ]
                ]
            ],

            'LED TV' => [
                'children' => [
                    'Smart TVs' => [
                        'children' => [
                            '32 inch Smart TV',
                            '43 inch Smart TV',
                            '55 inch Smart TV',
                            '65 inch Smart TV',
                        ]
                    ],
                    'Android TVs' => [
                        'children' => [
                            'Android 11 TV',
                            'Google TV',
                            'Built-in Netflix TV',
                        ]
                    ],
                    'OLED TVs' => [
                        'children' => [
                            '55 inch OLED TV',
                            '65 inch OLED TV',
                            '77 inch OLED TV',
                        ]
                    ],
                    '4K Ultra HD TVs' => [
                        'children' => [
                            '4K HDR TV',
                            '4K QLED TV',
                            '8K Ultra HD TV',
                        ]
                    ]
                ]
            ],

            'Monitor' => [
                'children' => [
                    'Gaming Monitors' => [
                        'children' => [
                            '144Hz Gaming Monitor',
                            '240Hz Gaming Monitor',
                            'Curved Gaming Monitor',
                            '4K Gaming Monitor',
                        ]
                    ],
                    'Office Monitors' => [
                        'children' => [
                            'Full HD Monitor',
                            'Eye Care Monitor',
                            'UltraWide Monitor',
                        ]
                    ],
                    'Curved Monitors' => [
                        'children' => [
                            '1500R Curved Monitor',
                            '1800R Curved Monitor',
                            'Super UltraWide Curved',
                        ]
                    ],
                    'Touchscreen Monitors' => [
                        'children' => [
                            '10 Point Touch Monitor',
                            'Industrial Touch Monitor',
                            'All-in-One Touch Screen',
                        ]
                    ]
                ]
            ],

            'Refrigerator' => [
                'children' => [
                    'Single Door Fridges' => [
                        'children' => [
                            '165 Liter Refrigerator',
                            '190 Liter Refrigerator',
                            '230 Liter Refrigerator',
                        ]
                    ],
                    'Double Door Fridges' => [
                        'children' => [
                            '250 Liter Refrigerator',
                            '300 Liter Refrigerator',
                            '350 Liter Refrigerator',
                        ]
                    ],
                    'Side by Side Fridges' => [
                        'children' => [
                            'Side by Side 500L',
                            'French Door Refrigerator',
                            'Bottom Freezer Fridge',
                        ]
                    ],
                    'Mini Refrigerators' => [
                        'children' => [
                            'Mini Bar Fridge',
                            'Portable Refrigerator',
                            'Compact Fridge',
                        ]
                    ]
                ]
            ],
        ];

        $order = 1;

        foreach ($categories as $name => $data) {
            $slug = Str::slug($name);

            // Create main category (Level 1)
            $mainCategory = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'description' => $this->getDescription($name),
                    'image' => $this->getCategoryImage($slug),
                    'parent_id' => null,
                    'order' => $order++,
                    'is_featured' =>  (bool) rand(0, 1),
                    'is_active' => true,
                    'meta_title' => $name . ' - Best Products Online',
                    'meta_description' => 'Shop for ' . strtolower($name) . ' at best prices. Top brands available.',
                    'meta_keywords' => $this->getKeywords($name),
                ]
            );

            // Create Level 2 categories (children)
            if (isset($data['children']) && is_array($data['children'])) {
                $childOrder = 1;
                foreach ($data['children'] as $childName => $childData) {
                    $childSlug = Str::slug($childName);

                    $childCategory = Category::updateOrCreate(
                        [
                            'slug' => $childSlug,
                            'parent_id' => $mainCategory->id
                        ],
                        [
                            'name' => $childName,
                            'description' => $this->getDescription($childName),
                            'image' => $this->getCategoryImage($childSlug),
                            'order' => $childOrder++,
                            'is_featured' => true,
                            'is_active' => true,
                            'meta_title' => $childName . ' - ' . $name,
                            'meta_description' => 'Best ' . strtolower($childName) . ' under ' . $name . ' category.',
                        ]
                    );

                    // Create Level 3 categories (grandchildren)
                    if (isset($childData['children']) && is_array($childData['children'])) {
                        $grandChildOrder = 1;
                        foreach ($childData['children'] as $grandChildName) {
                            $grandChildSlug = Str::slug($grandChildName);

                            Category::updateOrCreate(
                                [
                                    'slug' => $grandChildSlug,
                                    'parent_id' => $childCategory->id
                                ],
                                [
                                    'name' => $grandChildName,
                                    'description' => $this->getDescription($grandChildName),
                                    'image' => $this->getCategoryImage($grandChildSlug, $childSlug),
                                    'order' => $grandChildOrder++,
                                    'is_featured' => false,
                                    'is_active' => true,
                                    'meta_title' => $grandChildName . ' - ' . $childName,
                                    'meta_description' => 'Find ' . strtolower($grandChildName) . ' in ' . $childName . ' section.',
                                ]
                            );
                        }
                    }
                }
            }
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📁 Total categories created: ' . Category::count());
        $this->command->info('📁 Level 1 (Parent) categories: ' . Category::whereNull('parent_id')->count());
        $this->command->info('📁 Level 2 (Child) categories: ' . Category::whereNotNull('parent_id')->whereDoesntHave('children')->count());
        $this->command->info('📁 Level 3 (Grandchild) categories: ' . Category::whereHas('parent', function ($q) {
            $q->whereNotNull('parent_id');
        })->count());
    }

    /**
     * Get image for category based on slug
     */
    private function getCategoryImage(string $slug, ?string $parentSlug = null): ?string
    {
        // Check if we have a direct mapping
        if (isset($this->imageMapping[$slug])) {
            return 'images/cat/' . $this->imageMapping[$slug] . '.png';
        }

        // Try to find size-based image (like 32-inch, 1-ton, etc.)
        if (preg_match('/(\d+(?:-?\d+)?)\s*(inch|ton|liter|btu|w|hz)/i', str_replace('-', ' ', $slug), $matches)) {
            $size = str_replace('.', '-', $matches[1]);
            $unit = strtolower($matches[2]);

            // Check for common parent patterns
            if ($parentSlug) {
                $parentImage = $this->imageMapping[$parentSlug] ?? null;
                if ($parentImage) {
                    return 'images/cat/' . $size . '-' . $unit . '-' . $parentImage . '.png';
                }
            }

            // Generic size image
            return 'images/cat/' . $size . '-' . $unit . '.png';
        }

        // Try parent image with suffix if available
        if ($parentSlug && isset($this->imageMapping[$parentSlug])) {
            $parentImage = $this->imageMapping[$parentSlug];

            // Check for special types
            if (str_contains($slug, 'premium-') || str_contains($slug, 'deluxe-')) {
                return 'images/cat/premium-' . $parentImage . '.png';
            }
            if (str_contains($slug, 'basic-') || str_contains($slug, 'standard-')) {
                return 'images/cat/basic-' . $parentImage . '.png';
            }
            if (str_contains($slug, 'smart-') || str_contains($slug, 'digital-')) {
                return 'images/cat/smart-' . $parentImage . '.png';
            }

            return 'images/cat/' . $parentImage . '-item.png';
        }

        // Fallback to generic image
        return 'images/cat/electronics.png';
    }

    /**
     * Get description for category
     */
    private function getDescription(string $categoryName): string
    {
        $descriptions = [
            // Level 1
            'Air Conditioner' => 'Cooling solutions including split AC, window AC, and portable AC with energy-saving technology.',
            'Fan' => 'Wide range of fans including ceiling fans, tower fans, and table fans for all cooling needs.',
            'Room Comforter' => 'Air coolers, heaters, humidifiers, and air purifiers for perfect room comfort.',
            'Cookware' => 'High-quality cookware sets, fry pans, and kitchen utensils for modern cooking.',
            'Gas Burner' => 'Gas stoves, induction cooktops, and burners for efficient cooking solutions.',
            'Pressure Cooker' => 'Pressure cookers in stainless steel, aluminum, and non-stick varieties.',
            'Rice Cooker' => 'Rice cookers from basic to smart models for perfect rice every time.',
            'Electric Kettle' => 'Electric kettles in glass, stainless steel, and cordless designs.',
            'Mixer Grinder' => 'Mixer grinders, blenders, and food processors for all kitchen needs.',
            'LED TV' => 'LED TVs including Smart TVs, Android TVs, OLED, and 4K Ultra HD models.',
            'Monitor' => 'Computer monitors for gaming, office work, and professional use.',
            'Refrigerator' => 'Refrigerators including single door, double door, and side-by-side models.',

            // Level 2 - Common patterns
            'Split AC' => 'Energy efficient split air conditioners for home and office.',
            'Window AC' => 'Compact window air conditioners for easy installation.',
            'Portable AC' => 'Mobile air conditioners that can be moved between rooms.',
            'Ceiling Fan' => 'Ceiling fans with various designs and energy saving features.',
            'Smart TV' => 'Smart televisions with built-in streaming apps and internet connectivity.',
            'Gaming Monitor' => 'High refresh rate monitors for gaming enthusiasts.',
            'Refrigerator' => 'Refrigerators with advanced cooling technology.',
        ];

        // Try exact match first
        if (isset($descriptions[$categoryName])) {
            return $descriptions[$categoryName];
        }

        // Generic description based on keywords
        $lowerName = strtolower($categoryName);

        if (str_contains($lowerName, 'tv') || str_contains($lowerName, 'television')) {
            return 'Televisions with latest display technology and smart features.';
        }

        if (str_contains($lowerName, 'monitor')) {
            return 'Computer monitors for various applications and user needs.';
        }

        if (str_contains($lowerName, 'fridge') || str_contains($lowerName, 'refrigerator')) {
            return 'Refrigeration appliances with energy efficient cooling.';
        }

        if (str_contains($lowerName, 'ac') || str_contains($lowerName, 'air conditioner')) {
            return 'Air conditioning units for cooling and climate control.';
        }

        if (str_contains($lowerName, 'fan')) {
            return 'Fans for air circulation and cooling purposes.';
        }

        if (str_contains($lowerName, 'cook') || str_contains($lowerName, 'kitchen')) {
            return 'Kitchen appliances and cookware for food preparation.';
        }

        if (str_contains($lowerName, 'mixer') || str_contains($lowerName, 'grinder')) {
            return 'Kitchen appliances for mixing, grinding, and food processing.';
        }

        if (str_contains($lowerName, 'kettle')) {
            return 'Electric kettles for boiling water quickly and safely.';
        }

        return $categoryName . ' products with best quality and competitive prices.';
    }

    /**
     * Get SEO keywords for category
     */
    private function getKeywords(string $categoryName): string
    {
        $keywordsMap = [
            'Air Conditioner' => 'ac, air conditioning, cooling, split ac, window ac',
            'Fan' => 'ceiling fan, table fan, tower fan, wall fan, cooling fan',
            'Room Comforter' => 'air cooler, heater, humidifier, air purifier, room comfort',
            'Cookware' => 'cooking utensils, fry pan, saucepan, kitchenware',
            'Gas Burner' => 'gas stove, induction cooktop, burner, cooking stove',
            'Pressure Cooker' => 'pressure cooking, cooker, kitchen appliance',
            'Rice Cooker' => 'rice maker, automatic rice cooker, electric rice cooker',
            'Electric Kettle' => 'electric kettle, water boiler, cordless kettle',
            'Mixer Grinder' => 'mixer, grinder, blender, food processor, kitchen appliance',
            'LED TV' => 'television, smart tv, led television, android tv',
            'Monitor' => 'computer monitor, display, screen, gaming monitor',
            'Refrigerator' => 'fridge, refrigerator, cooling appliance, freezer',
        ];

        $baseKeywords = strtolower($categoryName);
        $additional = $keywordsMap[$categoryName] ?? 'home appliance, electronics, gadgets';

        return $baseKeywords . ', ' . $additional;
    }
}
