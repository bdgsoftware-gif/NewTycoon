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
                'links' => ['About Us', 'Careers', 'Press & Media', 'Brand Partners', 'Affiliates'],
            ],
            [
                'title' => 'Customer Service',
                'links' => ['Contact Us', 'Shipping Info', 'Returns', 'Size Guide', 'FAQ'],
            ],
            [
                'title' => 'Legal',
                'links' => ['Privacy Policy', 'Terms of Service', 'Shipping Policy', 'Refund Policy', 'Cookie Policy'],
            ],
            [
                'title' => 'Shop',
                'links' => ['New Arrivals', 'Best Sellers', 'Sale', 'Gift Cards', 'Store Locator'],
            ],
        ];

        $brand = [
            'name' => 'TYCOON',
            'description' => 'Your premier destination for cutting-edge technology and electronics. We bring you the latest innovations with exceptional quality and service.',
            'productImage' => 'images/footer-product.png', // Use your local image path
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
