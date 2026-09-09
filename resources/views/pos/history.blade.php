@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-zinc-100 flex items-center justify-between">
        <p class="text-sm text-zinc-500">
            {{ auth()->user()->role === 'kasir' ? 'Transaksi Anda' : 'Semua Transaksi' }}
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                    <th class="text-left px-5 py-3 font-medium">No. Invoice</th>
                    <th class="text-left px-5 py-3 font-medium">Tanggal</th>
                    @if(auth()->user()->role === 'admin')
                    <th class="text-left px-5 py-3 font-medium">Kasir</th>
                    @endif
                    <th class="text-left px-5 py-3 font-medium">Metode</th>
                    <th class="text-right px-5 py-3 font-medium">Total</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs">
                        <a href="{{ route('transactions.show', $trx) }}" class="text-zinc-900 font-semibold hover:underline">{{ $trx->no_invoice }}</a>
                    </td>
                    <td class="px-5 py-3 text-zinc-600">{{ $trx->tanggal->format('d/m/Y H:i') }}</td>
                    @if(auth()->user()->role === 'admin')
                    <td class="px-5 py-3 text-zinc-600">{{ $trx->user->nama }}</td>
                    @endif
                    <td class="px-5 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-md {{ $trx->metode_bayar === 'Cash' ? 'bg-zinc-100 text-zinc-600' : 'bg-blue-50 text-blue-700' }}">
                            {{ $trx->metode_bayar }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right font-semibold tabular-nums">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('transactions.receipt', $trx->id) }}?print=false" class="text-xs text-zinc-500 hover:text-zinc-900 underline transition-colors">Struk</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-zinc-400 text-sm">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transactions->hasPages())
    <div class="px-5 py-4 border-t border-zinc-100">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
