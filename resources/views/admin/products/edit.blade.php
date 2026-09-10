@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-zinc-200 p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-zinc-700 mb-1.5">Kategori</label>
                    <select id="category_id" name="category_id" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('category_id') ? 'border-red-400' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nama_menu" class="block text-sm font-medium text-zinc-700 mb-1.5">Nama Menu</label>
                    <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $product->nama_menu) }}" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('nama_menu') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" required>
                    @error('nama_menu')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-zinc-700 mb-1.5">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" min="0" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none tabular-nums {{ $errors->has('harga') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" required>
                        @error('harga')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="stok" class="block text-sm font-medium text-zinc-700 mb-1.5">Stok</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', $product->stok) }}" min="0" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none tabular-nums {{ $errors->has('stok') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" required>
                        @error('stok')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Foto Produk <span class="text-zinc-400 font-normal">(kosongkan jika tidak diubah · maks. 2MB)</span></label>
                    <div
                        id="drop-zone"
                        onclick="document.getElementById('gambar').click()"
                        class="relative border-2 border-dashed border-zinc-300 rounded-xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-zinc-400 hover:bg-zinc-50 transition-colors min-h-[140px]"
                    >
                        <div id="preview-wrap" class="w-full flex flex-col items-center gap-2 {{ $product->gambar ? '' : 'hidden' }}">
                            <img
                                id="preview-img"
                                src="{{ $product->gambar ? Storage::url($product->gambar) : '' }}"
                                alt="{{ $product->nama_menu }}"
                                class="max-h-48 rounded-lg object-contain shadow-sm"
                            >
                            <p id="file-name" class="text-xs text-zinc-400">{{ $product->gambar ? basename($product->gambar) : '' }}</p>
                        </div>
                        <div id="upload-placeholder" class="{{ $product->gambar ? 'hidden' : 'flex' }} flex-col items-center gap-1 text-center">
                            <svg class="w-8 h-8 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <p class="text-sm text-zinc-500">Klik untuk pilih foto baru</p>
                            <p class="text-xs text-zinc-400">JPG, PNG, WebP · maks. 2MB</p>
                        </div>
                        @if($product->gambar)
                        <p class="text-xs text-zinc-400">Klik untuk ganti foto</p>
                        @endif
                    </div>
                    <input type="file" id="gambar" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden" onchange="previewImage(this)">
                    @error('gambar')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-5 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">Perbarui</button>
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2 text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const previewWrap = document.getElementById('preview-wrap');
    const placeholder = document.getElementById('upload-placeholder');
    const fileName = document.getElementById('file-name');

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        previewWrap.classList.remove('hidden');
        placeholder.classList.add('hidden');
        fileName.textContent = file.name;
        fileName.classList.remove('hidden');
    };

    reader.readAsDataURL(file);
}
</script>
@endsection
