@extends('frontend.layouts.app')
@section('title', 'Hi-Tech Park')
@section('content')
    @include('frontend.partials.hero')
    <x-category-slider :categories="$categories" />
    <x-products :featuredProducts="$featuredProducts" />
    @include('components.offer-products')

    {{-- @include('frontend.partials.smart-section') --}}
    {{-- @include('frontend.partials.ads-banner') --}}
    <x-ads-banner :adsBanners="$adsBanners ?? []" />
    <!-- New Arrivals -->
    <x-product-slider :slidingProducts="$products['new_arrivals'] ?? []" title="New Arrivals" sliderId="newArrival" :slidesPerView="5" :autoPlay="false"
        :showNavigation="true" :showPagination="false" cardStyle="minimal" />
    <!-- Recommended for you -->
    <x-ads-banner :adsBanners="$adsAnotherBanners ?? []" />
    <x-product-slider :slidingProducts="$products['recommended'] ?? []" title="Recommended for you" sliderId="recommendedSlider" :slidesPerView="5"
        :autoPlay="true" :showNavigation="true" :showPagination="false" cardStyle="minimal" />
    <!-- Ad card with Products -->
    <x-product-slider :slidingProducts="$products['bestsells'] ?? []" :adsImages="[
        [
            'image' => asset('images/ads/adsss.png'),
            'link' => '/products/special-offer',
        ],
        [
            'image' => asset('images/ads/addss.png'),
            'link' => '/category/gaming',
        ],
    ]" title="Best Sells" sliderId="featured-slider" :slidesPerView="3"
        :autoPlay="true" :showNavigation="true" :showPagination="false" cardStyle="modern" />
    <!--  -->

    <!-- User Video Stories Section -->
    @include('frontend.partials.user-stories')
@endsection
