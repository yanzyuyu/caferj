@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="max-w-md">
    <div class="bg-white rounded-xl border border-zinc-200 p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-zinc-700 mb-1.5">Nama Kategori</label>
                <input
                    type="text"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="{{ old('nama_kategori') }}"
                    class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none transition-colors {{ $errors->has('nama_kategori') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}"
                    placeholder="Contoh: Kopi, Non-Kopi, Makanan Ringan"
                    required
                >
                @error('nama_kategori')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 mt-5">
                <button type="submit" class="px-5 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2 text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
