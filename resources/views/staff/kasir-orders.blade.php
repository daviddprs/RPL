@extends('layouts.app')

@section('title', 'Pesanan Masuk - Kasir')
@section('page-title', 'Pesanan Masuk')
@section('page-subtitle', 'Kelola pesanan pelanggan')

@section('content')
    @php
        $todayCompleted = \App\Models\Order::whereDate('created_at', now()->toDateString())->where('status', 'completed')->count();
        $pendingOrders = $orders;
    @endphp
    @include('dashboard.kasir', compact('pendingOrders', 'todayCompleted'))
@endsection
