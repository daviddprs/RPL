@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Ringkasan performa coffee shop hari ini')

@section('content')
    {{-- Stats Cards --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        {{-- Revenue Today --}}
        <div class="group rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Pendapatan Hari Ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-coffee-950">Rp {{ number_format($stats['total_revenue_today'], 0, ',', '.') }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-green-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
            </div>
        </div>

        {{-- Orders Today --}}
        <div class="group rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Pesanan Hari Ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-coffee-950">{{ $stats['total_orders_today'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="group rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Pesanan Aktif</p>
                    <p class="mt-2 text-2xl font-extrabold text-coffee-950">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-yellow-100 text-yellow-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Menu --}}
        <div class="group rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Total Menu</p>
                    <p class="mt-2 text-2xl font-extrabold text-coffee-950">{{ $stats['total_menus'] }}</p>
                    @if($stats['sold_out_menus'] > 0)
                        <p class="mt-1 text-xs font-semibold text-red-600">{{ $stats['sold_out_menus'] }} menu sold out</p>
                    @endif
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 text-purple-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Staff --}}
        <div class="group rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs transition-all hover:border-coffee-300 hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-coffee-600">Total Staf</p>
                    <p class="mt-2 text-2xl font-extrabold text-coffee-950">{{ $stats['total_staff'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="mb-8 grid grid-cols-1 gap-6 xl:grid-cols-2">
        {{-- Revenue Chart --}}
        <div class="rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs">
            <h3 class="mb-4 text-base font-bold text-coffee-950">Pendapatan 7 Hari Terakhir</h3>
            <canvas id="revenueChart" class="h-64"></canvas>
        </div>

        {{-- Top Menus Chart --}}
        <div class="rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs">
            <h3 class="mb-4 text-base font-bold text-coffee-950">Menu Terlaris</h3>
            <canvas id="topMenuChart" class="h-64"></canvas>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div class="rounded-3xl border border-coffee-200 bg-white p-6 shadow-xs">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-bold text-coffee-950">Pesanan Terbaru</h3>
            <a href="{{ route('kasir.orders') }}" class="text-xs font-bold text-coffee-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-coffee-100 text-left text-xs font-bold uppercase tracking-widest text-coffee-600">
                        <th class="pb-3 pr-4">No. Antrean</th>
                        <th class="pb-3 pr-4">Pelanggan</th>
                        <th class="pb-3 pr-4">Tipe</th>
                        <th class="pb-3 pr-4">Total</th>
                        <th class="pb-3 pr-4">Status</th>
                        <th class="pb-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-100">
                    @forelse($recentOrders as $order)
                        <tr class="text-sm">
                            <td class="py-3 pr-4 font-mono font-bold text-coffee-800">{{ $order->queue_number }}</td>
                            <td class="py-3 pr-4 font-semibold text-coffee-950">{{ $order->user ? $order->user->name : 'Guest' }}</td>
                            <td class="py-3 pr-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $order->order_type === 'dine-in' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                    {{ ucfirst($order->order_type) }}
                                </span>
                            </td>
                            <td class="py-3 pr-4 font-bold text-coffee-900">{{ $order->formatted_total }}</td>
                            <td class="py-3 pr-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-bold
                                    @switch($order->status)
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('preparing') bg-blue-100 text-blue-800 @break
                                        @case('ready') bg-green-100 text-green-800 @break
                                        @case('completed') bg-gray-100 text-gray-800 @break
                                    @endswitch">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="py-3 text-xs text-coffee-500">{{ $order->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-coffee-500">Belum ada pesanan hari ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueChart->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($revenueChart->pluck('total')) !!},
                borderColor: '#96602e',
                backgroundColor: 'rgba(150, 96, 46, 0.1)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#96602e',
                pointBorderColor: '#96602e',
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            },
            scales: {
                x: { grid: { color: 'rgba(116, 74, 36, 0.08)' }, ticks: { color: '#53351a' } },
                y: {
                    grid: { color: 'rgba(116, 74, 36, 0.08)' },
                    ticks: {
                        color: '#53351a',
                        callback: (val) => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                    }
                }
            }
        }
    });

    // Top Menu Chart
    const topMenuCtx = document.getElementById('topMenuChart').getContext('2d');
    new Chart(topMenuCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topMenus->pluck('name')) !!},
            datasets: [{
                label: 'Terjual',
                data: {!! json_encode($topMenus->pluck('total_sold')) !!},
                backgroundColor: [
                    'rgba(184, 122, 61, 0.85)',
                    'rgba(150, 96, 46, 0.85)',
                    'rgba(116, 74, 36, 0.85)',
                    'rgba(83, 53, 26, 0.85)',
                    'rgba(61, 38, 21, 0.85)',
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(116, 74, 36, 0.08)' }, ticks: { color: '#53351a' } },
                y: { grid: { display: false }, ticks: { color: '#3d2615', font: { weight: 'bold' } } }
            }
        }
    });
</script>
@endpush
