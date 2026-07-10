@extends('layouts.app')

@section('title', 'Pesanan Dapur - Barista')
@section('page-title', 'Kitchen Display')
@section('page-subtitle', 'Pesanan yang perlu disiapkan')

@section('content')
    @include('dashboard.barista', ['activeOrders' => $activeOrders, 'readyOrders' => $readyOrders])
@endsection
