<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class FooterController extends Controller
{
    public function getFooterData()
    {
        $columns = [
            [
                'title' => 'Information',
                'links' => ['History', 'Careers', 'Press And Media', 'Brand Partners', 'Affiliates'],
            ],
            [
                'title' => 'Useful Links',
                'links' => ['Partner Program', 'Affiliate Program', 'App Developers', 'Investors', 'Recent Blogs', 'Contact Us'],
            ],
            [
                'title' => 'Resources',
                'links' => ['Privacy Policy', 'Shipping Policy', 'Refund Polices', 'Delivery Terms', 'Terms & Condition'],
            ],
            [
                'title' => 'Support',
                'links' => ['Shop E-Scooters', 'Sustainability', 'Warranty Information', 'Product Registration', 'User Manuals'],
            ],
        ];

        $brand = [
            'name' => 'TYCOON',
            'description' => 'Donec lobortis varius est. Nulla ullamcorper sapien bibendum erat ornare congue. Sed tempus elementum ex convallis bibendum.',
            'productImage' => 'https://cdn.pixabay.com/photo/2022/09/21/17/36/vr-7470787_1280.png',
        ];

        $payments = [
            'https://cdn-icons-png.flaticon.com/512/196/196578.png',
            'https://cdn-icons-png.flaticon.com/512/196/196561.png',
            'https://cdn-icons-png.flaticon.com/512/196/196539.png',
            'https://cdn-icons-png.flaticon.com/512/888/888871.png',
            'https://cdn-icons-png.flaticon.com/512/888/888879.png',
            'https://cdn-icons-png.flaticon.com/512/888/888870.png',
        ];

        return [
            'columns' => $columns,
            'brand' => $brand,
            'payments' => $payments,
        ];
    }
}
