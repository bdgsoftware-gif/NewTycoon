@extends('frontend.layouts.app')
@section('title', 'Hi-Tech Park')
@section('content')
    @include('frontend.partials.hero')
    <x-category-slider :categories="$categories" />
    <x-products :products="$products" />
    {{-- @include('frontend.partials.smart-section') --}}
    {{-- @include('frontend.partials.ads-banner') --}}
    <x-ads-banner :adsBanners="$adsBanners ?? []" />
    <!-- Product Sliders with Consistent Design -->
    {{-- <x-product-slider :products="$recommendedProducts" title="Recommended for you" :autoPlay="true" :showNavigation="true" /> --}}

    {{-- <x-product-slider :products="$featuredProducts" title="Featured Products" sliderId="featuredSlider" :slidesPerView="4"
        cardStyle="modern" /> --}}

    {{-- Correct usage: --}}
    <x-product-slider :slidingProducts="$newArrivals ?? []" title="New Arrival" sliderId="newArrival" :slidesPerView="5" :autoPlay="false"
        :showNavigation="true" :showPagination="false" cardStyle="minimal" />

    {{-- <x-product-slider :products="$newArrivals" title="New Arrivals" sliderId="newArrivalsSlider" cardStyle="elegant"
        :slidesPerView="3" /> --}}

    <!-- Ads Banner Component -->
    <x-ads-banner :adsBanners="$adsAnotherBanners ?? []" />
    <x-product-slider :slidingProducts="$recommendedProducts ?? []" title="Recommended for you" sliderId="recommendedSlider" :slidesPerView="5"
        :autoPlay="true" :showNavigation="true" :showPagination="false" cardStyle="minimal" />

    <x-product-slider :slidingProducts="$featuredProducts" :adsImages="[
        [
            'image' => asset('images/ads/adsss.png'),
            'link' => '/products/special-offer',
            'title' => 'Special Electronics Sale',
            'description' => 'Up to 50% off on selected items',
            'alt_text' => 'Special Electronics Sale',
        ],
        [
            'image' => asset('images/ads/addss.png'),
            'link' => '/category/gaming',
            'title' => 'Gaming Gear Collection',
            'description' => 'Premium gaming accessories',
            'alt_text' => 'Gaming Gear Collection',
        ],
    ]" title="Ads Section" sliderId="featured-slider"
        :slidesPerView="3" :autoPlay="true" :showNavigation="true" :showPagination="false" cardStyle="modern" />


    @include('frontend.partials.user-stories')
@endsection
