<aside class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-coffee-200/80 bg-white shadow-sm">
    {{-- Brand --}}
    <div class="flex h-16 items-center gap-3 border-b border-coffee-100 px-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-coffee-500 to-coffee-700 shadow-md shadow-coffee-500/20">
            <span class="text-xl">☕</span>
        </div>
        <div>
            <span class="text-lg font-bold tracking-tight text-coffee-900">KopiKu</span>
            <span class="block text-[10px] font-semibold uppercase tracking-widest text-coffee-600">POS & Management</span>
        </div>
    </div>

    {{-- User Badge --}}
    <div class="border-b border-coffee-100 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-coffee-100 font-bold text-coffee-800">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-coffee-900">{{ Auth::user()->name }}</p>
                <span class="inline-block rounded-full bg-coffee-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-coffee-700">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-1 space-y-1 px-3 py-4">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-coffee-500/10 text-coffee-700 font-semibold shadow-xs' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            Ringkasan
        </a>

        @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
            <a href="{{ route('kasir.orders') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('kasir.*') ? 'bg-coffee-500/10 text-coffee-700 font-semibold shadow-xs' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
                Pesanan Masuk (Kasir)
            </a>
        @endif

        @if(Auth::user()->isAdmin() || Auth::user()->isBarista())
            <a href="{{ route('barista.orders') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('barista.*') ? 'bg-coffee-500/10 text-coffee-700 font-semibold shadow-xs' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                </svg>
                Dapur / Barista
            </a>
        @endif

        @if(Auth::user()->isAdmin())
            <div class="pt-4 pb-1">
                <p class="px-4 text-[11px] font-bold uppercase tracking-wider text-coffee-400">Admin Manajemen</p>
            </div>
            <a href="{{ route('admin.menus.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('admin.menus.*') ? 'bg-coffee-500/10 text-coffee-700 font-semibold' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Kelola Menu
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-coffee-500/10 text-coffee-700 font-semibold' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                </svg>
                Kelola Kategori
            </a>
            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-coffee-500/10 text-coffee-700 font-semibold' : 'text-coffee-600 hover:bg-coffee-50 hover:text-coffee-900' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Kelola Staf
            </a>
        @endif
    </nav>

    {{-- Bottom Links --}}
    <div class="border-t border-coffee-100 p-4">
        <a href="{{ route('home') }}" class="mb-2 flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-coffee-600 transition-all hover:bg-coffee-50 hover:text-coffee-900">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Lihat Halaman Menu
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-red-600 transition-all hover:bg-red-50">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V17.25m6-12L21.75 12m0 0l-4.5 4.5M21.75 12H9" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
