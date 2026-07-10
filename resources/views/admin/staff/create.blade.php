@extends('layouts.app')

@section('title', isset($staff) ? 'Edit Staf' : 'Tambah Staf')
@section('page-title', isset($staff) ? 'Edit Staf' : 'Tambah Staf Baru')

@section('content')
<div class="max-w-lg rounded-3xl border border-coffee-200 bg-white p-6 shadow-sm sm:p-8">
    <form method="POST" action="{{ isset($staff) ? route('admin.staff.update', $staff) : route('admin.staff.store') }}" class="space-y-5">
        @csrf
        @if(isset($staff)) @method('PUT') @endif

        @if($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3">
                @foreach($errors->all() as $error)
                    <p class="text-sm font-semibold text-red-800">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>
            <label for="name" class="mb-1.5 block text-sm font-bold text-coffee-900">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $staff->name ?? '') }}" required
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        <div>
            <label for="email" class="mb-1.5 block text-sm font-bold text-coffee-900">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $staff->email ?? '') }}" required
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        <div>
            <label for="role" class="mb-1.5 block text-sm font-bold text-coffee-900">Role</label>
            <select name="role" id="role" required
                    class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
                <option value="kasir" {{ old('role', $staff->role ?? '') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="barista" {{ old('role', $staff->role ?? '') === 'barista' ? 'selected' : '' }}>Barista</option>
            </select>
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-bold text-coffee-900">
                Password {{ isset($staff) ? '(kosongkan jika tidak ingin mengubah)' : '' }}
            </label>
            <input type="password" name="password" id="password" {{ isset($staff) ? '' : 'required' }}
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-bold text-coffee-900">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.staff.index') }}" class="flex-1 rounded-xl border border-coffee-200 py-3 text-center text-sm font-bold text-coffee-700 hover:bg-coffee-50">Batal</a>
            <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 py-3 text-sm font-bold text-white shadow-md shadow-coffee-600/20 hover:brightness-110">
                {{ isset($staff) ? 'Perbarui Data' : 'Simpan Data' }}
            </button>
        </div>
    </form>
</div>
@endsection
