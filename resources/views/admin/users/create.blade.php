@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="max-w-md">
    <div class="bg-white rounded-xl border border-zinc-200 p-6">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-zinc-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" placeholder="Budi Santoso" required>
                    @error('nama')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" placeholder="kasir@caferj.local" required>
                    @error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-zinc-700 mb-1.5">Role</label>
                    <select id="role" name="role" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('role') ? 'border-red-400' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" required>
                        <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100' }}" placeholder="Min. 6 karakter" required>
                    @error('password')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2.5 text-sm border rounded-lg outline-none border-zinc-300 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-100" required>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="px-5 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2 text-sm text-zinc-600 hover:text-zinc-900 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
