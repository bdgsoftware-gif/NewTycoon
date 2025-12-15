<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FooterColumn;
use App\Models\FooterSetting;

class FooterController extends Controller
{
    public function getFooterData()
    {
        // Get all active columns with their active links
        $columns = FooterColumn::with(['activeLinks' => function ($query) {
            $query->select('id', 'footer_column_id', 'title', 'url', 'sort_order');
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($column) {
                return [
                    'title' => $column->title,
                    'links' => $column->activeLinks->map(function ($link) {
                        return [
                            'title' => $link->title,
                            'url' => $link->url
                        ];
                    })->toArray()
                ];
            })
            ->toArray();

        // Get footer settings
        $settings = FooterSetting::first();

        $brand = [
            'name' => $settings->brand_name ?? 'TYCOON',
            'description' => $settings->brand_description ?? '',
            'productImage' => $settings->product_image ?? 'images/cat/pressure-cooker.png',
            'productLink' => $settings->product_link ?? '/',
        ];

        $payments = $settings->payment_methods ?? [
            'https://cdn-icons-png.flaticon.com/512/196/196578.png',
            'https://cdn-icons-png.flaticon.com/512/196/196561.png',
            'https://cdn-icons-png.flaticon.com/512/196/196539.png',
            'https://cdn-icons-png.flaticon.com/512/888/888871.png',
            'https://cdn-icons-png.flaticon.com/512/888/888879.png',
            'https://cdn-icons-png.flaticon.com/512/888/888870.png',
        ];

        $socialLinks = $settings->social_links ?? [
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'linkedin' => '#'
        ];

        return [
            'columns' => $columns,
            'brand' => $brand,
            'payments' => $payments,
            'social_links' => $socialLinks
        ];
    }
}
