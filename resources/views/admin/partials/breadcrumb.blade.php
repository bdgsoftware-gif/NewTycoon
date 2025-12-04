<!-- Breadcrumb -->
@hasSection('breadcrumb')
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard /
                </a>
            </li>
            @yield('breadcrumb')
        </ol>
    </nav>
@endif
