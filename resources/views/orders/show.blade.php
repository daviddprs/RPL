@extends('layouts.guest')

@section('title', 'Pesanan #' . $order->queue_number)

@section('content')
<div class="max-w-2xl mx-auto mb-20 md:mb-0">
    {{-- Order Status Header --}}
    <div class="mb-6 rounded-3xl border border-coffee-200 bg-white p-8 text-center shadow-sm">
        <div class="mb-3 inline-flex h-16 w-16 items-center justify-center rounded-2xl
            @switch($order->status)
                @case('pending') bg-yellow-100 text-yellow-800 @break
                @case('preparing') bg-blue-100 text-blue-800 @break
                @case('ready') bg-green-100 text-green-800 @break
                @case('completed') bg-gray-100 text-gray-800 @break
            @endswitch">
            <span class="text-3xl">
                @switch($order->status)
                    @case('pending') ⏳ @break
                    @case('preparing') 🔥 @break
                    @case('ready') ✅ @break
                    @case('completed') 🎉 @break
                @endswitch
            </span>
        </div>
        <h1 class="text-2xl font-extrabold text-coffee-950">{{ $order->status_label }}</h1>
        <p class="mt-2 font-mono text-4xl font-black text-coffee-600">{{ $order->queue_number }}</p>
        <p class="mt-1 text-xs font-medium text-coffee-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>

    {{-- Status Timeline --}}
    <div class="mb-6 rounded-3xl border border-coffee-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-bold text-coffee-950">Alur Status Pesanan</h3>
        <div class="relative">
            @php
                $steps = [
                    ['status' => 'pending', 'label' => 'Menunggu Bayar', 'icon' => '💳'],
                    ['status' => 'preparing', 'label' => 'Sedang Disiapkan', 'icon' => '☕'],
                    ['status' => 'ready', 'label' => 'Siap Diambil', 'icon' => '🔔'],
                    ['status' => 'completed', 'label' => 'Selesai', 'icon' => '✅'],
                ];
                $currentIndex = array_search($order->status, array_column($steps, 'status'));
            @endphp

            <div class="flex justify-between">
                @foreach($steps as $index => $step)
                    <div class="flex flex-col items-center relative z-10" style="width: 25%">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full text-lg font-bold
                            {{ $index <= $currentIndex ? 'bg-coffee-600 text-white shadow-md shadow-coffee-600/20' : 'bg-coffee-100 text-coffee-400' }}">
                            {{ $step['icon'] }}
                        </div>
                        <p class="mt-2 text-center text-[11px] font-semibold {{ $index <= $currentIndex ? 'text-coffee-900' : 'text-coffee-400' }}">
                            {{ $step['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>
            {{-- Progress Line --}}
            <div class="absolute top-5 left-[12.5%] right-[12.5%] h-1 bg-coffee-100">
                <div class="h-full bg-coffee-600 transition-all duration-500" style="width: {{ $currentIndex === 0 ? 0 : ($currentIndex / 3 * 100) }}%"></div>
            </div>
        </div>
    </div>

    {{-- Order Details --}}
    <div class="mb-6 rounded-3xl border border-coffee-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-bold text-coffee-950">Detail Pesanan</h3>

        <div class="space-y-3">
            @foreach($order->orderItems as $item)
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-sm font-bold text-coffee-900">{{ $item->quantity }}x {{ $item->menu->name }}</span>
                        @if($item->customization_notes)
                            <p class="text-xs italic text-coffee-600">📝 {{ $item->customization_notes }}</p>
                        @endif
                    </div>
                    <span class="text-sm font-semibold text-coffee-800">{{ $item->formatted_subtotal }}</span>
                </div>
            @endforeach
        </div>

        <hr class="my-4 border-coffee-100">

        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-coffee-700">
                <span>Tipe Layanan</span>
                <span class="rounded-full px-3 py-0.5 text-xs font-bold {{ $order->order_type === 'dine-in' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                    {{ ucfirst($order->order_type) }}
                </span>
            </div>
            <div class="flex justify-between text-coffee-700">
                <span>Metode Pembayaran</span>
                <span class="font-bold text-coffee-900 uppercase">{{ $order->payment_method }}</span>
            </div>
            <div class="flex justify-between text-coffee-700">
                <span>Status Pembayaran</span>
                <span class="rounded-full px-3 py-0.5 text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </div>
            <hr class="border-coffee-100">
            <div class="flex justify-between text-lg font-extrabold text-coffee-950">
                <span>Total Bayar</span>
                <span>{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3">
        <a href="{{ route('home') }}" class="flex-1 rounded-xl border border-coffee-200 bg-white py-3 text-center text-sm font-bold text-coffee-700 shadow-xs hover:bg-coffee-50">
            ← Pesan Lagi
        </a>
        @auth
            <a href="{{ route('orders.my') }}" class="flex-1 rounded-xl bg-coffee-700 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-coffee-800">
                Pesanan Saya
            </a>
        @endauth
    </div>
</div>
@endsection
