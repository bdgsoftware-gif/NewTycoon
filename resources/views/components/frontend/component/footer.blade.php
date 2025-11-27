<footer class="bg-[#1a1126] text-white pt-20 pb-12 px-8 relative">

    {{-- Top Footer Section --}}
    <div class="max-w-7xl mx-auto grid grid-cols-12 gap-10">

        {{-- Left Columns --}}
        @foreach ($columns as $index => $col)
            <div class="col-span-12 md:col-span-2" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                <h3 class="text-xl font-semibold mb-6 text-purple-400">{{ $col['title'] }}</h3>
                <ul class="space-y-3 text-gray-300">
                    @foreach ($col['links'] as $link)
                        <li>
                            <a href="#" class="hover:text-purple-400 transition">{{ $link }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        {{-- Center Brand Block --}}
        <div class="col-span-12 md:col-span-4 flex flex-col items-center text-center px-6" data-aos="zoom-in"
            data-aos-delay="300">

            <h2 class="text-4xl font-bold tracking-widest">{{ $brand['name'] }}</h2>

            <p class="mt-4 text-gray-300 leading-relaxed text-sm max-w-md">
                {{ $brand['description'] }}
            </p>

            {{-- Product Image --}}
            <img src="{{ $brand['productImage'] }}" class="mt-6 w-72 drop-shadow-[0_0_25px_#b34bff]"
                data-aos="zoom-in-up" data-aos-delay="400">
        </div>

    </div>

    {{-- Divider Line --}}
    <div class="max-w-7xl mx-auto border-b border-gray-600 my-10" data-aos="fade-right" data-aos-delay="300"></div>

    {{-- Bottom Section --}}
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between">

        <p class="text-gray-400 text-sm" data-aos="fade-up" data-aos-delay="100">
            Copyright © Tycoon.com, All Right Reserved © {{ date('Y') }}
        </p>

        {{-- Payment Icons --}}
        <div class="flex items-center gap-3 mt-6 md:mt-0" data-aos="fade-up" data-aos-delay="200">
            @foreach ($payments as $img)
                <img src="{{ $img }}" class="h-8 object-contain hover:scale-110 transition" />
            @endforeach
        </div>

    </div>
</footer>
