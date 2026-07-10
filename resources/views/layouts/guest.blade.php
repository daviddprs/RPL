<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KopiKu Coffee Shop') - KopiKu</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-coffee-50 font-sans text-coffee-900 antialiased selection:bg-coffee-200 selection:text-coffee-900">
    {{-- Header / Navbar Customer --}}
    <header class="sticky top-0 z-40 border-b border-coffee-200/70 bg-white/80 backdrop-blur-xl shadow-xs">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-coffee-500 to-coffee-700 shadow-md shadow-coffee-500/20">
                    <span class="text-xl">☕</span>
                </div>
                <div>
                    <span class="text-lg font-bold tracking-tight text-coffee-900">KopiKu</span>
                    <span class="block text-[10px] font-semibold uppercase tracking-widest text-coffee-600">Coffee & Eatery</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                {{-- Cart Button --}}
                <a href="{{ route('cart.index') }}"
                   class="relative flex items-center gap-2 rounded-xl border border-coffee-200 bg-white px-4 py-2.5 text-sm font-semibold text-coffee-800 shadow-xs transition-all hover:border-coffee-300 hover:bg-coffee-50">
                    <svg class="h-5 w-5 text-coffee-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span class="hidden sm:inline">Keranjang</span>
                    <span x-data x-show="$store.cart.count > 0"
                          x-text="$store.cart.count"
                          class="flex h-5 min-w-5 items-center justify-center rounded-full bg-coffee-600 px-1.5 text-xs font-bold text-white shadow-xs">
                    </span>
                </a>

                @auth
                    @if(Auth::user()->isStaff())
                        <a href="{{ route('dashboard') }}" class="rounded-xl bg-coffee-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-coffee-900">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('orders.my') }}" class="rounded-xl border border-coffee-200 bg-white px-4 py-2.5 text-sm font-semibold text-coffee-800 shadow-xs transition-all hover:bg-coffee-50">
                            Pesanan Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-xl px-3 py-2.5 text-sm font-medium text-coffee-600 hover:text-red-600">
                                Keluar
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="rounded-xl border border-coffee-200 bg-white px-4 py-2.5 text-sm font-semibold text-coffee-800 shadow-xs transition-all hover:bg-coffee-50">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center justify-between rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800 shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="text-lg">✅</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-600">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
