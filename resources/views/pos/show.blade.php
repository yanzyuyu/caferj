@extends('layouts.app')

@section('title', 'Detail ' . $transaction->no_invoice)
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('transactions.history') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-zinc-600 hover:text-zinc-900 transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Riwayat
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('transactions.receipt', $transaction) }}?print=false" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 transition-colors shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak Struk
            </a>
            <a href="{{ route('pos.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-zinc-900 rounded-lg hover:bg-zinc-800 transition-colors shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Transaksi Baru
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 pb-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Nomor Invoice</p>
                <p class="font-mono text-xl font-bold text-zinc-900 mt-0.5">{{ $transaction->no_invoice }}</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Lunas
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $transaction->metode_bayar === 'Cash' ? 'bg-zinc-100 text-zinc-700' : 'bg-blue-50 text-blue-700' }} border border-zinc-200">
                    {{ $transaction->metode_bayar }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
            <div>
                <span class="block text-zinc-400 font-medium uppercase tracking-wide">Waktu Transaksi</span>
                <span class="font-semibold text-zinc-800 mt-1 block">{{ $transaction->tanggal->format('d/m/Y H:i') }}</span>
            </div>
            <div>
                <span class="block text-zinc-400 font-medium uppercase tracking-wide">Petugas Kasir</span>
                <span class="font-semibold text-zinc-800 mt-1 block">{{ $transaction->user->nama }}</span>
            </div>
            <div>
                <span class="block text-zinc-400 font-medium uppercase tracking-wide">Total Item</span>
                <span class="font-semibold text-zinc-800 mt-1 block tabular-nums">{{ $transaction->details->sum('jumlah_beli') }} item</span>
            </div>
            <div>
                <span class="block text-zinc-400 font-medium uppercase tracking-wide">Total Pembayaran</span>
                <span class="font-bold text-zinc-900 mt-1 block tabular-nums">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden shadow-sm">
        <div class="px-5 py-4 border-b border-zinc-100">
            <h2 class="text-sm font-bold text-zinc-900">Rincian Menu Pesanan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 text-zinc-500 text-xs uppercase tracking-wide">
                        <th class="text-left px-5 py-3 font-medium w-12">No</th>
                        <th class="text-left px-5 py-3 font-medium">Menu</th>
                        <th class="text-right px-5 py-3 font-medium">Harga Satuan</th>
                        <th class="text-center px-5 py-3 font-medium w-24">Jumlah</th>
                        <th class="text-right px-5 py-3 font-medium">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($transaction->details as $index => $detail)
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-5 py-3 text-xs text-zinc-400 tabular-nums">{{ $index + 1 }}</td>
                        <td class="px-5 py-3 font-medium text-zinc-900">{{ $detail->product->nama_menu }}</td>
                        <td class="px-5 py-3 text-right tabular-nums text-zinc-600">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-center tabular-nums font-semibold text-zinc-800">{{ $detail->jumlah_beli }}</td>
                        <td class="px-5 py-3 text-right tabular-nums font-bold text-zinc-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="border-t border-zinc-200 bg-zinc-50/70 p-5">
            <div class="max-w-xs ml-auto space-y-2 text-sm">
                <div class="flex justify-between text-zinc-600">
                    <span>Subtotal</span>
                    <span class="tabular-nums font-medium">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-zinc-600">
                    <span>Pajak</span>
                    <span class="tabular-nums font-medium">Rp 0</span>
                </div>
                <div class="flex justify-between text-zinc-900 font-bold border-t border-zinc-200 pt-2 text-base">
                    <span>Total Belanja</span>
                    <span class="tabular-nums">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-zinc-600 pt-1">
                    <span>Bayar ({{ $transaction->metode_bayar }})</span>
                    <span class="tabular-nums font-medium">Rp {{ number_format($transaction->jumlah_bayar, 0, ',', '.') }}</span>
                </div>
                @if($transaction->metode_bayar === 'Cash')
                <div class="flex justify-between text-emerald-700 font-bold">
                    <span>Kembalian</span>
                    <span class="tabular-nums">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
