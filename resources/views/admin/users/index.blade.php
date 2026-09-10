@extends('layouts.app')

@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-zinc-500">{{ $users->total() }} pengguna terdaftar</p>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                    <th class="text-left px-5 py-3 font-medium">Nama</th>
                    <th class="text-left px-5 py-3 font-medium">Email</th>
                    <th class="text-left px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 w-28"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($users as $user)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-600">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-zinc-900">{{ $user->nama }}</span>
                            @if($user->id === auth()->id())
                            <span class="text-xs px-1.5 py-0.5 bg-zinc-100 text-zinc-500 rounded">Anda</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-3 text-zinc-600">{{ $user->email }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-md {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-700' : 'bg-zinc-100 text-zinc-600' }} capitalize font-medium">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-zinc-500 hover:text-zinc-900 transition-colors">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-zinc-400">Belum ada pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-5 py-4 border-t border-zinc-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
