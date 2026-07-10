@extends('layouts.auth')

@section('title', 'Daftar Akun Pelanggan')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-coffee-900">Buat Akun Pelanggan</h1>
<p class="mb-6 text-sm text-coffee-600">Daftarkan akun baru untuk mempermudah pesanan Anda</p>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="mb-1.5 block text-sm font-semibold text-coffee-800">Nama Lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
               class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-900 placeholder-coffee-400 focus:border-coffee-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-500/10">
    </div>

    <div>
        <label for="email" class="mb-1.5 block text-sm font-semibold text-coffee-800">Alamat Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
               class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-900 placeholder-coffee-400 focus:border-coffee-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-500/10">
    </div>

    <div>
        <label for="password" class="mb-1.5 block text-sm font-semibold text-coffee-800">Kata Sandi</label>
        <input id="password" type="password" name="password" required
               class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-900 placeholder-coffee-400 focus:border-coffee-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-500/10">
    </div>

    <div>
        <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-coffee-800">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
               class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-900 placeholder-coffee-400 focus:border-coffee-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-500/10">
    </div>

    <button type="submit"
            class="w-full rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 py-3.5 text-sm font-bold text-white shadow-lg shadow-coffee-600/20 transition-all hover:brightness-110 active:scale-[0.99]">
        Daftar Sekarang
    </button>
</form>

<div class="mt-6 border-t border-coffee-100 pt-6 text-center text-sm text-coffee-600">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="font-bold text-coffee-700 hover:underline">Masuk ke sini</a>
</div>
@endsection
