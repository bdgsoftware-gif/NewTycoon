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
    ];

    public function run(): void
    {
        // Define the category structure
        $categories = [
            'Air Conditioner' => [
                'bn_name' => 'এয়ার কন্ডিশনার',
                'children' => [
                    'Split AC' => [
                        'bn_name' => 'স্প্লিট এয়ার কন্ডিশনার',
                        'children' => [
                            ['name' => '1 Ton Split AC', 'bn_name' => '১ টন স্প্লিট এসি'],
                            ['name' => '1.5 Ton Split AC', 'bn_name' => '১.৫ টন স্প্লিট এসি'],
                            ['name' => '2 Ton Split AC', 'bn_name' => '২ টন স্প্লিট এসি'],
                            ['name' => 'Inverter Split AC', 'bn_name' => 'ইনভার্টার স্প্লিট এসি'],
                        ]
                    ],
                    'Window AC' => [
                        'bn_name' => 'উইন্ডো এসি',
                        'children' => [
                            ['name' => '1 Ton Window AC', 'bn_name' => '১ টন উইন্ডো এসি'],
                            ['name' => '1.5 Ton Window AC', 'bn_name' => '১.৫ টন উইন্ডো এসি'],
                            ['name' => '2 Ton Window AC', 'bn_name' => '২ টন উইন্ডো এসি'],
                        ]
                    ],
                ]
            ],

            'Fan' => [
                'bn_name' => 'পাখা',
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

            'Refrigerator' => [
                'bn_name' => 'রেফ্রিজারেটর',
                'children' => [
                    'Single Door Fridges' => [
                        'bn_name' => 'সিঙ্গেল ডোর ফ্রিজ',
                        'children' => [
                            ['name' => '165 Liter Refrigerator', 'bn_name' => '১৬৫ লিটার রেফ্রিজারেটর'],
                            ['name' => '190 Liter Refrigerator', 'bn_name' => '১৯০ লিটার রেফ্রিজারেটর'],
                            ['name' => '230 Liter Refrigerator', 'bn_name' => '২৩০ লিটার রেফ্রিজারেটর'],
                        ]
                    ],
                    'Double Door Fridges' => [
                        'bn_name' => 'ডাবল ডোর ফ্রিজ',
                        'children' => [
                            ['name' => '250 Liter Refrigerator', 'bn_name' => '২৫০ লিটার রেফ্রিজারেটর'],
                            ['name' => '300 Liter Refrigerator', 'bn_name' => '৩০০ লিটার রেফ্রিজারেটর'],
                            ['name' => '350 Liter Refrigerator', 'bn_name' => '৩৫০ লিটার রেফ্রিজারেটর'],
                        ]
                    ],
                ]
            ],

            'LED TV' => [
                'bn_name' => 'এলইডি টিভি',
                'children' => [
                    'Smart TVs' => [
                        'bn_name' => 'স্মার্ট টিভি',
                        'children' => [
                            ['name' => '32 inch Smart TV', 'bn_name' => '৩২ ইঞ্চি স্মার্ট টিভি'],
                            ['name' => '43 inch Smart TV', 'bn_name' => '৪৩ ইঞ্চি স্মার্ট টিভি'],
                            ['name' => '55 inch Smart TV', 'bn_name' => '৫৫ ইঞ্চি স্মার্ট টিভি'],
                        ]
                    ],
                    'Android TVs' => [
                        'bn_name' => 'অ্যান্ড্রয়েড টিভি',
                        'children' => [
                            ['name' => 'Android 11 TV', 'bn_name' => 'অ্যান্ড্রয়েড ১১ টিভি'],
                            ['name' => 'Google TV', 'bn_name' => 'গুগল টিভি'],
                            ['name' => 'Built-in Netflix TV', 'bn_name' => 'নেটফ্লিক্স সহ টিভি'],
                        ]
                    ],
                ]
            ],

            'Mixer Grinder' => [
                'bn_name' => 'মিক্সার গ্রাইন্ডার',
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
        ];

        $order = 1;

        foreach ($categories as $name => $data) {
            $slug = Str::slug($name);
            $bnName = $data['bn_name'] ?? '';

            // Create main category (Level 1)
            $mainCategory = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    // 'name' => $name,
                    'name_en' => $name,
                    'name_bn' => $bnName,
                    // 'description' => $this->getDescription($name),
                    'description_en' => $this->getDescription($name),
                    'description_bn' => $this->getBanglaDescription($name),
                    'image' => $this->getCategoryImage($slug),
                    'parent_id' => null,
                    'order' => $order++,
                    'nav_order' => $order,
                    'show_in_nav' => true,
                    'is_featured' => in_array($name, ['Air Conditioner', 'Refrigerator', 'LED TV']),
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

                    $childCategory = Category::updateOrCreate(
                        [
                            'slug' => $childSlug,
                            'parent_id' => $mainCategory->id
                        ],
                        [
                            // 'name' => $childName,
                            'name_en' => $childName,
                            'name_bn' => $childBnName,
                            // 'description' => $this->getDescription($childName),
                            'description_en' => $this->getDescription($childName),
                            'description_bn' => $this->getBanglaDescription($childName),
                            'image' => $this->getCategoryImage($childSlug),
                            'order' => $childOrder++,
                            'show_in_nav' => true,
                            'is_featured' => false,
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
                                    // 'name' => $grandChildName,
                                    'name_en' => $grandChildName,
                                    'name_bn' => $grandChildBnName,
                                    // 'description' => $this->getDescription($grandChildName),
                                    'description_en' => $this->getDescription($grandChildName),
                                    'description_bn' => $this->getBanglaDescription($grandChildName),
                                    'image' => $this->getCategoryImage($grandChildSlug, $childSlug),
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
            'Air Conditioner' => 'Cooling solutions including split AC, window AC, and portable AC with energy-saving technology.',
            'Fan' => 'Wide range of fans including ceiling fans, tower fans, and table fans for all cooling needs.',
            'Refrigerator' => 'Refrigerators including single door, double door, and side-by-side models with advanced cooling technology.',
            'LED TV' => 'LED TVs including Smart TVs, Android TVs, OLED, and 4K Ultra HD models with latest display technology.',
            'Mixer Grinder' => 'Mixer grinders, blenders, and food processors for all kitchen needs with powerful motors.',
            'Split AC' => 'Energy efficient split air conditioners for home and office cooling.',
            'Window AC' => 'Compact window air conditioners for easy installation and space saving.',
            'Ceiling Fan' => 'Ceiling fans with various designs and energy saving features.',
            'Table Fan' => 'Portable table fans for personal cooling needs.',
            'Single Door Fridges' => 'Single door refrigerators perfect for small families and apartments.',
            'Double Door Fridges' => 'Double door refrigerators with separate freezer compartments.',
            'Smart TVs' => 'Smart televisions with built-in streaming apps and internet connectivity.',
            'Android TVs' => 'Android based smart TVs with access to Google Play Store.',
            'Heavy Duty Mixers' => 'Powerful mixer grinders for heavy kitchen use.',
            'Compact Mixers' => 'Compact mixer grinders for small families and occasional use.',
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
            'Air Conditioner' => 'এনার্জি সেভিং টেকনোলজি সহ স্প্লিট এসি, উইন্ডো এসি এবং পোর্টেবল এসি সহ কুলিং সমাধান।',
            'Fan' => 'সব কুলিং চাহিদার জন্য সিলিং ফ্যান, টাওয়ার ফ্যান এবং টেবিল ফ্যান সহ ফ্যানের বিস্তৃত পরিসর।',
            'Refrigerator' => 'উন্নত কুলিং প্রযুক্তি সহ সিঙ্গেল ডোর, ডাবল ডোর এবং সাইড বাই সাইড মডেল সহ রেফ্রিজারেটর।',
            'LED TV' => 'স্মার্ট টিভি, অ্যান্ড্রয়েড টিভি, ওএলইডি এবং ৪কে আলট্রা এইচডি মডেল সহ এলইডি টিভি।',
            'Mixer Grinder' => 'শক্তিশালী মোটর সহ সমস্ত রান্নাঘরের প্রয়োজনের জন্য মিক্সার গ্রাইন্ডার, ব্লেন্ডার এবং ফুড প্রসেসর।',
            'Split AC' => 'বাড়ি এবং অফিসের কুলিংয়ের জন্য শক্তি-দক্ষ স্প্লিট এয়ার কন্ডিশনার।',
            'Window AC' => 'সহজ ইনস্টলেশন এবং স্পেস সেভিংয়ের জন্য কমপ্যাক্ট উইন্ডো এয়ার কন্ডিশনার।',
            'Ceiling Fan' => 'বিভিন্ন ডিজাইন এবং শক্তি সঞ্চয় বৈশিষ্ট্য সহ সিলিং ফ্যান।',
            'Table Fan' => 'ব্যক্তিগত কুলিং চাহিদার জন্য পোর্টেবল টেবিল ফ্যান।',
            'Single Door Fridges' => 'ছোট পরিবার এবং অ্যাপার্টমেন্টের জন্য উপযুক্ত সিঙ্গেল ডোর রেফ্রিজারেটর।',
            'Double Door Fridges' => 'পৃথক ফ্রিজার কম্পার্টমেন্ট সহ ডাবল ডোর রেফ্রিজারেটর।',
            'Smart TVs' => 'বিল্ট-ইন স্ট্রিমিং অ্যাপস এবং ইন্টারনেট সংযোগ সহ স্মার্ট টেলিভিশন।',
            'Android TVs' => 'গুগল প্লে স্টোরের অ্যাক্সেস সহ অ্যান্ড্রয়েড ভিত্তিক স্মার্ট টিভি।',
            'Heavy Duty Mixers' => 'ভারী রান্নাঘরের ব্যবহারের জন্য শক্তিশালী মিক্সার গ্রাইন্ডার।',
            'Compact Mixers' => 'ছোট পরিবার এবং মাঝে মাঝে ব্যবহারের জন্য কমপ্যাক্ট মিক্সার গ্রাইন্ডার।',
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
            'Mixer Grinder' => 'mixer, grinder, blender, food processor, kitchen appliance',
        ];

        $baseKeywords = strtolower($categoryName);
        $additional = $keywordsMap[$categoryName] ?? 'home appliance, electronics, gadgets';

        return $baseKeywords . ', ' . $additional;
    }
}
