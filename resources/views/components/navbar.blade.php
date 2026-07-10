<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-coffee-200/80 bg-white/90 px-6 backdrop-blur-xl">
    <div>
        <h1 class="text-xl font-bold text-coffee-900">@yield('page-title', 'Dashboard')</h1>
        <p class="text-xs text-coffee-600">@yield('page-subtitle', 'Sistem Manajemen KopiKu')</p>
    </div>

    <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-2 rounded-xl border border-coffee-200 bg-white px-4 py-2 text-xs font-semibold text-coffee-700 shadow-xs transition hover:bg-coffee-50">
            <span>🍽️</span> Menu Pelanggan
        </a>

        <div class="flex items-center gap-2 rounded-xl bg-coffee-100 px-3.5 py-1.5 text-xs font-semibold text-coffee-800">
            <span class="h-2 w-2 rounded-full bg-green-500"></span>
            <span>{{ ucfirst(Auth::user()->role) }} Active</span>
        </div>
    </div>
</header>
