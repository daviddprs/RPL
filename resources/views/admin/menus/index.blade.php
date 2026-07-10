@extends('layouts.app')

@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')
@section('page-subtitle', 'Tambah, edit, dan hapus menu')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-lg font-bold text-coffee-950">Daftar Menu ({{ $menus->total() }})</h3>
        <a href="{{ route('admin.menus.create') }}" class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-coffee-600 to-coffee-700 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-coffee-600/20 hover:brightness-110">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Menu Baru
        </a>
    </div>

    <div class="overflow-x-auto rounded-3xl border border-coffee-200 bg-white shadow-xs">
        <table class="w-full">
            <thead>
                <tr class="border-b border-coffee-100 text-left text-xs font-bold uppercase tracking-widest text-coffee-600">
                    <th class="p-4">Menu</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-coffee-100">
                @foreach($menus as $menu)
                    <tr class="text-sm hover:bg-coffee-50/60 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 rounded-xl bg-coffee-100 overflow-hidden">
                                    @if($menu->image_path)
                                        <img src="{{ Str::startsWith($menu->image_path, ['http://', 'https://']) ? $menu->image_path : asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-coffee-400">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 13.5V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v7.5"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-coffee-950">{{ $menu->name }}</p>
                                    <p class="text-xs text-coffee-600 line-clamp-1">{{ $menu->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="rounded-full bg-coffee-100 px-3 py-1 text-xs font-bold text-coffee-800">{{ $menu->category->name }}</span>
                        </td>
                        <td class="p-4 font-extrabold text-coffee-900">{{ $menu->formatted_price }}</td>
                        <td class="p-4">
                            @if($menu->is_sold_out)
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800">Sold Out</span>
                            @else
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-800">Tersedia</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="rounded-xl border border-blue-200 bg-blue-50 p-2 text-blue-700 hover:bg-blue-100">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-red-200 bg-red-50 p-2 text-red-700 hover:bg-red-100">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $menus->links() }}</div>
@endsection
