<?php

namespace App\View\Components\Frontend\Component;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public array $columns;
    public array $brand;
    public array $payments;
    public string $floatingIcon;

    public function __construct()
    {
        $this->columns = [
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

        $this->brand = [
            'name' => 'TYCOON',
            'description' =>
            'Donec lobortis varius est. Nulla ullamcorper sapien bibendum erat ornare congue. Sed tempus elementum ex convallis bibendum.',
            'productImage' => asset('images/footer-vr.png'),
        ];

        $this->payments = [
            asset('images/pay/mastercard.png'),
            asset('images/pay/visa.png'),
            asset('images/pay/amex.png'),
            asset('images/pay/applepay.png'),
            asset('images/pay/skrill.png'),
            asset('images/pay/paypal.png'),
        ];
    }

    public function render()
    {
        return view('components.frontend.component.footer');
    }
}
