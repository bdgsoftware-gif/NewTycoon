{{-- resources/views/components/ads-banner.blade.php --}}
@props(['adsBanners' => []])

@php
    $allImages = collect();

    foreach ($adsBanners as $banner) {
        $images = $banner->images ?? [];
        foreach ($images as $imagePath) {
            $allImages->push(
                (object) [
                    'image_path' => $imagePath,
                    'link' => $banner->link ?? '#',
                    'target' => $banner->target ?? '_self',
                    'alt_text' => $banner->title ?? 'Advertisement Banner',
                ],
            );
        }
    }

    $displayImages = $allImages->take(3);
    $count = $displayImages->count();
@endphp
@php
    echo '<pre>';
    print_r($adsBanners->toArray());
    echo '</pre>';
@endphp
@if ($count > 0)
    <section class="max-w-8xl mx-auto pt-12 ads-section">
        {{-- Responsive grid layout based on image count --}}
        <div
            class="grid gap-4 px-4
            @if ($count == 1) grid-cols-1
            @elseif($count == 2) grid-cols-1 md:grid-cols-2
            @elseif($count == 3) grid-cols-1 md:grid-cols-3 @endif">

            @foreach ($displayImages as $image)
                <a href="{{ $image->link }}" @if ($image->link !== '#') target="{{ $image->target }}" @endif
                    class="block transition-transform duration-300 hover:scale-[1.02] hover:shadow-md">
                    <div class="relative aspect-[16/6] overflow-hidden">
                        {{-- Use asset() with 'storage/' prefix – adjust if your paths already include 'storage/' --}}
                        <img src="{{ asset('storage/' . ltrim($image->image_path, '/')) }}" alt="{{ $image->alt_text }}"
                            class="w-full h-full object-contain object-center rounded-xl" loading="lazy">
                    </div>
                </a>
            @endforeach

        </div>
    </section>
@endif
