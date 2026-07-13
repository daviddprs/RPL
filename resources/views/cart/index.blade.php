@extends('layouts.guest')

@section('title', 'Keranjang')

@section('content')
<div x-data="cartPage()" class="max-w-3xl mx-auto mb-20 md:mb-0">
    <h1 class="mb-6 text-2xl font-extrabold text-coffee-950">Keranjang Belanja Anda</h1>

    {{-- Empty Cart --}}
    <div x-show="$store.cart.items.length === 0" class="rounded-3xl border border-coffee-200 bg-white py-16 text-center shadow-xs">
        <span class="text-5xl">🛒</span>
        <p class="mt-4 text-base font-semibold text-coffee-700">Keranjang Anda masih kosong</p>
        <a href="{{ route('home') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-coffee-600 px-6 py-3 text-sm font-bold text-white shadow-md shadow-coffee-600/20 hover:bg-coffee-700">
            ← Pilihan Menu KopiKu
        </a>
    </div>

    {{-- Cart Items --}}
    <div x-show="$store.cart.items.length > 0" class="space-y-4">
        <template x-for="(item, index) in $store.cart.items" :key="index">
            <div class="flex items-center gap-4 rounded-2xl border border-coffee-200/80 bg-white p-5 shadow-xs transition-all hover:shadow-md">
                <div class="flex-1">
                    <h3 class="font-bold text-coffee-950" x-text="item.name"></h3>
                    <p class="text-xs italic text-coffee-600" x-show="item.notes" x-text="'📝 ' + item.notes"></p>
                    <p class="mt-1 text-sm font-semibold text-coffee-700" x-text="$store.cart.formatPrice(item.price)"></p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="$store.cart.updateQuantity(index, item.quantity - 1)"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-coffee-200 bg-coffee-50 font-bold text-coffee-800 hover:bg-coffee-100">
                        −
                    </button>
                    <span class="w-8 text-center text-sm font-bold text-coffee-950" x-text="item.quantity"></span>
                    <button @click="$store.cart.updateQuantity(index, item.quantity + 1)"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-coffee-200 bg-coffee-50 font-bold text-coffee-800 hover:bg-coffee-100">
                        +
                    </button>
                </div>
                <div class="text-right">
                    <p class="text-base font-extrabold text-coffee-950" x-text="$store.cart.formatPrice(item.price * item.quantity)"></p>
                    <button @click="$store.cart.removeItem(index)" class="mt-1 text-xs font-semibold text-red-600 hover:underline">Hapus</button>
                </div>
            </div>
        </template>

        {{-- Order Summary --}}
        <div class="rounded-3xl border border-coffee-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="mb-4 text-lg font-bold text-coffee-950">Ringkasan Pembayaran</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-coffee-700">
                    <span>Subtotal</span>
                    <span class="font-semibold" x-text="$store.cart.formatPrice($store.cart.total)"></span>
                </div>
                <hr class="border-coffee-100">
                <div class="flex justify-between text-lg font-extrabold text-coffee-950">
                    <span>Total Keseluruhan</span>
                    <span x-text="$store.cart.formatPrice($store.cart.total)"></span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="mt-6">
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-coffee-700">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2.5">
                    <template x-for="method in paymentMethods" :key="method.value">
                        <button @click="selectedPayment = method.value" type="button"
                                :class="selectedPayment === method.value ? 'border-coffee-600 bg-coffee-600 text-white font-bold shadow-md shadow-coffee-600/20' : 'border-coffee-200 bg-coffee-50/50 text-coffee-800 hover:bg-coffee-100/60'"
                                class="flex items-center gap-2.5 rounded-xl border px-4 py-3 text-xs transition-all">
                            <span x-text="method.icon"></span>
                            <span x-text="method.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Checkout Button --}}
            <form method="POST" action="{{ route('orders.store') }}" @submit="submitOrder($event)">
                @csrf
                <input type="hidden" name="order_type" :value="localStorage.getItem('order_type') || 'dine-in'">
                <input type="hidden" name="payment_method" :value="selectedPayment">
                <input type="hidden" name="cart_items" :value="JSON.stringify($store.cart.items)">

                <button type="submit"
                        class="mt-6 flex w-full items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-coffee-600 to-coffee-700 py-4 text-sm font-bold text-white shadow-lg shadow-coffee-600/25 transition-all hover:brightness-110 active:scale-[0.99]"
                        :disabled="!selectedPayment">
                    <span>Pesan Sekarang</span>
                </button>
            </form>
        </div>

        {{-- Clear Cart --}}
        <div class="text-center">
            <button @click="$store.cart.clear()" type="button" class="text-xs font-semibold text-red-600 hover:underline">
                Kosongkan Semua Isi Keranjang
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cartPage() {
    return {
        selectedPayment: 'qris',
        paymentMethods: [
            { value: 'qris', label: 'QRIS Instant', icon: '📱' },
            { value: 'tunai', label: 'Bayar di Kasir (Tunai)', icon: '💵' },
        ],
        submitOrder(event) {
            if (!this.selectedPayment) {
                event.preventDefault();
                alert('Pilih metode pembayaran terlebih dahulu');
            }
        }
    }
}
</script>
@endpush
@endsection
