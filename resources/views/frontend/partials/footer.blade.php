<!-- resources/views/partials/footer.blade.php -->
<footer class="bg-gray-900 text-white pt-16 pb-10 px-6 md:px-8 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -bottom-32 -right-32 w-64 h-64 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="absolute -bottom-48 left-1/4 w-52 h-52 rounded-full bg-accent/10 blur-3xl"></div>
        <div class="absolute top-1/4 -left-20 w-40 h-40 rounded-full bg-gray-800 blur-3xl"></div>
    </div>

    <div class="max-w-8xl mx-auto relative z-10">
        <!-- Top Footer Section - Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            <!-- Brand Section - Centered -->
            <div class="lg:col-span-4 flex justify-center lg:justify-start" data-aos="fade-up">
                <div class="bg-white/5 p-8 rounded-2xl border border-white/10 backdrop-blur-sm max-w-sm w-full">
                    <!-- Logo -->
                    <div class="text-center lg:text-left">
                        {{-- <h2 class="text-3xl font-bold tracking-wider text-white mb-4">
                            TYCOON
                        </h2> --}}
                        <a href="{{ url('/') }}" aria-label="Home" class="inline-block"
                            title="Tycoon Hi-Tech Park">
                            <img src="{{ asset('images/wh-logo.png') }}" alt="BK Logo" loading="lazy"
                                class="h-6 md:h-8 w-auto">
                        </a>
                        <div class="w-16 h-1 bg-primary rounded-full mx-auto lg:mx-0 mb-6"></div>
                    </div>

                    <!-- Product Image -->
                    <div class="mt-6 relative">
                        <div class="absolute inset-0 bg-primary/20 rounded-full blur-xl"></div>
                        <img src="{{ asset($footerData['brand']['productImage']) }}" alt="Tycoon Product"
                            class="relative w-full max-w-[100px] mx-auto drop-shadow-[0_0_25px_rgba(234,47,48,0.3)]"
                            data-aos="zoom-in" data-aos-delay="200">
                    </div>

                    <!-- Description -->
                    <p class="mt-6 text-gray-300 leading-relaxed text-sm text-center lg:text-left">
                        {{ $footerData['brand']['description'] }}
                    </p>

                    <!-- Social Media -->
                    <div class="flex justify-center lg:justify-start gap-3 mt-6">
                        <a href="#"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-facebook-f text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-twitter text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-instagram text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                        <a href="#"
                            class="social-icon w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-all duration-300 group border border-white/10">
                            <i class="fab fa-linkedin-in text-gray-400 group-hover:text-white text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Links Sections -->
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($footerData['columns'] as $index => $column)
                    <div class="flex-1" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <h3 class="text-xl font-semibold mb-6 text-white border-l-4 border-primary pl-3 font-cambay">
                            {{ $column['title'] }}
                        </h3>
                        <ul class="space-y-3">
                            @foreach ($column['links'] as $link)
                                <li class="font-quantico">
                                    <a href="#"
                                        class="group flex items-center text-gray-300 hover:text-white transition-all duration-300 py-1">
                                        <span
                                            class="w-1.5 h-1.5 bg-primary rounded-full mr-3 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all duration-300"></span>
                                        <span
                                            class="text-base hover:text-primary transition-colors">{{ $link }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="bg-gradient-to-r from-primary/10 to-accent/10 rounded-2xl p-8 mb-12 border border-white/10"
            data-aos="fade-up">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-2xl font-bold text-white mb-3 font-quantico">Stay Updated</h3>
                <p class="text-gray-300 mb-6 max-w-2xl mx-auto font-cambay">Subscribe to our newsletter for the latest
                    products,
                    offers, and tech news.</p>
                <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto font-quantico">
                    <input type="email" placeholder="Enter your email"
                        class="flex-1 px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-400
         focus:outline-none focus:ring-0 focus:border-primary transition-colors font-quantico" />
                    <button
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-red-600 transition-colors font-semibold whitespace-nowrap">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-b border-gray-700/50 my-8" data-aos="fade-right"></div>

        <!-- Bottom Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pt-6 font-cambay">
            <!-- Copyright -->
            <p class="text-gray-400 text-sm order-2 md:order-1" data-aos="fade-right">
                Copyright © Tycoonbd.com, All Right Reserved © {{ date('Y') }}
            </p>

            <!-- Payment Methods -->
            <div class="flex flex-col items-center gap-4 order-1 md:order-2" data-aos="fade-up">
                <span class="text-gray-400 text-sm">We accept:</span>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach ($footerData['payments'] as $payment)
                        <div
                            class="payment-icon bg-white/5 p-2 rounded-lg hover:bg-white/10 transition-all duration-300 border border-white/10">
                            <img src="{{ $payment }}"
                                class="h-6 object-contain filter brightness-0 invert opacity-80 hover:opacity-100 transition-opacity" />
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Additional Links -->
            <div class="flex items-center gap-6 order-3" data-aos="fade-left">
                <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Contact</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .social-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(234, 47, 48, 0.3);
    }

    .payment-icon:hover {
        transform: translateY(-1px);
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .footer-product {
        animation: float 3s ease-in-out infinite;
    }
</style>
