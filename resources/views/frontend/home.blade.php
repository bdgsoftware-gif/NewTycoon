@extends('frontend.layouts.app')
@section('title', 'Hi-Tech Park')
@section('content')
    {{-- @include('frontend.partials.hero')
    <x-category-slider :categories="$categories" />
    <x-products :products="$products" />
    @include('frontend.partials.smart-section') --}}

    <!-- Product Sliders with Consistent Design -->
    {{-- <x-product-slider :products="$recommendedProducts" title="Recommended for you" :autoPlay="true" :showNavigation="true" /> --}}

    {{-- <x-product-slider :products="$featuredProducts" title="Featured Products" sliderId="featuredSlider" :slidesPerView="4"
        cardStyle="modern" /> --}}

    {{-- Correct usage: --}}
    <x-product-slider :slidingProducts="$recommendedProducts ?? []" title="Recommended for you" sliderId="recommendedSlider" :slidesPerView="5"
        :autoPlay="false" :showNavigation="true" :showPagination="false" cardStyle="minimal" />

    {{-- <x-product-slider :products="$newArrivals" title="New Arrivals" sliderId="newArrivalsSlider" cardStyle="elegant"
        :slidesPerView="3" /> --}}

@endsection
