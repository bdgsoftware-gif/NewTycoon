@if (session()->has('flash_message'))
    @php
        $flash = session('flash_message');
        $type = $flash['type'] ?? 'success';
        $duration = $flash['duration'] ?? 5000;

        $typeClasses = [
            'success' => [
                'bg' => 'bg-green-50',
                'border' => 'border-green-200',
                'text' => 'text-green-800',
                'progress' => 'bg-green-500',
                'icon' =>
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            ],
            'error' => [
                'bg' => 'bg-red-50',
                'border' => 'border-red-200',
                'text' => 'text-red-800',
                'progress' => 'bg-red-500',
                'icon' =>
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            ],
            'warning' => [
                'bg' => 'bg-yellow-50',
                'border' => 'border-yellow-200',
                'text' => 'text-yellow-800',
                'progress' => 'bg-yellow-500',
                'icon' =>
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.312 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            ],
            'info' => [
                'bg' => 'bg-blue-50',
                'border' => 'border-blue-200',
                'text' => 'text-blue-800',
                'progress' => 'bg-blue-500',
                'icon' =>
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            ],
        ];

        $config = $typeClasses[$type] ?? $typeClasses['info'];
    @endphp

    <div id="server-flash-{{ $type }}"
        class="flash-message-server {{ $config['bg'] }} {{ $config['border'] }} {{ $config['text'] }} border rounded-lg shadow-lg overflow-hidden pointer-events-auto fixed top-4 right-4 z-[9998] w-96 max-w-[calc(100vw-2rem)] opacity-0 translate-x-full transition-all duration-300">
        <div class="flex items-start p-4">
            <div class="flex-shrink-0 mt-0.5">
                {!! $config['icon'] !!}
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold">{{ $flash['message'] }}</p>
                @if (!empty($flash['description']))
                    <p class="text-sm mt-1 opacity-75">{{ $flash['description'] }}</p>
                @endif
            </div>
            <button onclick="this.closest('.flash-message-server').remove()"
                class="ml-4 flex-shrink-0 opacity-50 hover:opacity-100 focus:outline-none transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="h-1 w-full bg-gray-200 bg-opacity-50">
            <div class="h-full transition-all duration-linear {{ $config['progress'] }} server-flash-progress"
                style="width: 100%"></div>
        </div>
    </div>

    <script>
        // Animate in server flash message
        document.addEventListener('DOMContentLoaded', function() {
            const flashElement = document.getElementById('server-flash-{{ $type }}');
            if (flashElement) {
                // Show with animation
                setTimeout(() => {
                    flashElement.classList.remove('opacity-0', 'translate-x-full');
                    flashElement.classList.add('opacity-100', 'translate-x-0');
                }, 100);

                // Start progress bar
                const progressBar = flashElement.querySelector('.server-flash-progress');
                const duration = {{ $duration }};
                const interval = 50;
                const steps = duration / interval;
                const stepSize = 100 / steps;
                let width = 100;
                let timer = null;
                let isPaused = false;

                // Start progress
                timer = setInterval(() => {
                    if (!isPaused) {
                        width -= stepSize;
                        if (progressBar) {
                            progressBar.style.width = width + '%';
                        }

                        if (width <= 0) {
                            clearInterval(timer);
                            // Animate out
                            flashElement.classList.remove('opacity-100', 'translate-x-0');
                            flashElement.classList.add('opacity-0', 'translate-x-full');
                            setTimeout(() => flashElement.remove(), 300);
                        }
                    }
                }, interval);

                // Pause on hover
                flashElement.addEventListener('mouseenter', () => {
                    isPaused = true;
                });

                flashElement.addEventListener('mouseleave', () => {
                    isPaused = false;
                });

                // Auto remove after duration
                setTimeout(() => {
                    if (flashElement.parentElement) {
                        flashElement.classList.remove('opacity-100', 'translate-x-0');
                        flashElement.classList.add('opacity-0', 'translate-x-full');
                        setTimeout(() => flashElement.remove(), 300);
                    }
                }, duration);
            }
        });
    </script>
@endif
