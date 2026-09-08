@extends('layouts.app')

@section('title', 'Kategori Menu')
@section('page-title', 'Kategori Menu')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-zinc-500">{{ $categories->total() }} kategori terdaftar</p>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                <th class="text-left px-5 py-3 font-medium">Nama Kategori</th>
                <th class="text-right px-5 py-3 font-medium">Jumlah Produk</th>
                <th class="px-5 py-3 w-28"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100">
            @forelse($categories as $category)
            <tr class="hover:bg-zinc-50 transition-colors">
                <td class="px-5 py-3 font-medium text-zinc-900">{{ $category->nama_kategori }}</td>
                <td class="px-5 py-3 text-right tabular-nums text-zinc-600">{{ $category->products_count }}</td>
                <td class="px-5 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs text-zinc-500 hover:text-zinc-900 transition-colors">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-5 py-12 text-center text-zinc-400">Belum ada kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
    <div class="px-5 py-4 border-t border-zinc-100">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
