<div class="flash-messages-container fixed top-4 right-4 z-[9999] space-y-3 w-96 pointer-events-none"></div>

@if (session()->has('flash_message'))
    @php($flash = session('flash_message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.flash) {
                window.flash(
                    @json($flash['message']),
                    @json($flash['type'] ?? 'success'),
                    @json($flash['duration'] ?? 5000),
                    @json($flash['description'] ?? '')
                );
            }
        });
    </script>
@endif
