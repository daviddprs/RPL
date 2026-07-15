@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')
@section('page-subtitle', 'Verifikasi pembayaran & kelola antrean pesanan')

@section('content')
{{-- Stats --}}
<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="rounded-3xl border border-coffee-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Menunggu Bayar</p>
        <p class="mt-2 text-2xl font-extrabold text-yellow-700">{{ $pendingOrders->where('payment_status', 'unpaid')->count() }}</p>
    </div>
    <div class="rounded-3xl border border-coffee-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Sedang Diproses</p>
        <p class="mt-2 text-2xl font-extrabold text-blue-700">{{ $pendingOrders->where('status', 'preparing')->count() }}</p>
    </div>
    <div class="rounded-3xl border border-coffee-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Selesai Hari Ini</p>
        <p class="mt-2 text-2xl font-extrabold text-green-700">{{ $todayCompleted ?? 0 }}</p>
    </div>
</div>

{{-- Orders List --}}
<div class="space-y-4">
    <h3 class="text-lg font-bold text-coffee-950">Daftar Pesanan Aktif</h3>

    @forelse($pendingOrders as $order)
        <div class="rounded-3xl border border-coffee-200/80 bg-white p-5 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md"
             x-data="{ expanded: false }">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-coffee-100 font-mono text-lg font-bold text-coffee-800">
                        {{ $order->queue_number }}
                    </div>
                    <div>
                        <p class="font-bold text-coffee-950">{{ $order->user ? $order->user->name : 'Guest' }}</p>
                        <div class="flex items-center gap-2 text-xs text-coffee-500">
                            <span class="rounded-full px-2.5 py-0.5 font-bold {{ $order->order_type === 'dine-in' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                {{ ucfirst($order->order_type) }}
                            </span>
                            <span>•</span>
                            <span>{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="rounded-full px-3 py-1 text-xs font-bold
                        @switch($order->status)
                            @case('pending') bg-yellow-100 text-yellow-800 @break
                            @case('preparing') bg-blue-100 text-blue-800 @break
                            @case('ready') bg-green-100 text-green-800 @break
                        @endswitch">
                        {{ $order->status_label }}
                    </span>
                    <span class="font-extrabold text-coffee-950">{{ $order->formatted_total }}</span>
                    <button @click="expanded = !expanded" class="rounded-xl border border-coffee-200 bg-coffee-50 p-2 text-coffee-700 hover:bg-coffee-100">
                        <svg class="h-4 w-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Expanded Details --}}
            <div x-show="expanded" x-transition class="mt-4 border-t border-coffee-100 pt-4">
                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <span class="font-bold text-coffee-900">{{ $item->quantity }}x {{ $item->menu->name }}</span>
                                @if($item->customization_notes)
                                    <p class="text-xs italic text-coffee-600">{{ $item->customization_notes }}</p>
                                @endif
                            </div>
                            <span class="font-semibold text-coffee-800">{{ $item->formatted_subtotal }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div class="mt-4 flex flex-wrap gap-2">
                    @if($order->payment_status === 'unpaid')
                        <form method="POST" action="{{ route('kasir.verify-payment', $order) }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-xs font-bold text-white transition-all hover:bg-green-700">
                                ✓ Verifikasi Pembayaran
                            </button>
                        </form>
                    @endif

                    @if($order->status === 'pending' && $order->payment_status === 'paid')
                        <form method="POST" action="{{ route('kasir.update-status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="preparing">
                            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white transition-all hover:bg-blue-700">
                                🔥 Kirim ke Dapur
                            </button>
                        </form>
                    @endif

                    @if($order->status === 'ready')
                        {{-- Form Selesai & Cetak Struk --}}
                        <form id="form-selesai-{{ $order->id }}" method="POST" action="{{ route('kasir.update-status', $order) }}">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="button" onclick="selesaiDanCetak(event, {{ $order->id }})" class="rounded-xl bg-coffee-700 px-4 py-2 text-xs font-bold text-white transition-all hover:bg-coffee-800">
                                ✓ Selesai & Cetak Struk
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="rounded-3xl border border-coffee-200 bg-white py-16 text-center shadow-xs">
            <span class="text-4xl">☕</span>
            <p class="mt-3 font-semibold text-coffee-600">Belum ada pesanan aktif</p>
        </div>
    @endforelse
</div>

{{-- Area Struk Tersembunyi untuk Cetak --}}
<div id="print-receipt-hidden" class="hidden"></div>

<style>
@media print {
    /* Sembunyikan seluruh UI web */
    body * { 
        visibility: hidden; 
        background: white !important; 
    }
    
    /* Hilangkan URL browser dan tanggal bawaan */
    @page { 
        margin: 0; 
        size: auto; 
    }
    
    /* Tampilkan dan paksa block area struk dengan font thermal */
    #print-receipt-hidden {
        visibility: visible;
        display: block !important;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 75mm;
        padding: 5px !important;
        color: black !important;
        font-family: 'Courier New', Courier, monospace !important;
    }

    #print-receipt-hidden * {
        visibility: visible;
    }
}
</style>

<script>
function selesaiDanCetak(event, orderId) {
    event.preventDefault(); // Tahan submit form
    
    const form = document.getElementById('form-selesai-' + orderId);
    
    // Ambil data pesanan dari Blade ke JS
    const ordersData = @json($pendingOrders);
    const orders = Array.isArray(ordersData) ? ordersData : (ordersData.data || []);
    const order = orders.find(o => o.id === orderId);

    if (order) {
        let itemHtml = '';
        
        // Handle penamaan relasi JSON Laravel (bisa order_items atau orderItems)
        const items = order.order_items || order.orderItems || [];
        
        items.forEach(item => {
            const menuName = item.menu ? item.menu.name : 'Item';
            itemHtml += `
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 14px;">
                    <span>${item.quantity}x ${menuName}</span>
                    <span>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</span>
                </div>
                ${item.customization_notes ? `<div style="font-size: 11px; font-style: italic; color: #666; margin-bottom: 6px;">📝 ${item.customization_notes}</div>` : ''}
            `;
        });

        const receiptHtml = `
            <div style="text-align: center; margin-bottom: 15px;">
                <h2 style="margin:0; font-size: 22px; text-transform: uppercase; font-weight: 900; letter-spacing: 2px;">KopiKu</h2>
                <p style="margin: 4px 0 0 0; font-size: 12px;">Nota: #${order.queue_number || order.id}</p>
                <p style="margin: 0; font-size: 12px;">${new Date().toLocaleString('id-ID')}</p>
            </div>
            
            <div style="border-top: 2px dashed #000; margin-bottom: 12px;"></div>
            
            ${itemHtml}
            
            <div style="border-top: 2px dashed #000; margin: 12px 0;"></div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 12px;">
                <span>Layanan:</span>
                <span style="text-transform: uppercase; font-weight: bold;">${order.order_type}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; margin-top: 8px;">
                <span>TOTAL</span>
                <span>Rp ${Number(order.total_price).toLocaleString('id-ID')}</span>
            </div>
            
            <div style="text-align: center; margin-top: 20px; font-size: 11px;">
                Terima kasih atas kunjungan Anda!
            </div>
        `;
        
        // Masukkan HTML ke elemen tersembunyi
        document.getElementById('print-receipt-hidden').innerHTML = receiptHtml;
        
        // Jika print dialog ditutup (baik klik print atau cancel), jalankan submit form selesai
        window.onafterprint = function() {
            form.submit();
            window.onafterprint = null;
        };
        
        // Buka dialog print
        window.print();
        
    } else {
        // Fallback jika data gagal dibaca
        form.submit();
    }
}
</script>
@endsection