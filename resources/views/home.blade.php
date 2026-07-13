@extends('layouts.guest')

@section('title', 'Menu')

@section('content')
    {{-- Hero Section --}}
    <div class="mb-10 overflow-hidden rounded-3xl border border-coffee-200/80 bg-gradient-to-br from-amber-50 via-coffee-100/60 to-white p-8 shadow-sm md:p-12 relative">
        <div class="absolute inset-0 opacity-40 pointer-events-none">
            <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-amber-200/50 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-orange-100/60 blur-3xl"></div>
        </div>
        <div class="relative z-10">
            <span class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-coffee-100 px-3.5 py-1 text-xs font-bold uppercase tracking-widest text-coffee-800 shadow-2xs">
                ☕ Fresh & Artisanal Coffee
            </span>
            <h1 class="mb-3 text-3xl font-extrabold tracking-tight text-coffee-950 md:text-5xl">
                Selamat Datang di <span class="text-coffee-600">KopiKu</span>
            </h1>
            <p class="max-w-xl text-sm leading-relaxed text-coffee-700 md:text-base">
                Nikmati perpaduan biji kopi nusantara terbaik serta hidangan lezat pilihan kami. Pesan langsung dari meja Anda untuk Dine-in atau Takeaway dengan mudah!
            </p>
        </div>
    </div>

    {{-- Order Type Selection --}}
    <div class="mb-8" x-data="{ orderType: localStorage.getItem('order_type') || 'dine-in' }" x-init="$watch('orderType', val => localStorage.setItem('order_type', val))">
        <p class="mb-2.5 text-xs font-bold uppercase tracking-widest text-coffee-600">Pilih Tipe Layanan:</p>
        <div class="flex flex-wrap gap-3">
            <button @click="orderType = 'dine-in'"
                    :class="orderType === 'dine-in' ? 'border-coffee-600 bg-coffee-600 text-white shadow-md shadow-coffee-600/20 font-bold' : 'border-coffee-200 bg-white text-coffee-700 hover:border-coffee-300 hover:bg-coffee-50'"
                    class="flex items-center gap-2.5 rounded-2xl border px-6 py-3.5 text-sm transition-all">
                <span class="text-lg">🍽️</span> Makan di Tempat (Dine-in)
            </button>
            <button @click="orderType = 'takeaway'"
                    :class="orderType === 'takeaway' ? 'border-coffee-600 bg-coffee-600 text-white shadow-md shadow-coffee-600/20 font-bold' : 'border-coffee-200 bg-white text-coffee-700 hover:border-coffee-300 hover:bg-coffee-50'"
                    class="flex items-center gap-2.5 rounded-2xl border px-6 py-3.5 text-sm transition-all">
                <span class="text-lg">🥡</span> Bawa Pulang (Takeaway)
            </button>
        </div>
    </div>

    {{-- Category Filter --}}
    <div class="mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ route('home') }}"
           class="rounded-xl px-4 py-2.5 text-sm font-semibold transition-all {{ !request('category') || request('category') === 'all' ? 'bg-coffee-700 text-white shadow-sm' : 'border border-coffee-200 bg-white text-coffee-700 hover:bg-coffee-50' }}">
            Semua Menu
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->slug]) }}"
               class="rounded-xl px-4 py-2.5 text-sm font-semibold transition-all {{ request('category') === $category->slug ? 'bg-coffee-700 text-white shadow-sm' : 'border border-coffee-200 bg-white text-coffee-700 hover:bg-coffee-50' }}">
                {{ $category->name }}
                <span class="ml-1 text-xs opacity-75">({{ $category->menus_count }})</span>
            </a>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="mb-8">
        <form method="GET" action="{{ route('home') }}" class="relative max-w-lg">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <svg class="h-5 w-5 text-coffee-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kopi, camilan, atau minuman..."
                   class="w-full rounded-2xl border border-coffee-200 bg-white py-3.5 pl-11 pr-4 text-sm text-coffee-900 placeholder-coffee-400 shadow-2xs transition-all focus:border-coffee-600 focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </form>
    </div>

    {{-- Menu Grid --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-20 md:mb-0">
        @forelse($menus as $menu)
            <div class="group flex flex-col rounded-3xl border border-coffee-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-coffee-300 hover:shadow-lg overflow-hidden"
                 x-data="{ showModal: false, notes: '' }">
                {{-- Image --}}
                <div class="aspect-[4/3] bg-coffee-100 relative overflow-hidden">
                    @if($menu->image_path)
                        <img src="{{ Str::startsWith($menu->image_path, ['http://', 'https://']) ? $menu->image_path : asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-coffee-100 to-amber-100 text-coffee-400">
                            <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 13.5V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v7.5" />
                            </svg>
                        </div>
                    @endif
                    {{-- Category Badge --}}
                    <div class="absolute top-3 left-3">
                        <span class="rounded-xl bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-coffee-800 shadow-xs backdrop-blur-md">
                            {{ $menu->category->name }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex flex-1 flex-col justify-between p-5">
                    <div>
                        <h3 class="mb-1 text-base font-bold text-coffee-950 group-hover:text-coffee-600 transition-colors">{{ $menu->name }}</h3>
                        <p class="mb-4 text-xs leading-relaxed text-coffee-600 line-clamp-2">{{ $menu->description }}</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-coffee-100 pt-4">
                        <span class="text-lg font-extrabold text-coffee-900">{{ $menu->formatted_price }}</span>
                        <button @click="showModal = true"
                                class="flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 px-4 py-2 text-xs font-bold text-white shadow-md shadow-coffee-600/20 transition-all hover:brightness-110 active:scale-95">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Pesan
                        </button>
                    </div>
                </div>

                {{-- Add to Cart Modal (Light Theme) --}}
                <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs" @click.self="showModal = false">
                    <div x-show="showModal" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         class="w-full max-w-sm rounded-3xl border border-coffee-200 bg-white p-6 shadow-2xl">
                        <h3 class="text-lg font-bold text-coffee-950">{{ $menu->name }}</h3>
                        <p class="mt-1 text-base font-extrabold text-coffee-700">{{ $menu->formatted_price }}</p>
                        <p class="mt-2 text-xs text-coffee-600">{{ $menu->description }}</p>

                        {{-- Customization --}}
                        <div class="mt-4">
                            <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-coffee-700">Catatan Kustomisasi</label>
                            <textarea x-model="notes" rows="2" placeholder="Contoh: less sugar, extra shot, no ice..."
                                      class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-3.5 py-2.5 text-sm text-coffee-900 placeholder-coffee-400 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10"></textarea>
                        </div>


                        <div class="mt-6 flex gap-3">
                            <button @click="showModal = false" class="flex-1 rounded-xl border border-coffee-200 py-2.5 text-sm font-semibold text-coffee-700 hover:bg-coffee-50">
                                Batal
                            </button>
                            <button @click="$store.cart.addItem({ id: {{ $menu->id }}, name: '{{ $menu->name }}', price: {{ $menu->price }}, notes: notes, image: '{{ $menu->image_path }}' }); showModal = false; notes = '';"
                                    class="flex-1 rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 py-2.5 text-sm font-bold text-white shadow-lg shadow-coffee-600/20 transition-all hover:brightness-110">
                                + Ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-coffee-200 bg-white py-16 text-center shadow-xs">
                <span class="text-4xl">🔍</span>
                <p class="mt-3 text-sm font-semibold text-coffee-600">Menu tidak ditemukan</p>
            </div>
        @endforelse
    </div>
@endsection
