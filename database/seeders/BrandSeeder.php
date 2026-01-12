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
                'name_en' => 'Acme Corp',
                'name_bn' => 'অ্যাকমে কর্প',
                'description_en' => 'Leading manufacturer of quality products.',
                'description_bn' => 'গুণগত মানের পণ্যের শীর্ষস্থানীয় নির্মাতা।',
                'slug' => 'acme-corp',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name_en' => 'Global Goods',
                'name_bn' => 'গ্লোবাল গুডস',
                'description_en' => 'Worldwide distributor of various goods.',
                'description_bn' => 'বিভিন্ন পণ্যের বিশ্বব্যাপী বিতরণকারী।',
                'slug' => 'global-goods',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name_en' => 'Tech Innovators',
                'name_bn' => 'টেক ইনোভেটর্স',
                'description_en' => 'Innovative technology solutions provider.',
                'description_bn' => 'নবীন প্রযুক্তি সমাধান প্রদানকারী।',
                'slug' => 'tech-innovators',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
