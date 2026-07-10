@extends('layouts.app')

@section('title', isset($menu) ? 'Edit Menu' : 'Tambah Menu')
@section('page-title', isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru')

@section('content')
<div class="max-w-2xl rounded-3xl border border-coffee-200 bg-white p-6 shadow-sm sm:p-8">
    <form method="POST" action="{{ isset($menu) ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($menu)) @method('PUT') @endif

        @if($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3">
                @foreach($errors->all() as $error)
                    <p class="text-sm font-semibold text-red-800">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Name --}}
        <div>
            <label for="name" class="mb-1.5 block text-sm font-bold text-coffee-900">Nama Menu</label>
            <input type="text" name="name" id="name" value="{{ old('name', $menu->name ?? '') }}" required
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 placeholder-coffee-400 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        {{-- Category --}}
        <div>
            <label for="category_id" class="mb-1.5 block text-sm font-bold text-coffee-900">Kategori</label>
            <select name="category_id" id="category_id" required
                    class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="mb-1.5 block text-sm font-bold text-coffee-900">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 placeholder-coffee-400 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">{{ old('description', $menu->description ?? '') }}</textarea>
        </div>

        {{-- Price --}}
        <div>
            <label for="price" class="mb-1.5 block text-sm font-bold text-coffee-900">Harga (Rp)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $menu->price ?? '') }}" required min="0" step="500"
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-3 text-sm text-coffee-950 placeholder-coffee-400 focus:border-coffee-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-coffee-600/10">
        </div>

        {{-- Image --}}
        <div>
            <label class="mb-1.5 block text-sm font-bold text-coffee-900">Foto Menu</label>
            @if(isset($menu) && $menu->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="h-32 w-32 rounded-xl object-cover border border-coffee-200">
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full rounded-xl border border-coffee-200 bg-coffee-50/50 px-4 py-2.5 text-sm text-coffee-950 file:mr-4 file:rounded-lg file:border-0 file:bg-coffee-600 file:px-3 file:py-1.5 file:text-sm file:font-bold file:text-white">
        </div>

        {{-- Sold Out Toggle --}}
        @if(isset($menu))
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_sold_out" id="is_sold_out" value="1" {{ old('is_sold_out', $menu->is_sold_out) ? 'checked' : '' }}
                       class="h-5 w-5 rounded border-coffee-300 text-coffee-600 focus:ring-coffee-500">
                <label for="is_sold_out" class="text-sm font-bold text-coffee-900">Tandai sebagai Sold Out</label>
            </div>
        @endif

        {{-- Submit --}}
        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.menus.index') }}" class="flex-1 rounded-xl border border-coffee-200 py-3 text-center text-sm font-bold text-coffee-700 hover:bg-coffee-50">
                Batal
            </a>
            <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 py-3 text-sm font-bold text-white shadow-md shadow-coffee-600/20 hover:brightness-110">
                {{ isset($menu) ? 'Perbarui Menu' : 'Simpan Menu' }}
            </button>
        </div>
    </form>
</div>
@endsection
