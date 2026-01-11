{{-- @extends('frontend.layouts.app')

@section('title', 'Product Categories')
@section('description', 'Browse our product categories')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">Product Categories</h1>
            <p class="text-gray-600 font-inter">Browse products by category</p>
        </div>

        <!-- Featured Categories -->
        @if ($featuredCategories->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">Featured Categories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($featuredCategories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 hover:border-primary/40 transition-all duration-300 hover:shadow-xl">
                            <div class="p-8">
                                @if ($category->image)
                                    <div class="w-20 h-20 mb-4 rounded-full overflow-hidden bg-white/50">
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endif
                                <h3 class="text-xl font-bold text-gray-900 mb-2 font-quantico group-hover:text-primary">
                                    {{ $category->name }}</h3>
                                @if ($category->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 font-inter">
                                        {{ $category->description }}</p>
                                @endif
                                <span class="inline-flex items-center text-primary font-medium text-sm font-inter">
                                    Browse Products
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Categories -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">All Categories</h2>
            <div class="space-y-4">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    @if ($category->image)
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 font-quantico">
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                class="hover:text-primary transition-colors">
                                                {{ $category->name }}
                                            </a>
                                        </h3>
                                        @if ($category->description)
                                            <p class="text-gray-600 text-sm mt-1 font-inter">
                                                {{ Str::limit($category->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors text-sm font-quantico">
                                    View Products
                                </a>
                            </div>

                            @if ($category->children->count() > 0)
                                <div class="pl-16">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($category->children as $child)
                                            <a href="{{ route('categories.show', $child->slug) }}"
                                                class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-primary hover:bg-gray-50 transition-colors group">
                                                <span
                                                    class="text-gray-700 group-hover:text-primary font-inter">{{ $child->name }}</span>
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-primary" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection --}}

@extends('frontend.layouts.app')

@section('title', 'Product Categories')
@section('description', 'Browse our wide range of product categories to find exactly what you need.')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-primary/5 via-white to-secondary/5">
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            <div class="relative max-w-8xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6 tracking-tight">
                        Discover <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Categories</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10">
                        Explore our curated collection of product categories. Find exactly what you need or get inspired by
                        our featured selections.
                    </p>

                    <!-- Search Box -->
                    <div class="max-w-2xl mx-auto">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <div class="relative">
                                <input type="text" name="q" placeholder="Search across all categories..."
                                    class="w-full px-6 py-4 pl-14 text-lg rounded-2xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/20 shadow-lg transition-all duration-300">
                                <div class="absolute left-5 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <button type="submit"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2.5 rounded-xl font-semibold hover:opacity-90 transition-opacity">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Categories (Masonry Layout) -->
        @if ($featuredCategories->count() > 0)
            <div class="max-w-8xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
                <div class="mb-10 text-center">
                    <div class="inline-flex items-center space-x-2 mb-4">
                        <div class="w-12 h-1 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
                        <span class="text-sm font-semibold text-primary uppercase tracking-wider">Featured</span>
                        <div class="w-12 h-1 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Popular <span class="text-primary">Categories</span>
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Our most sought-after categories based on customer preferences
                    </p>
                </div>

                <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8">
                    @foreach ($featuredCategories as $index => $category)
                        <div class="break-inside-avoid">
                            <a href="{{ $category->url }}"
                                class="group block bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-primary/30">
                                <div class="relative overflow-hidden aspect-[4/3]">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-primary/30" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    </div>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-gray-800">
                                            {{ $category->products_count ?? 0 }} products
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                    @if ($category->description)
                                        <p class="text-gray-600 mb-4 line-clamp-2">
                                            {{ $category->description }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-sm font-medium text-primary flex items-center group-hover:translate-x-2 transition-transform">
                                            Explore
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </span>
                                        @if ($category->is_featured)
                                            <span
                                                class="text-xs font-semibold bg-yellow-100 text-yellow-800 px-2.5 py-1 rounded-full">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Categories Grid -->
        <div class="max-w-8xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                            All <span class="text-primary">Categories</span>
                        </h2>
                        <p class="text-gray-600">
                            Browse through our complete category collection
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <select id="sortCategories"
                                class="appearance-none bg-white border-2 border-gray-200 rounded-xl pl-4 pr-10 py-3 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                <option value="name">Sort by Name</option>
                                <option value="popular">Most Popular</option>
                                <option value="products">Product Count</option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Filter Tabs -->
                <div class="flex flex-wrap gap-2 mb-8">
                    <button class="px-4 py-2 rounded-full bg-primary text-white font-medium transition-all">
                        All Categories
                    </button>
                    @foreach ($categories->take(6) as $category)
                        <button
                            class="px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-all">
                            {{ $category->name }}
                        </button>
                    @endforeach
                    @if ($categories->count() > 6)
                        <button
                            class="px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-all">
                            More +
                        </button>
                    @endif
                </div>
            </div>

            @if ($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($categories as $category)
                        <div
                            class="group relative bg-white rounded-2xl border border-gray-200 hover:border-primary/50 transition-all duration-300 overflow-hidden hover:shadow-xl">
                            <!-- Category Card -->
                            <div class="p-6">
                                <!-- Icon/Image -->
                                <div class="mb-4">
                                    @if ($category->image)
                                        <div
                                            class="w-16 h-16 rounded-xl overflow-hidden bg-gradient-to-br from-primary/10 to-secondary/10 p-3">
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Category Info -->
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors">
                                    <a href="{{ $category->url }}">{{ $category->name }}</a>
                                </h3>

                                @if ($category->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                        {{ $category->description }}
                                    </p>
                                @endif

                                <!-- Stats -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $category->products_count ?? 0 }} products
                                    </span>
                                    @if ($category->children_count > 0)
                                        <span class="text-sm text-gray-500">
                                            {{ $category->children_count }} subcategories
                                        </span>
                                    @endif
                                </div>

                                <!-- CTA Button -->
                                <a href="{{ $category->url }}"
                                    class="block w-full text-center py-2.5 bg-gray-100 hover:bg-primary text-gray-700 hover:text-white rounded-lg font-medium transition-all duration-300 group-hover:translate-y-0 transform">
                                    View Products
                                </a>

                                <!-- Subcategories Flyout (on hover) -->
                                @if ($category->children->count() > 0)
                                    <div
                                        class="absolute inset-x-0 bottom-full mb-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10">
                                        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-4">
                                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                                Subcategories
                                            </div>
                                            <div class="space-y-2">
                                                @foreach ($category->children->take(3) as $child)
                                                    <a href="{{ $child->url }}"
                                                        class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                                        <span class="text-sm text-gray-700">{{ $child->name }}</span>
                                                        <span
                                                            class="text-xs text-gray-500">{{ $child->products_count ?? 0 }}</span>
                                                    </a>
                                                @endforeach
                                                @if ($category->children->count() > 3)
                                                    <a href="{{ $category->url }}"
                                                        class="text-center text-sm text-primary font-medium pt-2">
                                                        View all {{ $category->children->count() }} subcategories
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="mb-6">
                        <div class="w-24 h-24 mx-auto mb-4">
                            <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No Categories Found</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            There are currently no product categories available. Please check back later.
                        </p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:opacity-90 transition-opacity">
                            Browse All Products
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Stats Section -->
        <div class="bg-gradient-to-r from-primary/5 to-secondary/5 border-t border-b border-gray-200">
            <div class="max-w-8xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Why Shop by <span class="text-primary">Category</span>?
                    </h2>
                    <p class="text-gray-600 max-w-3xl mx-auto">
                        Organized shopping makes finding what you need faster and easier
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Easy Navigation</h3>
                        <p class="text-gray-600">
                            Quickly find products organized by type and purpose
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Quick Discovery</h3>
                        <p class="text-gray-600">
                            Discover related products you might be interested in
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Better Results</h3>
                        <p class="text-gray-600">
                            More relevant product suggestions and recommendations
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="max-w-8xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-primary to-secondary"></div>
                <div class="relative z-10 px-8 py-12 sm:p-16">
                    <div class="text-center">
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                            Still Can't Find What You Need?
                        </h2>
                        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
                            Our powerful search tool can help you find specific products across all categories.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('search') }}"
                                class="inline-flex items-center justify-center px-8 py-3 bg-white text-primary font-bold rounded-xl hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search Products
                            </a>
                            <a href="{{ route('contact') }}"
                                class="inline-flex items-center justify-center px-8 py-3 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category sorting
            const sortSelect = document.getElementById('sortCategories');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    // Implement category sorting logic here
                    console.log('Sort by:', this.value);
                });
            }

            // Filter tab functionality
            const filterTabs = document.querySelectorAll('.flex-wrap button');
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    filterTabs.forEach(t => t.classList.remove('bg-primary', 'text-white'));
                    filterTabs.forEach(t => t.classList.add('bg-gray-100', 'text-gray-700'));
                    this.classList.remove('bg-gray-100', 'text-gray-700');
                    this.classList.add('bg-primary', 'text-white');

                    // Implement filter logic here
                    const filterText = this.textContent.trim();
                    console.log('Filter by:', filterText);
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endpush
