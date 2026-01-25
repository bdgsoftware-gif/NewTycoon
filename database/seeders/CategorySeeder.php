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
        'washing-machine' => 'washing-machine',
        'microwave-oven' => 'microwave',
        'water-purifier' => 'water-purifier',
        'iron' => 'iron',
        'vacuum-cleaner' => 'vacuum',
        'water-heater' => 'heater',
    ];

    public function run(): void
    {
        // Define the category structure with 12+ categories for featured and 4-5 for nav
        $categories = [
            // NAV CATEGORY 1 + FEATURED
            'Air Conditioner' => [
                'bn_name' => 'এয়ার কন্ডিশনার',
                'show_in_nav' => true,
                'is_featured' => true,
                'children' => [
                    'Split AC' => [
                        'bn_name' => 'স্প্লিট এয়ার কন্ডিশনার',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '1 Ton Split AC', 'bn_name' => '১ টন স্প্লিট এসি'],
                            ['name' => '1.5 Ton Split AC', 'bn_name' => '১.৫ টন স্প্লিট এসি'],
                            ['name' => '2 Ton Split AC', 'bn_name' => '২ টন স্প্লিট এসি'],
                            ['name' => 'Inverter Split AC', 'bn_name' => 'ইনভার্টার স্প্লিট এসি'],
                        ]
                    ],
                    'Window AC' => [
                        'bn_name' => 'উইন্ডো এসি',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '1 Ton Window AC', 'bn_name' => '১ টন উইন্ডো এসি'],
                            ['name' => '1.5 Ton Window AC', 'bn_name' => '১.৫ টন উইন্ডো এসি'],
                            ['name' => '2 Ton Window AC', 'bn_name' => '২ টন উইন্ডো এসি'],
                        ]
                    ],
                ]
            ],

            // NAV CATEGORY 2 + FEATURED
            'Refrigerator' => [
                'bn_name' => 'রেফ্রিজারেটর',
                'show_in_nav' => true,
                'is_featured' => true,
                'children' => [
                    'Single Door Fridges' => [
                        'bn_name' => 'সিঙ্গেল ডোর ফ্রিজ',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '165 Liter Refrigerator', 'bn_name' => '১৬৫ লিটার রেফ্রিজারেটর'],
                            ['name' => '190 Liter Refrigerator', 'bn_name' => '১৯০ লিটার রেফ্রিজারেটর'],
                            ['name' => '230 Liter Refrigerator', 'bn_name' => '২৩০ লিটার রেফ্রিজারেটর'],
                        ]
                    ],
                    'Double Door Fridges' => [
                        'bn_name' => 'ডাবল ডোর ফ্রিজ',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '250 Liter Refrigerator', 'bn_name' => '২৫০ লিটার রেফ্রিজারেটর'],
                            ['name' => '300 Liter Refrigerator', 'bn_name' => '৩০০ লিটার রেফ্রিজারেটর'],
                            ['name' => '350 Liter Refrigerator', 'bn_name' => '৩৫০ লিটার রেফ্রিজারেটর'],
                        ]
                    ],
                ]
            ],

            // NAV CATEGORY 3 + FEATURED
            'LED TV' => [
                'bn_name' => 'এলইডি টিভি',
                'show_in_nav' => true,
                'is_featured' => true,
                'children' => [
                    'Smart TVs' => [
                        'bn_name' => 'স্মার্ট টিভি',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '32 inch Smart TV', 'bn_name' => '৩২ ইঞ্চি স্মার্ট টিভি'],
                            ['name' => '43 inch Smart TV', 'bn_name' => '৪৩ ইঞ্চি স্মার্ট টিভি'],
                            ['name' => '55 inch Smart TV', 'bn_name' => '৫৫ ইঞ্চি স্মার্ট টিভি'],
                        ]
                    ],
                    'Android TVs' => [
                        'bn_name' => 'অ্যান্ড্রয়েড টিভি',
                        'is_featured' => true,
                        'children' => [
                            ['name' => 'Android 11 TV', 'bn_name' => 'অ্যান্ড্রয়েড ১১ টিভি'],
                            ['name' => 'Google TV', 'bn_name' => 'গুগল টিভি'],
                            ['name' => 'Built-in Netflix TV', 'bn_name' => 'নেটফ্লিক্স সহ টিভি'],
                        ]
                    ],
                ]
            ],

            // NAV CATEGORY 4 + FEATURED
            'Washing Machine' => [
                'bn_name' => 'ওয়াশিং মেশিন',
                'show_in_nav' => true,
                'is_featured' => true,
                'children' => [
                    'Front Load Washing Machine' => [
                        'bn_name' => 'ফ্রন্ট লোড ওয়াশিং মেশিন',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '6 KG Front Load', 'bn_name' => '৬ কেজি ফ্রন্ট লোড'],
                            ['name' => '7 KG Front Load', 'bn_name' => '৭ কেজি ফ্রন্ট লোড'],
                            ['name' => '8 KG Front Load', 'bn_name' => '৮ কেজি ফ্রন্ট লোড'],
                        ]
                    ],
                    'Top Load Washing Machine' => [
                        'bn_name' => 'টপ লোড ওয়াশিং মেশিন',
                        'is_featured' => true,
                        'children' => [
                            ['name' => '6.5 KG Top Load', 'bn_name' => '৬.৫ কেজি টপ লোড'],
                            ['name' => '7.5 KG Top Load', 'bn_name' => '৭.৫ কেজি টপ লোড'],
                            ['name' => 'Semi-Automatic Washer', 'bn_name' => 'সেমি-অটোমেটিক ওয়াশার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY (not in nav)
            'Microwave Oven' => [
                'bn_name' => 'মাইক্রোওয়েভ ওভেন',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Solo Microwave' => [
                        'bn_name' => 'সোলো মাইক্রোওয়েভ',
                        'children' => [
                            ['name' => '20 Liter Solo', 'bn_name' => '২০ লিটার সোলো'],
                            ['name' => '25 Liter Solo', 'bn_name' => '২৫ লিটার সোলো'],
                            ['name' => '30 Liter Solo', 'bn_name' => '৩০ লিটার সোলো'],
                        ]
                    ],
                    'Convection Microwave' => [
                        'bn_name' => 'কনভেকশন মাইক্রোওয়েভ',
                        'children' => [
                            ['name' => '25 Liter Convection', 'bn_name' => '২৫ লিটার কনভেকশন'],
                            ['name' => '30 Liter Convection', 'bn_name' => '৩০ লিটার কনভেকশন'],
                            ['name' => '32 Liter Convection', 'bn_name' => '৩২ লিটার কনভেকশন'],
                        ]
                    ],
                ]
            ],

            // NAV CATEGORY 5 + FEATURED
            'Fan' => [
                'bn_name' => 'পাখা',
                'show_in_nav' => true,
                'is_featured' => true,
                'children' => [
                    'Ceiling Fan' => [
                        'bn_name' => 'সিলিং ফ্যান',
                        'children' => [
                            ['name' => 'Premium Ceiling Fans', 'bn_name' => 'প্রিমিয়াম সিলিং ফ্যান'],
                            ['name' => 'Energy Saving Fans', 'bn_name' => 'এনার্জি সেভিং ফ্যান'],
                            ['name' => 'Remote Control Fans', 'bn_name' => 'রিমোট কন্ট্রোল ফ্যান'],
                        ]
                    ],
                    'Table Fan' => [
                        'bn_name' => 'টেবিল ফ্যান',
                        'children' => [
                            ['name' => 'USB Table Fans', 'bn_name' => 'ইউএসবি টেবিল ফ্যান'],
                            ['name' => 'Rechargeable Fans', 'bn_name' => 'রিচার্জেবল ফ্যান'],
                            ['name' => 'High Speed Fans', 'bn_name' => 'হাই স্পিড ফ্যান'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Water Purifier' => [
                'bn_name' => 'ওয়াটার পিউরিফায়ার',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'RO Water Purifier' => [
                        'bn_name' => 'আরও ওয়াটার পিউরিফায়ার',
                        'children' => [
                            ['name' => 'Wall Mount RO', 'bn_name' => 'ওয়াল মাউন্ট আরও'],
                            ['name' => 'Under Sink RO', 'bn_name' => 'আন্ডার সিঙ্ক আরও'],
                            ['name' => 'Counter Top RO', 'bn_name' => 'কাউন্টার টপ আরও'],
                        ]
                    ],
                    'UV Water Purifier' => [
                        'bn_name' => 'ইউভি ওয়াটার পিউরিফায়ার',
                        'children' => [
                            ['name' => 'UV + UF Purifier', 'bn_name' => 'ইউভি + ইউএফ পিউরিফায়ার'],
                            ['name' => 'Gravity Purifier', 'bn_name' => 'গ্র্যাভিটি পিউরিফায়ার'],
                            ['name' => 'Electric UV Purifier', 'bn_name' => 'ইলেকট্রিক ইউভি পিউরিফায়ার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Mixer Grinder' => [
                'bn_name' => 'মিক্সার গ্রাইন্ডার',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Heavy Duty Mixers' => [
                        'bn_name' => 'হেভি ডিউটি মিক্সার',
                        'children' => [
                            ['name' => '1000W Mixer Grinder', 'bn_name' => '১০০০ ওয়াট মিক্সার গ্রাইন্ডার'],
                            ['name' => '750W Mixer Grinder', 'bn_name' => '৭৫০ ওয়াট মিক্সার গ্রাইন্ডার'],
                            ['name' => 'Commercial Mixers', 'bn_name' => 'কমার্শিয়াল মিক্সার'],
                        ]
                    ],
                    'Compact Mixers' => [
                        'bn_name' => 'কমপ্যাক্ট মিক্সার',
                        'children' => [
                            ['name' => '3 Jar Mixer', 'bn_name' => '৩ জার মিক্সার'],
                            ['name' => '500W Mixer Grinder', 'bn_name' => '৫০০ ওয়াট মিক্সার গ্রাইন্ডার'],
                            ['name' => 'Mini Mixer Grinder', 'bn_name' => 'মিনি মিক্সার গ্রাইন্ডার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Water Heater' => [
                'bn_name' => 'ওয়াটার হিটার',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Instant Water Heater' => [
                        'bn_name' => 'ইনস্ট্যান্ট ওয়াটার হিটার',
                        'children' => [
                            ['name' => '3 Liter Instant Geyser', 'bn_name' => '৩ লিটার ইনস্ট্যান্ট গিজার'],
                            ['name' => '6 Liter Instant Geyser', 'bn_name' => '৬ লিটার ইনস্ট্যান্ট গিজার'],
                            ['name' => 'Electric Instant Heater', 'bn_name' => 'ইলেকট্রিক ইনস্ট্যান্ট হিটার'],
                        ]
                    ],
                    'Storage Water Heater' => [
                        'bn_name' => 'স্টোরেজ ওয়াটার হিটার',
                        'children' => [
                            ['name' => '10 Liter Storage Geyser', 'bn_name' => '১০ লিটার স্টোরেজ গিজার'],
                            ['name' => '15 Liter Storage Geyser', 'bn_name' => '১৫ লিটার স্টোরেজ গিজার'],
                            ['name' => '25 Liter Storage Geyser', 'bn_name' => '২৫ লিটার স্টোরেজ গিজার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Iron' => [
                'bn_name' => 'ইস্ত্রি',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Steam Iron' => [
                        'bn_name' => 'স্টিম আয়রন',
                        'children' => [
                            ['name' => 'Dry Iron', 'bn_name' => 'ড্রাই আয়রন'],
                            ['name' => 'Steam Press Iron', 'bn_name' => 'স্টিম প্রেস আয়রন'],
                            ['name' => 'Cordless Iron', 'bn_name' => 'কর্ডলেস আয়রন'],
                        ]
                    ],
                    'Garment Steamer' => [
                        'bn_name' => 'গার্মেন্ট স্টিমার',
                        'children' => [
                            ['name' => 'Handheld Steamer', 'bn_name' => 'হ্যান্ডহেল্ড স্টিমার'],
                            ['name' => 'Standing Steamer', 'bn_name' => 'স্ট্যান্ডিং স্টিমার'],
                            ['name' => 'Travel Steamer', 'bn_name' => 'ট্রাভেল স্টিমার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Vacuum Cleaner' => [
                'bn_name' => 'ভ্যাকুয়াম ক্লিনার',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Handheld Vacuum' => [
                        'bn_name' => 'হ্যান্ডহেল্ড ভ্যাকুয়াম',
                        'children' => [
                            ['name' => 'Cordless Handheld', 'bn_name' => 'কর্ডলেস হ্যান্ডহেল্ড'],
                            ['name' => 'Car Vacuum Cleaner', 'bn_name' => 'কার ভ্যাকুয়াম ক্লিনার'],
                            ['name' => 'Wet & Dry Vacuum', 'bn_name' => 'ওয়েট এন্ড ড্রাই ভ্যাকুয়াম'],
                        ]
                    ],
                    'Robot Vacuum' => [
                        'bn_name' => 'রোবট ভ্যাকুয়াম',
                        'children' => [
                            ['name' => 'Smart Robot Vacuum', 'bn_name' => 'স্মার্ট রোবট ভ্যাকুয়াম'],
                            ['name' => 'Auto Charging Vacuum', 'bn_name' => 'অটো চার্জিং ভ্যাকুয়াম'],
                            ['name' => 'Mop & Vacuum Robot', 'bn_name' => 'মপ এন্ড ভ্যাকুয়াম রোবট'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Rice Cooker' => [
                'bn_name' => 'রাইস কুকার',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Electric Rice Cooker' => [
                        'bn_name' => 'ইলেকট্রিক রাইস কুকার',
                        'children' => [
                            ['name' => '1.8 Liter Rice Cooker', 'bn_name' => '১.৮ লিটার রাইস কুকার'],
                            ['name' => '2.2 Liter Rice Cooker', 'bn_name' => '২.২ লিটার রাইস কুকার'],
                            ['name' => '2.8 Liter Rice Cooker', 'bn_name' => '২.৮ লিটার রাইস কুকার'],
                        ]
                    ],
                    'Multi Cooker' => [
                        'bn_name' => 'মাল্টি কুকার',
                        'children' => [
                            ['name' => 'Pressure Multi Cooker', 'bn_name' => 'প্রেসার মাল্টি কুকার'],
                            ['name' => 'Slow Multi Cooker', 'bn_name' => 'স্লো মাল্টি কুকার'],
                            ['name' => '10-in-1 Multi Cooker', 'bn_name' => '১০-ইন-১ মাল্টি কুকার'],
                        ]
                    ],
                ]
            ],

            // FEATURED CATEGORY
            'Electric Kettle' => [
                'bn_name' => 'ইলেকট্রিক কেটলি',
                'show_in_nav' => false,
                'is_featured' => true,
                'children' => [
                    'Stainless Steel Kettle' => [
                        'bn_name' => 'স্টেইনলেস স্টিল কেটলি',
                        'children' => [
                            ['name' => '1.5 Liter Kettle', 'bn_name' => '১.৫ লিটার কেটলি'],
                            ['name' => '1.8 Liter Kettle', 'bn_name' => '১.৮ লিটার কেটলি'],
                            ['name' => '2 Liter Kettle', 'bn_name' => '২ লিটার কেটলি'],
                        ]
                    ],
                    'Glass Kettle' => [
                        'bn_name' => 'গ্লাস কেটলি',
                        'children' => [
                            ['name' => 'LED Glass Kettle', 'bn_name' => 'এলইডি গ্লাস কেটলি'],
                            ['name' => 'Borosilicate Kettle', 'bn_name' => 'বোরোসিলিকেট কেটলি'],
                            ['name' => 'Temperature Control Kettle', 'bn_name' => 'টেম্পারেচার কন্ট্রোল কেটলি'],
                        ]
                    ],
                ]
            ],
        ];

        $order = 1;

        foreach ($categories as $name => $data) {
            $slug = Str::slug($name);
            $bnName = $data['bn_name'] ?? '';
            $showInNav = $data['show_in_nav'] ?? false;
            $isFeatured = $data['is_featured'] ?? false;

            // Create main category (Level 1)
            $mainCategory = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name_en' => $name,
                    'name_bn' => $bnName,
                    'description_en' => $this->getDescription($name),
                    'description_bn' => $this->getBanglaDescription($name),
                    'image' => $this->getCategoryImage($slug),
                    'parent_id' => null,
                    'depth' => 1,
                    'order' => $order++,
                    'nav_order' => $showInNav ? $order : 999,
                    'show_in_nav' => $showInNav,
                    'is_featured' => $isFeatured,
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
                    $childBnName = $childData['bn_name'] ?? '';
                    $childFeatured = $childData['is_featured'] ?? false;

                    $childCategory = Category::updateOrCreate(
                        [
                            'slug' => $childSlug,
                            'parent_id' => $mainCategory->id
                        ],
                        [
                            'name_en' => $childName,
                            'name_bn' => $childBnName,
                            'description_en' => $this->getDescription($childName),
                            'description_bn' => $this->getBanglaDescription($childName),
                            'image' => $this->getCategoryImage($childSlug),
                            'depth' => 2,
                            'order' => $childOrder++,
                            'show_in_nav' => false,
                            'is_featured' => $childFeatured,
                            'is_active' => true,
                            'meta_title' => $childName . ' - ' . $name,
                            'meta_description' => 'Best ' . strtolower($childName) . ' under ' . $name . ' category.',
                        ]
                    );

                    // Create Level 3 categories (grandchildren)
                    if (isset($childData['children']) && is_array($childData['children'])) {
                        $grandChildOrder = 1;
                        foreach ($childData['children'] as $grandChild) {
                            $grandChildName = $grandChild['name'];
                            $grandChildBnName = $grandChild['bn_name'] ?? '';
                            $grandChildSlug = Str::slug($grandChildName);

                            Category::updateOrCreate(
                                [
                                    'slug' => $grandChildSlug,
                                    'parent_id' => $childCategory->id
                                ],
                                [
                                    'name_en' => $grandChildName,
                                    'name_bn' => $grandChildBnName,
                                    'description_en' => $this->getDescription($grandChildName),
                                    'description_bn' => $this->getBanglaDescription($grandChildName),
                                    'image' => $this->getCategoryImage($grandChildSlug, $childSlug),
                                    'depth' => 3,
                                    'order' => $grandChildOrder++,
                                    'show_in_nav' => false,
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

        $this->command->info('Categories seeded successfully!');
        $this->command->info('📁 Total categories created: ' . Category::count());
        $this->command->info('📁 Level 1 (Parent) categories: ' . Category::whereNull('parent_id')->count());
        $this->command->info('📁 Level 2 (Child) categories: ' . Category::where('depth', 2)->count());
        $this->command->info('📁 Level 3 (Grandchild/Leaf) categories: ' . Category::where('depth', 3)->count());
        $this->command->info('⭐ Featured categories: ' . Category::where('is_featured', true)->count());
        $this->command->info('🧭 Navigation categories: ' . Category::where('show_in_nav', true)->count());
        $this->command->info('🍃 Leaf categories (can have products): ' . Category::leaf()->count());
    }

    /**
     * Get image for category based on slug
     */
    private function getCategoryImage(string $slug, ?string $parentSlug = null): ?string
    {
        // Check if we have a direct mapping
        if (isset($this->imageMapping[$slug])) {
            return 'categories/' . $this->imageMapping[$slug] . '.png';
        }

        // Try parent image with suffix if available
        if ($parentSlug && isset($this->imageMapping[$parentSlug])) {
            $parentImage = $this->imageMapping[$parentSlug];
            return 'categories/' . $parentImage . '-item.png';
        }

        // Fallback to generic image
        return 'categories/electronics.png';
    }

    /**
     * Get English description for category
     */
    private function getDescription(string $categoryName): string
    {
        $descriptions = [
            // Main categories
            'Air Conditioner' => 'Cooling solutions including split AC, window AC, and portable AC with energy-saving technology.',
            'Fan' => 'Wide range of fans including ceiling fans, tower fans, and table fans for all cooling needs.',
            'Refrigerator' => 'Refrigerators including single door, double door, and side-by-side models with advanced cooling technology.',
            'LED TV' => 'LED TVs including Smart TVs, Android TVs, OLED, and 4K Ultra HD models with latest display technology.',
            'Washing Machine' => 'Washing machines including front load, top load, and semi-automatic with advanced washing technology.',
            'Microwave Oven' => 'Microwave ovens including solo, grill, and convection models for all cooking needs.',
            'Water Purifier' => 'Water purifiers with RO, UV, and UF technology for clean and safe drinking water.',
            'Mixer Grinder' => 'Mixer grinders, blenders, and food processors for all kitchen needs with powerful motors.',
            'Water Heater' => 'Water heaters including instant and storage geysers for hot water supply.',
            'Iron' => 'Irons and steamers including dry iron, steam iron, and garment steamers.',
            'Vacuum Cleaner' => 'Vacuum cleaners including handheld, robot, and wet & dry models for efficient cleaning.',
            'Rice Cooker' => 'Rice cookers and multi cookers with advanced cooking technology.',
            'Electric Kettle' => 'Electric kettles in stainless steel and glass with fast heating technology.',

            // Sub-categories
            'Split AC' => 'Energy efficient split air conditioners for home and office cooling.',
            'Window AC' => 'Compact window air conditioners for easy installation and space saving.',
            'Ceiling Fan' => 'Ceiling fans with various designs and energy saving features.',
            'Table Fan' => 'Portable table fans for personal cooling needs.',
            'Single Door Fridges' => 'Single door refrigerators perfect for small families and apartments.',
            'Double Door Fridges' => 'Double door refrigerators with separate freezer compartments.',
            'Smart TVs' => 'Smart televisions with built-in streaming apps and internet connectivity.',
            'Android TVs' => 'Android based smart TVs with access to Google Play Store.',
            'Front Load Washing Machine' => 'Front loading washing machines with advanced wash programs.',
            'Top Load Washing Machine' => 'Top loading washing machines for easy loading and unloading.',
            'Solo Microwave' => 'Solo microwave ovens for basic heating and cooking.',
            'Convection Microwave' => 'Convection microwave ovens for baking and grilling.',
            'RO Water Purifier' => 'RO water purifiers for removing dissolved impurities.',
            'UV Water Purifier' => 'UV water purifiers for killing bacteria and viruses.',
            'Heavy Duty Mixers' => 'Powerful mixer grinders for heavy kitchen use.',
            'Compact Mixers' => 'Compact mixer grinders for small families and occasional use.',
            'Instant Water Heater' => 'Instant water heaters for immediate hot water supply.',
            'Storage Water Heater' => 'Storage water heaters with insulated tanks.',
            'Steam Iron' => 'Steam irons for wrinkle-free clothes.',
            'Garment Steamer' => 'Garment steamers for delicate fabrics.',
            'Handheld Vacuum' => 'Handheld vacuum cleaners for quick cleaning.',
            'Robot Vacuum' => 'Robot vacuum cleaners with automatic cleaning.',
            'Electric Rice Cooker' => 'Electric rice cookers for perfectly cooked rice.',
            'Multi Cooker' => 'Multi cookers for various cooking methods.',
            'Stainless Steel Kettle' => 'Stainless steel electric kettles for durability.',
            'Glass Kettle' => 'Glass electric kettles with aesthetic design.',
        ];

        // Try exact match first
        if (isset($descriptions[$categoryName])) {
            return $descriptions[$categoryName];
        }

        // Generic description
        return $categoryName . ' products with best quality and competitive prices.';
    }

    /**
     * Get Bangla description for category
     */
    private function getBanglaDescription(string $categoryName): string
    {
        $descriptions = [
            // Main categories
            'Air Conditioner' => 'এনার্জি সেভিং টেকনোলজি সহ স্প্লিট এসি, উইন্ডো এসি এবং পোর্টেবল এসি সহ কুলিং সমাধান।',
            'Fan' => 'সব কুলিং চাহিদার জন্য সিলিং ফ্যান, টাওয়ার ফ্যান এবং টেবিল ফ্যান সহ ফ্যানের বিস্তৃত পরিসর।',
            'Refrigerator' => 'উন্নত কুলিং প্রযুক্তি সহ সিঙ্গেল ডোর, ডাবল ডোর এবং সাইড বাই সাইড মডেল সহ রেফ্রিজারেটর।',
            'LED TV' => 'স্মার্ট টিভি, অ্যান্ড্রয়েড টিভি, ওএলইডি এবং ৪কে আলট্রা এইচডি মডেল সহ এলইডি টিভি।',
            'Washing Machine' => 'উন্নত ওয়াশিং প্রযুক্তি সহ ফ্রন্ট লোড, টপ লোড এবং সেমি-অটোমেটিক ওয়াশিং মেশিন।',
            'Microwave Oven' => 'সমস্ত রান্নার প্রয়োজনের জন্য সোলো, গ্রিল এবং কনভেকশন মডেল সহ মাইক্রোওয়েভ ওভেন।',
            'Water Purifier' => 'পরিষ্কার এবং নিরাপদ পানীয় জলের জন্য আরও, ইউভি এবং ইউএফ প্রযুক্তি সহ ওয়াটার পিউরিফায়ার।',
            'Mixer Grinder' => 'শক্তিশালী মোটর সহ সমস্ত রান্নাঘরের প্রয়োজনের জন্য মিক্সার গ্রাইন্ডার, ব্লেন্ডার এবং ফুড প্রসেসর।',
            'Water Heater' => 'গরম জল সরবরাহের জন্য ইনস্ট্যান্ট এবং স্টোরেজ গিজার সহ ওয়াটার হিটার।',
            'Iron' => 'ড্রাই আয়রন, স্টিম আয়রন এবং গার্মেন্ট স্টিমার সহ আয়রন এবং স্টিমার।',
            'Vacuum Cleaner' => 'দক্ষ পরিষ্কারের জন্য হ্যান্ডহেল্ড, রোবট এবং ওয়েট এন্ড ড্রাই মডেল সহ ভ্যাকুয়াম ক্লিনার।',
            'Rice Cooker' => 'উন্নত রান্নার প্রযুক্তি সহ রাইস কুকার এবং মাল্টি কুকার।',
            'Electric Kettle' => 'দ্রুত গরম করার প্রযুক্তি সহ স্টেইনলেস স্টিল এবং গ্লাসে ইলেকট্রিক কেটলি।',

            // Generic for others
        ];

        // Try exact match first
        if (isset($descriptions[$categoryName])) {
            return $descriptions[$categoryName];
        }

        // Generic Bangla description
        return 'সেরা গুণমান এবং প্রতিযোগিতামূলক মূল্যে ' . $categoryName . ' পণ্য।';
    }

    /**
     * Get SEO keywords for category
     */
    private function getKeywords(string $categoryName): string
    {
        $keywordsMap = [
            'Air Conditioner' => 'ac, air conditioning, cooling, split ac, window ac',
            'Fan' => 'ceiling fan, table fan, tower fan, wall fan, cooling fan',
            'Refrigerator' => 'fridge, refrigerator, cooling appliance, freezer',
            'LED TV' => 'television, smart tv, led television, android tv',
            'Washing Machine' => 'washer, laundry, washing machine, front load, top load',
            'Microwave Oven' => 'microwave, oven, cooking appliance, kitchen appliance',
            'Water Purifier' => 'water filter, ro, uv purifier, water treatment',
            'Mixer Grinder' => 'mixer, grinder, blender, food processor, kitchen appliance',
            'Water Heater' => 'geyser, water heater, hot water, bathroom appliance',
            'Iron' => 'iron, steam iron, garment steamer, pressing',
            'Vacuum Cleaner' => 'vacuum, cleaner, cleaning appliance, robot vacuum',
            'Rice Cooker' => 'rice cooker, multi cooker, cooking appliance',
            'Electric Kettle' => 'kettle, electric kettle, water boiler, tea maker',
        ];

        $baseKeywords = strtolower($categoryName);
        $additional = $keywordsMap[$categoryName] ?? 'home appliance, electronics, gadgets';

        return $baseKeywords . ', ' . $additional;
    }
}
