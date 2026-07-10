<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    {{-- Active Orders (Preparing) --}}
    <div>
        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                <span class="text-base">🔥</span>
            </div>
            <h3 class="text-lg font-bold text-coffee-950">Sedang Disiapkan di Dapur</h3>
            <span class="rounded-full bg-blue-100 px-3 py-0.5 text-xs font-bold text-blue-800">{{ $activeOrders->count() }}</span>
        </div>

        <div class="space-y-3">
            @forelse($activeOrders as $order)
                <div class="rounded-3xl border border-blue-200 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="rounded-xl bg-blue-50 px-3 py-1.5 font-mono text-sm font-bold text-blue-800">
                                {{ $order->queue_number }}
                            </span>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->order_type === 'dine-in' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-coffee-500">{{ $order->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="space-y-2">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-start gap-3 rounded-2xl bg-coffee-50/70 px-3.5 py-2.5">
                                <span class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-lg bg-coffee-600 text-xs font-bold text-white">
                                    {{ $item->quantity }}
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-coffee-950">{{ $item->menu->name }}</p>
                                    @if($item->customization_notes)
                                        <p class="text-xs font-semibold text-orange-700">📝 {{ $item->customization_notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('barista.update-status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="ready">
                            <button type="submit" class="w-full rounded-xl bg-green-600 py-2.5 text-sm font-bold text-white shadow-md shadow-green-600/20 transition-all hover:bg-green-700 active:scale-[0.99]">
                                ✓ Tandai Siap Diambil
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-coffee-200 bg-white py-12 text-center shadow-xs">
                    <span class="text-4xl">☕</span>
                    <p class="mt-2 text-sm font-semibold text-coffee-600">Tidak ada pesanan yang sedang disiapkan</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Ready Orders --}}
    <div>
        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-green-100 text-green-700">
                <span class="text-base">✅</span>
            </div>
            <h3 class="text-lg font-bold text-coffee-950">Siap Diambil</h3>
            <span class="rounded-full bg-green-100 px-3 py-0.5 text-xs font-bold text-green-800">{{ $readyOrders->count() }}</span>
        </div>

        <div class="space-y-3">
            @forelse($readyOrders as $order)
                <div class="rounded-3xl border border-green-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="rounded-xl bg-green-50 px-3 py-1.5 font-mono text-sm font-bold text-green-800">
                                {{ $order->queue_number }}
                            </span>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->order_type === 'dine-in' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-coffee-500">{{ $order->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="mt-3 space-y-1">
                        @foreach($order->orderItems as $item)
                            <p class="text-sm font-bold text-coffee-800">{{ $item->quantity }}x {{ $item->menu->name }}</p>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-coffee-200 bg-white py-12 text-center shadow-xs">
                    <span class="text-4xl">📦</span>
                    <p class="mt-2 text-sm font-semibold text-coffee-600">Tidak ada pesanan siap diambil</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
