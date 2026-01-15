<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FooterColumn;
use App\Models\FooterSetting;

class FooterController extends Controller
{
    public function getFooterData(): array
    {
        // Columns with active links
        $columns = FooterColumn::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['activeLinks:id,footer_column_id,title_en,title_bn,url,sort_order'])
            ->get()
            ->map(fn($column) => [
                'title' => $column->title,
                'links' => $column->activeLinks->map(fn($link) => [
                    'title' => $link->title,
                    'url'   => $link->url,
                ])->values(),
            ])
            ->values();

        // Footer settings (singleton)
        $settings = FooterSetting::first();

        return [
            'columns' => $columns,
            'brand' => [
                'name'        => $settings?->brand_name ?? 'TYCOON',
                'description' => $settings?->brand_description ?? '',
                'productImage' => $settings?->product_image ?? null,
                'productLink' => $settings?->product_link ?? '/',
            ],
            'payments' => $settings?->payment_methods ?? [],
            'social_links' => $settings?->social_links ?? [],
        ];
    }
}
