@extends('layouts.app')

@section('title', 'Produk & Menu')
@section('page-title', 'Produk & Menu')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-zinc-500">{{ $products->total() }} produk terdaftar</p>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                    <th class="text-left px-5 py-3 font-medium">Produk</th>
                    <th class="text-left px-5 py-3 font-medium">Kategori</th>
                    <th class="text-right px-5 py-3 font-medium">Harga</th>
                    <th class="text-right px-5 py-3 font-medium">Stok</th>
                    <th class="px-5 py-3 w-28"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($products as $product)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-zinc-100 flex-shrink-0 overflow-hidden">
                                @if($product->gambar)
                                <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_menu }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
                                </div>
                                @endif
                            </div>
                            <span class="font-medium text-zinc-900">{{ $product->nama_menu }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-zinc-500">{{ $product->category->nama_kategori }}</td>
                    <td class="px-5 py-3 text-right tabular-nums font-medium">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right tabular-nums">
                        <span class="{{ $product->stok <= 5 ? 'text-red-600 font-semibold' : 'text-zinc-600' }}">{{ $product->stok }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-zinc-500 hover:text-zinc-900 transition-colors">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-zinc-400">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-zinc-100">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
