@extends('frontend.layouts.app')

@section('title', 'All Categories')
@section('description', 'Browse our product categories')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">Product Categories</h1>
            <p class="text-gray-600 font-inter">Browse products by category</p>
        </div>

        <!-- Featured Categories -->
        @if ($featuredCategories->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">Featured Categories</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($featuredCategories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group bg-white border border-gray-200 rounded-xl p-4 text-center hover:border-primary hover:shadow-lg transition-all duration-300">
                            @if ($category->image)
                                <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 rounded-full overflow-hidden p-3">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                </div>
                            @endif
                            <h3
                                class="font-semibold text-gray-900 group-hover:text-primary transition-colors duration-200 font-cambay text-sm">
                                {{ $category->name }}
                            </h3>
                            @if ($category->products_count ?? 0)
                                <p class="text-xs text-gray-500 mt-1 font-inter">{{ $category->products_count }} products
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Categories (Hierarchical) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach ($categories as $mainCategory)
                <div class="bg-white border border-gray-200 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 font-quantico">
                        <a href="{{ route('categories.show', $mainCategory->slug) }}"
                            class="hover:text-primary transition-colors duration-200">
                            {{ $mainCategory->name }}
                        </a>
                    </h2>

                    @if ($mainCategory->children->count() > 0)
                        <div class="space-y-3">
                            @foreach ($mainCategory->children as $childCategory)
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-2 font-inter">
                                        <a href="{{ route('categories.show', $childCategory->slug) }}"
                                            class="hover:text-primary transition-colors duration-200">
                                            {{ $childCategory->name }}
                                        </a>
                                    </h3>

                                    @if ($childCategory->children->count() > 0)
                                        <div class="pl-4 space-y-1">
                                            @foreach ($childCategory->children as $grandchildCategory)
                                                <a href="{{ route('categories.show', $grandchildCategory->slug) }}"
                                                    class="block text-sm text-gray-600 hover:text-primary transition-colors duration-200 font-inter">
                                                    {{ $grandchildCategory->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
