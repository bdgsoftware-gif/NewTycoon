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
        'rice-cooker' => 'categories/rice-cooker.png',
        'pressure-cooker' => 'categories/pressure-cooker.png',
        'mixer-grinder' => 'categories/mixer.png',
        'cookware' => 'categories/cookware.png',
        'electric-kettle' => 'categories/kettle.png',
        'electric-cooker' => 'categories/induction.png',
        'ceiling-fan' => 'categories/fan.png',
        'rechargeable-fan' => 'categories/rechargeable-fan.png',
        'gas-stove' => 'categories/gas-burner.png',
        'room-comforter' => 'categories/comforter.png',
        'microwave-oven' => 'categories/microwave.png',
        'air-conditioner' => 'categories/ac.png',
        'led-tv' => 'categories/led-tv.png',
        'washing-machine' => 'categories/washing-machine.png',
        'refrigerator' => 'categories/refrigerator.png',
    ];

    public function run(): void
    {
        /**
         * Simplified Category Structure (Max 2 Layers)
         * Based on Tycoon Product PDFs
         */

        $categories = [
            // =============================================
            // NAV CATEGORY 1: RICE COOKER - FEATURED
            // =============================================
            'Rice Cooker' => [
                'bn_name' => 'রাইস কুকার',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 1,
                'description' => 'Electric rice cookers and multi cookers with auto shut-off, keep warm function and non-stick pots for perfectly cooked rice.',
                'children' => [
                    ['name' => '2.8L Rice Cooker', 'bn_name' => '২.৮ লিটার রাইস কুকার'],
                    ['name' => '3.2L Rice Cooker', 'bn_name' => '৩.২ লিটার রাইস কুকার'],
                    ['name' => '3.5L Rice Cooker', 'bn_name' => '৩.৫ লিটার রাইস কুকার'],
                    ['name' => 'Multi Cooker', 'bn_name' => 'মাল্টি কুকার'],
                ]
            ],

            // =============================================
            // NAV CATEGORY 2: PRESSURE COOKER - FEATURED
            // =============================================
            'Pressure Cooker' => [
                'bn_name' => 'প্রেসার কুকার',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 2,
                'description' => 'Aluminum and stainless steel pressure cookers with safety features for fast and efficient cooking.',
                'children' => [
                    ['name' => 'Aluminum Pressure Cooker', 'bn_name' => 'অ্যালুমিনিয়াম প্রেসার কুকার'],
                    ['name' => 'SS Pressure Cooker', 'bn_name' => 'এসএস প্রেসার কুকার'],
                ]
            ],

            // =============================================
            // NAV CATEGORY 3: MIXER GRINDER - FEATURED
            // =============================================
            'Mixer Grinder' => [
                'bn_name' => 'মিক্সার গ্রাইন্ডার',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 3,
                'description' => 'Powerful mixer grinders with multiple jars and speeds ranging from 750W to 1500W for all kitchen grinding needs.',
                'children' => [
                    ['name' => '750W Mixer Grinder', 'bn_name' => '৭৫০ ওয়াট মিক্সার গ্রাইন্ডার'],
                    ['name' => '1000W Mixer Grinder', 'bn_name' => '১০০০ ওয়াট মিক্সার গ্রাইন্ডার'],
                    ['name' => '1500W Mixer Grinder', 'bn_name' => '১৫০০ ওয়াট মিক্সার গ্রাইন্ডার'],
                ]
            ],

            // =============================================
            // NAV CATEGORY 4: COOKWARE - FEATURED
            // =============================================
            'Cookware' => [
                'bn_name' => 'রান্নার পাত্র',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 4,
                'description' => 'Non-stick cookware sets and stainless steel pans, woks, soup bowls and kitchen accessories.',
                'children' => [
                    ['name' => 'Non-Stick Cookware Set', 'bn_name' => 'নন-স্টিক কুকওয়্যার সেট'],
                    ['name' => 'SS Fry Pan', 'bn_name' => 'এসএস ফ্রাই প্যান'],
                    ['name' => 'SS Wok Pan', 'bn_name' => 'এসএস ওয়াক প্যান'],
                    ['name' => 'SS Soup Bowl', 'bn_name' => 'এসএস স্যুপ বোল'],
                    ['name' => 'SS Haman Dista', 'bn_name' => 'এসএস হামান দিস্তা'],
                    ['name' => 'Kitchen Rack', 'bn_name' => 'কিচেন র্যাক'],
                ]
            ],

            // =============================================
            // NAV CATEGORY 5: ELECTRIC KETTLE - FEATURED
            // =============================================
            'Electric Kettle' => [
                'bn_name' => 'ইলেকট্রিক কেটলি',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 5,
                'description' => 'Stainless steel electric kettles with auto shut-off, boil-dry protection and fast heating from 1.8L to 3.0L capacity.',
                'children' => [
                    ['name' => '1.8L Electric Kettle', 'bn_name' => '১.৮ লিটার কেটলি'],
                    ['name' => '2.0L Electric Kettle', 'bn_name' => '২.০ লিটার কেটলি'],
                    ['name' => '3.0L Electric Kettle', 'bn_name' => '৩.০ লিটার কেটলি'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: ELECTRIC COOKER
            // =============================================
            'Electric Cooker' => [
                'bn_name' => 'ইলেকট্রিক কুকার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Induction and infrared cookers with standard and inverter technology for efficient and fast cooking.',
                'children' => [
                    ['name' => 'Induction Cooker', 'bn_name' => 'ইন্ডাকশন কুকার'],
                    ['name' => 'Inverter Induction', 'bn_name' => 'ইনভার্টার ইন্ডাকশন'],
                    ['name' => 'Infrared Cooker', 'bn_name' => 'ইনফ্রারেড কুকার'],
                    ['name' => 'Inverter Infrared', 'bn_name' => 'ইনভার্টার ইনফ্রারেড'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: FAN
            // =============================================
            'Ceiling Fan' => [
                'bn_name' => 'পাখা',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Decorative ceiling fans and rechargeable emergency fans with high air delivery and energy efficiency.',
                'children' => [
                    ['name' => 'Ceiling Fan 56 inch', 'bn_name' => '৫৬ ইঞ্চি সিলিং ফ্যান'],
                    ['name' => 'Rechargeable Fan', 'bn_name' => 'রিচার্জেবল ফ্যান'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: GAS STOVE
            // =============================================
            'Gas Stove' => [
                'bn_name' => 'গ্যাস স্টোভ',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Double burner glass top LPG stoves with safety features, auto ignition and printed designs.',
                'has_children' => false, // Single layer
            ],

            // =============================================
            // FEATURED CATEGORY: ROOM COMFORTER
            // =============================================
            'Room Comforter' => [
                'bn_name' => 'রুম কম্ফোর্টার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Electric room heaters for winter comfort with self-rotation feature and safety protection.',
                'has_children' => false, // Single layer
            ],

            // =============================================
            // FEATURED CATEGORY: MICROWAVE OVEN
            // =============================================
            'Microwave Oven' => [
                'bn_name' => 'মাইক্রোওয়েভ ওভেন',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Convection microwave ovens 30L with multi-cooking functions for baking, grilling and heating.',
                'has_children' => false, // Single layer
            ],

            // =============================================
            // FEATURED CATEGORY: AIR CONDITIONER
            // =============================================
            'Air Conditioner' => [
                'bn_name' => 'এয়ার কন্ডিশনার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Energy efficient inverter air conditioners with hot & cool function and WiFi smart control.',
                'has_children' => false, // Single layer
            ],

            // =============================================
            // FEATURED CATEGORY: LED TV
            // =============================================
            'LED TV' => [
                'bn_name' => 'এলইডি টিভি',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Frameless smart LED TVs with voice control, Google OS, Android OS and built-in streaming apps.',
                'children' => [
                    ['name' => '32 inch LED TV', 'bn_name' => '৩২ ইঞ্চি এলইডি টিভি'],
                    ['name' => '43 inch LED TV', 'bn_name' => '৪৩ ইঞ্চি এলইডি টিভি'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: WASHING MACHINE
            // =============================================
            'Washing Machine' => [
                'bn_name' => 'ওয়াশিং মেশিন',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Fully automatic top loading washing machines 8KG with multiple wash programs and energy efficiency.',
                'has_children' => false, // Single layer
            ],

            // =============================================
            // FEATURED CATEGORY: REFRIGERATOR
            // =============================================
            'Refrigerator' => [
                'bn_name' => 'রেফ্রিজারেটর',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Direct cool and bottom mount refrigerators with 3D cooling technology and decorative printed designs.',
                'children' => [
                    ['name' => '202L Refrigerator', 'bn_name' => '২০২ লিটার রেফ্রিজারেটর'],
                    ['name' => '235L Refrigerator', 'bn_name' => '২৩৫ লিটার রেফ্রিজারেটর'],
                    ['name' => '252L Refrigerator', 'bn_name' => '২৫২ লিটার রেফ্রিজারেটর'],
                    ['name' => '302L Refrigerator', 'bn_name' => '৩০২ লিটার রেফ্রিজারেটর'],
                    ['name' => 'Bottom Mount Refrigerator', 'bn_name' => 'বটম মাউন্ট রেফ্রিজারেটর'],
                ]
            ],
        ];

        $order = 1;

        foreach ($categories as $name => $data) {
            $slug = Str::slug($name);
            $bnName = $data['bn_name'] ?? '';
            $showInNav = $data['show_in_nav'] ?? false;
            $isFeatured = $data['is_featured'] ?? false;
            $navOrder = $data['nav_order'] ?? 999;
            $description = $data['description'] ?? '';
            $hasChildren = $data['has_children'] ?? true;

            // Create main category (Level 1)
            $mainCategory = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name_en' => $name,
                    'name_bn' => $bnName,
                    'description_en' => $description,
                    'description_bn' => $this->translateDescription($description),
                    'image' => $this->imageMapping[$slug] ?? 'categories/default.png',
                    'parent_id' => null,
                    'depth' => 1,
                    'order' => $order++,
                    'nav_order' => $navOrder,
                    'show_in_nav' => $showInNav,
                    'is_featured' => $isFeatured,
                    'is_active' => true,
                    'meta_title' => $name . ' - Best Products Online',
                    'meta_description' => 'Shop for ' . strtolower($name) . ' at best prices in Bangladesh.',
                    'meta_keywords' => $this->generateKeywords($name),
                ]
            );

            // Create Level 2 categories (LEAF NODES) if has children
            if ($hasChildren && isset($data['children']) && is_array($data['children'])) {
                $childOrder = 1;
                foreach ($data['children'] as $child) {
                    $childName = $child['name'];
                    $childBnName = $child['bn_name'] ?? '';
                    $childSlug = Str::slug($childName);

                    Category::updateOrCreate(
                        [
                            'slug' => $childSlug,
                            'parent_id' => $mainCategory->id
                        ],
                        [
                            'name_en' => $childName,
                            'name_bn' => $childBnName,
                            'description_en' => $this->getLeafDescription($childName),
                            'description_bn' => $this->translateDescription($this->getLeafDescription($childName)),
                            'image' => $this->imageMapping[$childSlug] ?? $this->imageMapping[$slug] ?? 'categories/default.png',
                            'depth' => 2,
                            'order' => $childOrder++,
                            'show_in_nav' => false,
                            'is_featured' => false,
                            'is_active' => true,
                            'meta_title' => $childName . ' - Buy Online',
                            'meta_description' => 'Buy ' . strtolower($childName) . ' at best price in Bangladesh.',
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📁 Total categories: ' . Category::count());
        $this->command->info('📁 Level 1 (Parent): ' . Category::whereNull('parent_id')->count());
        $this->command->info('📁 Level 2 (Leaf): ' . Category::where('depth', 2)->count());
        $this->command->info('⭐ Featured categories: ' . Category::where('is_featured', true)->count());
        $this->command->info('🧭 Navigation categories: ' . Category::where('show_in_nav', true)->count());
    }

    private function getLeafDescription(string $name): string
    {
        return "High quality {$name} with warranty and fast delivery across Bangladesh at competitive prices.";
    }

    private function translateDescription(string $text): string
    {
        $translations = [
            'High quality' => 'উচ্চ মানের',
            'with' => 'সহ',
            'and' => 'এবং',
            'Electric' => 'ইলেকট্রিক',
            'Stainless steel' => 'স্টেইনলেস স্টিল',
        ];

        $translated = $text;
        foreach ($translations as $en => $bn) {
            $translated = str_replace($en, $bn, $translated);
        }
        return $translated;
    }

    private function generateKeywords(string $name): string
    {
        $base = strtolower($name);
        return "{$base}, buy {$base}, {$base} price bangladesh, best {$base}, {$base} online";
    }
}
