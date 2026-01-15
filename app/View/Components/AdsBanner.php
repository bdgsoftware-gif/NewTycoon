<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdsBanner extends Component
{
    public $adsBanners;

    /**
     * Create a new component instance.
     */
    public function __construct($adsBanners = [])
    {
        $this->adsBanners = $adsBanners;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.ads-banner');
    }
}
