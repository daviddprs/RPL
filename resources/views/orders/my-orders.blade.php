@extends('layouts.guest')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-3xl mx-auto mb-20 md:mb-0">
    <h1 class="mb-6 text-2xl font-extrabold text-coffee-950">Riwayat Pesanan Saya</h1>

    @if($orders->isEmpty())
        <div class="rounded-3xl border border-coffee-200 bg-white py-16 text-center shadow-xs">
            <span class="text-5xl">📋</span>
            <p class="mt-4 font-semibold text-coffee-700">Anda belum memiliki riwayat pesanan</p>
            <a href="{{ route('home') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-coffee-600 px-6 py-3 text-sm font-bold text-white shadow-md shadow-coffee-600/20 hover:bg-coffee-700">
                Mulai Pesan KopiKu →
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block rounded-2xl border border-coffee-200/80 bg-white p-5 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-coffee-100 font-mono text-base font-bold text-coffee-800">
                                {{ $order->queue_number }}
                            </div>
                            <div>
                                <p class="font-bold text-coffee-950">{{ $order->orderItems->count() }} item dipesan</p>
                                <p class="text-xs text-coffee-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="rounded-full px-3 py-1 text-xs font-bold
                                @switch($order->status)
                                    @case('pending') bg-yellow-100 text-yellow-800 @break
                                    @case('preparing') bg-blue-100 text-blue-800 @break
                                    @case('ready') bg-green-100 text-green-800 @break
                                    @case('completed') bg-gray-100 text-gray-800 @break
                                @endswitch">
                                {{ $order->status_label }}
                            </span>
                            <p class="mt-1 text-sm font-extrabold text-coffee-950">{{ $order->formatted_total }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
