@extends('layouts.app')

@section('title', 'Laporan Omzet')
@section('page-title', 'Laporan Omzet Penjualan')

@section('content')
<div class="mb-5">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex items-end gap-3">
        <div>
            <label class="block text-xs font-medium text-zinc-500 mb-1.5">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}" class="px-3 py-2 text-sm border border-zinc-300 rounded-lg focus:outline-none focus:border-zinc-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-zinc-500 mb-1.5">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}" class="px-3 py-2 text-sm border border-zinc-300 rounded-lg focus:outline-none focus:border-zinc-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-zinc-900 text-white text-sm font-medium rounded-lg hover:bg-zinc-800 transition-colors">Tampilkan</button>
    </form>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-zinc-200 p-5">
        <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Total Omzet</p>
        <p class="text-2xl font-bold text-zinc-900 mt-2 tabular-nums">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-zinc-200 p-5">
        <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Total Transaksi</p>
        <p class="text-2xl font-bold text-zinc-900 mt-2 tabular-nums">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-xl border border-zinc-200 p-5">
        <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Item Terjual</p>
        <p class="text-2xl font-bold text-zinc-900 mt-2 tabular-nums">{{ number_format($totalItem, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-zinc-100">
        <p class="text-sm font-medium text-zinc-900">Detail Transaksi</p>
        <p class="text-xs text-zinc-500 mt-0.5">{{ \Carbon\Carbon::parse($dari)->format('d M Y') }} — {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                    <th class="text-left px-5 py-3 font-medium">No. Invoice</th>
                    <th class="text-left px-5 py-3 font-medium">Waktu</th>
                    <th class="text-left px-5 py-3 font-medium">Kasir</th>
                    <th class="text-left px-5 py-3 font-medium">Metode</th>
                    <th class="text-right px-5 py-3 font-medium">Item</th>
                    <th class="text-right px-5 py-3 font-medium">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs text-zinc-700">{{ $trx->no_invoice }}</td>
                    <td class="px-5 py-3 text-zinc-600">{{ $trx->tanggal->format('d/m H:i') }}</td>
                    <td class="px-5 py-3 text-zinc-600">{{ $trx->user->nama }}</td>
                    <td class="px-5 py-3 text-zinc-500 text-xs">{{ $trx->metode_bayar }}</td>
                    <td class="px-5 py-3 text-right tabular-nums text-zinc-600">{{ $trx->details->sum('jumlah_beli') }}</td>
                    <td class="px-5 py-3 text-right tabular-nums font-semibold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-zinc-400">Tidak ada transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
            @if($transactions->count() > 0)
            <tfoot>
                <tr class="bg-zinc-50 border-t-2 border-zinc-200">
                    <td colspan="5" class="px-5 py-3 text-sm font-semibold text-zinc-700 text-right">Total Omzet</td>
                    <td class="px-5 py-3 text-right tabular-nums font-bold text-zinc-900">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
