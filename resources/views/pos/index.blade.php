<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Kasir POS — Cafe RJ</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] } } } }</script>
<style>
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: #d4d4d8;
    border-radius: 9999px;
}
::-webkit-scrollbar-thumb:hover {
    background: #a1a1aa;
}
* {
    scrollbar-width: thin;
    scrollbar-color: #d4d4d8 transparent;
}

.payment-panel {
    transition: opacity 200ms cubic-bezier(0.4, 0, 0.2, 1), transform 200ms cubic-bezier(0.4, 0, 0.2, 1);
}
.panel-hidden {
    display: none !important;
    opacity: 0;
    transform: translateY(6px);
    pointer-events: none;
}
.panel-visible {
    display: flex !important;
    opacity: 1;
    transform: translateY(0);
}
</style>
</head>
<body class="bg-zinc-100 font-sans min-h-screen lg:h-screen flex flex-col overflow-y-auto lg:overflow-hidden">

<header class="bg-zinc-900 text-white px-3.5 sm:px-5 py-3 flex items-center justify-between flex-shrink-0 z-10">
    <div class="flex items-center gap-2 sm:gap-3">
        <span class="font-bold text-sm sm:text-base tracking-tight">Cafe RJ POS</span>
        <span class="text-zinc-500 text-xs">|</span>
        <span class="text-zinc-300 text-xs hidden sm:inline">{{ auth()->user()->nama }}</span>
        <span class="text-[10px] sm:text-xs px-2 py-0.5 bg-zinc-800 text-zinc-300 rounded border border-zinc-700 capitalize">{{ auth()->user()->role }}</span>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="{{ route('transactions.history') }}" class="text-xs text-zinc-300 hover:text-white transition-colors">Riwayat</a>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.categories.index') }}" class="text-xs text-zinc-300 hover:text-white transition-colors">Admin</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs px-2.5 sm:px-3 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 rounded-lg transition-colors border border-zinc-700">Logout</button>
        </form>
    </div>
</header>

@if(session('error'))
<div class="mx-3 sm:mx-4 mt-2 px-4 py-2 bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm rounded-lg flex-shrink-0">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="mx-3 sm:mx-4 mt-2 px-4 py-2 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm rounded-lg flex-shrink-0">
    {{ session('success') }}
</div>
@endif

<div class="flex flex-col lg:flex-row flex-1 min-h-0">
    <section class="flex-1 flex flex-col min-w-0 border-b lg:border-b-0 lg:border-r border-zinc-200">
        <div class="bg-white border-b border-zinc-200 px-3 sm:px-4 py-2.5 flex-shrink-0 overflow-x-auto">
            <div class="flex gap-2 min-w-max">
                <a href="{{ route('pos.index') }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg {{ !$activeCategory ? 'bg-zinc-900 text-white shadow-sm' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }} transition-colors">
                    Semua Menu
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('pos.index', ['category_id' => $cat->id]) }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg {{ $activeCategory == $cat->id ? 'bg-zinc-900 text-white shadow-sm' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }} transition-colors">
                    {{ $cat->nama_kategori }}
                </a>
                @endforeach
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-3 sm:p-4">
            @if($products->isEmpty())
            <div class="flex items-center justify-center h-48 text-zinc-400 text-sm">
                Tidak ada produk tersedia.
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2.5 sm:gap-3">
                @foreach($products as $product)
                <button
                    type="button"
                    onclick="addToCart({{ $product->id }}, '{{ addslashes($product->nama_menu) }}', {{ $product->harga }}, {{ $product->stok }})"
                    class="bg-white rounded-xl border border-zinc-200 p-2.5 sm:p-3 text-left hover:border-zinc-400 hover:shadow-sm active:scale-95 transition-all cursor-pointer group flex flex-col justify-between"
                >
                    <div>
                        <div class="w-full aspect-square bg-zinc-50 rounded-lg mb-2.5 flex items-center justify-center overflow-hidden">
                            @if($product->gambar)
                            <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_menu }}" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-200">
                            @else
                            <svg class="w-8 h-8 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                            @endif
                        </div>
                        <p class="text-xs font-semibold text-zinc-900 leading-tight line-clamp-2">{{ $product->nama_menu }}</p>
                    </div>
                    <div class="mt-2 pt-1 border-t border-zinc-100 flex items-baseline justify-between">
                        <span class="text-xs font-bold text-zinc-800 tabular-nums">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        <span class="text-[10px] text-zinc-400">Stok: {{ $product->stok }}</span>
                    </div>
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <div class="lg:hidden p-3 bg-zinc-900 text-white flex items-center justify-between sticky bottom-0 z-20 shadow-lg">
            <div>
                <span class="text-[10px] text-zinc-400 block uppercase font-medium">Total Pesanan</span>
                <span id="mobile-total-display" class="font-bold text-sm tabular-nums">Rp 0</span>
            </div>
            <a href="#checkout-section" class="px-3.5 py-1.5 bg-white text-zinc-900 rounded-lg text-xs font-bold shadow-sm">
                Lihat Pembayaran &darr;
            </a>
        </div>
    </section>

    <aside id="checkout-section" class="w-full lg:w-96 bg-white flex flex-col flex-shrink-0 border-t lg:border-t-0 lg:border-l border-zinc-200 lg:h-full lg:overflow-y-auto">
        <div class="px-4 py-3 border-b border-zinc-100 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-2">
                <h2 class="text-sm font-bold text-zinc-900">Keranjang Pesanan</h2>
                <span id="cart-badge-count" class="text-[10px] font-bold px-1.5 py-0.2 bg-zinc-100 text-zinc-600 rounded">0</span>
            </div>
            <button type="button" onclick="clearCart()" class="text-xs text-zinc-400 hover:text-red-500 transition-colors">Kosongkan</button>
        </div>

        <div id="cart-items" class="min-h-[240px] lg:min-h-[280px] flex-1 overflow-y-auto px-4 py-3 space-y-2">
            <p id="cart-empty" class="text-xs text-zinc-400 text-center py-10">Belum ada item dipilih</p>
        </div>

        <div class="border-t border-zinc-100 px-3.5 sm:px-4 py-3 space-y-2.5 bg-zinc-50/50 flex-shrink-0">
            <div class="flex justify-between items-center text-sm">
                <span class="text-zinc-600 font-semibold text-xs sm:text-sm">Total Belanja</span>
                <span id="total-display" class="font-black text-zinc-900 tabular-nums text-base sm:text-lg">Rp 0</span>
            </div>

            <form id="checkout-form" method="POST" action="{{ route('pos.checkout') }}">
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}">
                <input type="hidden" name="metode_bayar" id="metode_bayar" value="Cash">
                <input type="hidden" name="jumlah_bayar" id="hidden_jumlah_bayar" value="0">
                <div id="cart-inputs"></div>

                <div class="space-y-2">
                    <div>
                        <label class="text-[11px] text-zinc-500 mb-1 block font-semibold uppercase tracking-wider">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-1.5 p-1 bg-zinc-200/70 rounded-xl">
                            <button
                                type="button"
                                id="tab-Cash"
                                onclick="setPaymentMethod('Cash')"
                                class="payment-tab-btn flex flex-col items-center justify-center py-1.5 px-1 rounded-lg text-xs font-bold transition-all duration-200 bg-zinc-900 text-white shadow-sm"
                            >
                                <svg class="w-4 h-4 mb-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                                <span>Tunai</span>
                            </button>
                            <button
                                type="button"
                                id="tab-QRIS"
                                onclick="setPaymentMethod('QRIS')"
                                class="payment-tab-btn flex flex-col items-center justify-center py-1.5 px-1 rounded-lg text-xs font-medium transition-all duration-200 text-zinc-600 hover:text-zinc-900 hover:bg-white/50"
                            >
                                <svg class="w-4 h-4 mb-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                <span>QRIS</span>
                            </button>
                            <button
                                type="button"
                                id="tab-Transfer"
                                onclick="setPaymentMethod('Transfer')"
                                class="payment-tab-btn flex flex-col items-center justify-center py-1.5 px-1 rounded-lg text-xs font-medium transition-all duration-200 text-zinc-600 hover:text-zinc-900 hover:bg-white/50"
                            >
                                <svg class="w-4 h-4 mb-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="21" x2="21" y2="21"/><line x1="3" y1="10" x2="21" y2="10"/><polyline points="5 6 12 3 19 6"/><line x1="4" y1="10" x2="4" y2="21"/><line x1="20" y1="10" x2="20" y2="21"/><line x1="8" y1="14" x2="8" y2="17"/><line x1="12" y1="14" x2="12" y2="17"/><line x1="16" y1="14" x2="16" y2="17"/></svg>
                                <span>Transfer</span>
                            </button>
                        </div>
                    </div>

                    <div id="panels-container" class="relative">
                        <div id="cash-section" class="payment-panel panel-visible border border-zinc-200 rounded-xl bg-white p-3 shadow-sm space-y-2.5 min-h-[250px] flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between border-b border-zinc-100 pb-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-black tracking-widest text-zinc-900 uppercase border border-zinc-300 px-1.5 py-0.5 rounded">TUNAI</span>
                                        <span class="text-[10px] text-zinc-400 font-semibold uppercase">Kasir Cash</span>
                                    </div>
                                    <span class="text-[10px] font-medium text-zinc-500">Mata Uang: IDR</span>
                                </div>

                                <div>
                                    <label class="text-[11px] text-zinc-600 mb-1 block font-semibold">Uang Tunai Diterima</label>
                                    <input
                                        type="number"
                                        id="input-cash-amount"
                                        min="0"
                                        oninput="updateKembalian()"
                                        class="w-full text-base font-bold border border-zinc-300 rounded-lg px-3 py-1.5 focus:outline-none focus:border-zinc-500 tabular-nums bg-white shadow-inner"
                                        placeholder="0"
                                    >
                                    <div class="grid grid-cols-4 gap-1 sm:gap-1.5 mt-1.5">
                                        <button type="button" onclick="setExactCash()" class="py-1.5 text-[11px] sm:text-xs font-semibold rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-700 hover:bg-zinc-100 transition-colors text-center">Uang Pas</button>
                                        <button type="button" onclick="setCashValue(20000)" class="py-1.5 text-[11px] sm:text-xs font-semibold rounded-lg border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 transition-colors text-center">Rp 20.000</button>
                                        <button type="button" onclick="setCashValue(50000)" class="py-1.5 text-[11px] sm:text-xs font-semibold rounded-lg border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 transition-colors text-center">Rp 50.000</button>
                                        <button type="button" onclick="setCashValue(100000)" class="py-1.5 text-[11px] sm:text-xs font-semibold rounded-lg border border-zinc-200 bg-white text-zinc-700 hover:bg-zinc-50 transition-colors text-center">Rp 100.000</button>
                                    </div>
                                </div>
                            </div>

                            <div id="kembalian-row" class="flex justify-between items-center text-sm py-2 px-3 bg-zinc-50 rounded-lg border border-zinc-200">
                                <span class="text-xs text-zinc-600 font-semibold">Uang Kembalian</span>
                                <span id="kembalian-display" class="font-black text-emerald-600 tabular-nums text-base">Rp 0</span>
                            </div>
                        </div>

                        <div id="qris-section" class="payment-panel panel-hidden border border-zinc-200 rounded-xl bg-white p-3 shadow-sm space-y-2 min-h-[250px] flex flex-col justify-between" style="display: none !important;">
                            <div class="flex items-center justify-between border-b border-zinc-100 pb-1.5">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs font-black tracking-widest text-red-600 uppercase border border-red-200 px-1.5 py-0.5 rounded">QRIS</span>
                                    <span class="text-[10px] text-zinc-400 font-semibold uppercase">Standar Nasional</span>
                                </div>
                                <span class="text-[10px] font-mono text-zinc-500">NMID: ID1020260909001</span>
                            </div>

                            <div class="flex flex-col items-center">
                                <div class="relative p-1.5 bg-white border border-zinc-200 rounded-lg shadow-inner cursor-pointer group" onclick="openQrisModal()">
                                    <img
                                        id="qris-image"
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=00020101021126570011ID.CO.CAFERJ.WWW011893600914900000000002150000000000000000303UBE5204581453033605802ID5909CAFE+RJ+6013KOTA+EXAMPLE6304ABCD"
                                        alt="Contoh QRIS Cafe RJ"
                                        width="115"
                                        height="115"
                                        class="block mx-auto rounded"
                                    >
                                    <div class="absolute inset-0 bg-zinc-900/60 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center text-white text-xs font-medium">
                                        Klik Perbesar
                                    </div>
                                </div>
                                <button type="button" onclick="openQrisModal()" class="mt-1 text-[11px] text-zinc-600 hover:text-zinc-900 underline flex items-center gap-1 font-medium">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
                                    Tampilkan Layar Pelanggan
                                </button>
                            </div>

                            <div class="bg-zinc-50 rounded-lg py-1.5 px-2 text-center border border-zinc-100">
                                <p class="text-[10px] text-zinc-500 uppercase font-semibold">Total Tagihan QRIS</p>
                                <p id="qris-total-label" class="text-base font-bold text-zinc-900 tabular-nums">Rp 0</p>
                            </div>
                        </div>

                        <div id="transfer-section" class="payment-panel panel-hidden border border-zinc-200 rounded-xl bg-white p-3 shadow-sm space-y-2 min-h-[250px] flex flex-col justify-between" style="display: none !important;">
                            <div class="space-y-2">
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-[10px] text-zinc-400 font-bold uppercase tracking-wider">Pilih Bank Tujuan</p>
                                        <span class="text-[10px] font-medium text-emerald-600">Verifikasi Manual</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1">
                                        <button
                                            type="button"
                                            id="bank-btn-BCA"
                                            onclick="selectBank('BCA')"
                                            class="bank-choice-btn py-1 px-2 text-xs font-bold rounded-lg border border-zinc-900 bg-zinc-900 text-white transition-all text-center shadow-sm"
                                        >
                                            BCA
                                        </button>
                                        <button
                                            type="button"
                                            id="bank-btn-Mandiri"
                                            onclick="selectBank('Mandiri')"
                                            class="bank-choice-btn py-1 px-2 text-xs font-bold rounded-lg border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 transition-all text-center"
                                        >
                                            Mandiri
                                        </button>
                                        <button
                                            type="button"
                                            id="bank-btn-BRI"
                                            onclick="selectBank('BRI')"
                                            class="bank-choice-btn py-1 px-2 text-xs font-bold rounded-lg border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 transition-all text-center"
                                        >
                                            BRI
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-zinc-50 p-2.5 rounded-lg border border-zinc-200 space-y-1.5 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-zinc-500 font-medium">Bank</span>
                                        <span id="transfer-bank-name" class="font-bold text-zinc-800">Bank Central Asia (BCA)</span>
                                    </div>
                                    <div class="flex justify-between items-center border-t border-zinc-200/70 pt-1.5">
                                        <div>
                                            <span class="text-zinc-500 block text-[10px] uppercase font-medium">No. Rekening</span>
                                            <span id="transfer-account-no" class="font-mono font-bold text-sm text-zinc-900">8820 1928 3746</span>
                                        </div>
                                        <button
                                            type="button"
                                            onclick="copyBankNumber()"
                                            class="px-2 py-0.5 text-xs border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 active:bg-zinc-100 flex items-center gap-1 transition-colors shadow-sm"
                                        >
                                            <svg class="w-3 h-3 text-zinc-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                            <span id="copy-status-text" class="text-[11px] font-medium text-zinc-600">Salin</span>
                                        </button>
                                    </div>
                                    <div class="flex justify-between items-center border-t border-zinc-200/70 pt-1.5">
                                        <span class="text-zinc-500 font-medium">Atas Nama</span>
                                        <span id="transfer-account-name" class="font-semibold text-zinc-800">Cafe RJ Official</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-amber-50/70 rounded-lg py-1.5 px-2.5 border border-amber-200 text-center">
                                <p class="text-[10px] text-amber-800 font-bold uppercase">Nominal Transfer Pas</p>
                                <p id="transfer-total-label" class="text-base font-extrabold text-amber-950 tabular-nums">Rp 0</p>
                                <p class="text-[9px] text-amber-700 mt-0.5">Pastikan mutasi dana masuk ke m-banking sebelum cetak struk</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="checkout-alert" class="hidden text-xs text-red-600 bg-red-50 border border-red-200 px-3 py-1.5 rounded-lg text-center font-medium"></div>

                <button
                    type="button"
                    id="bayar-btn"
                    onclick="submitCheckout()"
                    class="mt-2.5 w-full py-3 bg-zinc-900 text-white text-sm font-bold rounded-xl hover:bg-zinc-800 active:bg-zinc-950 transition-all shadow-sm"
                >
                    Bayar &amp; Cetak Struk
                </button>
            </form>
        </div>
    </aside>
</div>

<div id="qris-modal" class="fixed inset-0 bg-zinc-950/75 z-50 hidden flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-5 sm:p-6 text-center shadow-2xl relative">
        <button type="button" onclick="closeQrisModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-700">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        <div class="flex items-center justify-center gap-2 mb-2">
            <span class="text-xs sm:text-sm font-black tracking-widest text-red-600 uppercase border border-red-200 px-2 py-0.5 rounded">QRIS</span>
            <span class="text-xs font-semibold text-zinc-600">PEMBAYARAN DIGITAL</span>
        </div>

        <h3 class="text-base sm:text-lg font-bold text-zinc-900">CAFE RJ</h3>
        <p class="text-xs text-zinc-500 mt-0.5">NMID: ID1020260909001 &middot; A01</p>

        <div class="my-4 p-2.5 bg-white border-2 border-zinc-200 rounded-xl inline-block shadow-sm">
            <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=00020101021126570011ID.CO.CAFERJ.WWW011893600914900000000002150000000000000000303UBE5204581453033605802ID5909CAFE+RJ+6013KOTA+EXAMPLE6304ABCD"
                alt="QRIS Cafe RJ"
                width="220"
                height="220"
                class="block mx-auto"
            >
        </div>

        <div class="bg-zinc-50 rounded-xl p-2.5 mb-3 border border-zinc-200">
            <p class="text-xs text-zinc-500">Total Pembayaran</p>
            <p id="modal-qris-total" class="text-xl sm:text-2xl font-bold text-zinc-900 tabular-nums">Rp 0</p>
        </div>

        <p class="text-[11px] text-zinc-400 mb-4 leading-relaxed">
            Dukung semua aplikasi pembayaran: GoPay, OVO, DANA, ShopeePay, LinkAja, BCA, Mandiri, BRI, BNI &amp; seluruh QRIS berizin.
        </p>

        <button type="button" onclick="closeQrisModal()" class="w-full py-2.5 bg-zinc-900 text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-zinc-800 transition-colors">
            Kembali ke Kasir
        </button>
    </div>
</div>

<script>
const cart = {};
let currentMethod = 'Cash';

const bankData = {
    'BCA': { name: 'Bank Central Asia (BCA)', no: '8820 1928 3746', an: 'Cafe RJ Official' },
    'Mandiri': { name: 'Bank Mandiri', no: '137 00 2938 4819', an: 'Cafe RJ Official' },
    'BRI': { name: 'Bank Rakyat Indonesia (BRI)', no: '0206 01 029384 50 1', an: 'Cafe RJ Official' }
};

let activeBankKey = 'BCA';

function formatRp(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function addToCart(id, nama, harga, stok) {
    const current = cart[id] ? cart[id].jumlah : 0;
    if (current >= stok) return;
    cart[id] = { id, nama, harga, stok, jumlah: current + 1 };
    renderCart();
}

function updateQty(id, delta) {
    if (!cart[id]) return;
    cart[id].jumlah += delta;
    if (cart[id].jumlah <= 0) {
        delete cart[id];
    }
    renderCart();
}

function clearCart() {
    for (const key in cart) {
        delete cart[key];
    }
    renderCart();
}

function renderCart() {
    const container = document.getElementById('cart-items');
    const inputsContainer = document.getElementById('cart-inputs');
    const items = Object.values(cart);

    const badgeCount = document.getElementById('cart-badge-count');
    const totalCount = items.reduce((sum, item) => sum + item.jumlah, 0);
    if (badgeCount) badgeCount.textContent = totalCount;

    if (items.length === 0) {
        container.innerHTML = '<p id="cart-empty" class="text-xs text-zinc-400 text-center py-6 sm:py-8">Belum ada item dipilih</p>';
        inputsContainer.innerHTML = '';
        updateTotal();
        return;
    }

    container.innerHTML = items.map((item) => `
        <div class="flex items-start gap-2 py-2 border-b border-zinc-100">
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-zinc-900 truncate">${item.nama}</p>
                <p class="text-[11px] text-zinc-500">${formatRp(item.harga)}</p>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">
                <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 rounded transition-colors text-sm font-bold">&minus;</button>
                <span class="w-6 text-center text-xs font-bold tabular-nums">${item.jumlah}</span>
                <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 rounded transition-colors text-sm font-bold">+</button>
            </div>
        </div>
    `).join('');

    inputsContainer.innerHTML = items.map((item, idx) =>
        `<input type="hidden" name="cart[${idx}][product_id]" value="${item.id}">` +
        `<input type="hidden" name="cart[${idx}][jumlah]" value="${item.jumlah}">`
    ).join('');

    updateTotal();
}

function getTotal() {
    return Object.values(cart).reduce((sum, item) => sum + item.harga * item.jumlah, 0);
}

function updateTotal() {
    const total = getTotal();
    document.getElementById('total-display').textContent = formatRp(total);
    const mobileTotal = document.getElementById('mobile-total-display');
    if (mobileTotal) mobileTotal.textContent = formatRp(total);

    const qrisLabel = document.getElementById('qris-total-label');
    const modalQrisLabel = document.getElementById('modal-qris-total');
    const transferLabel = document.getElementById('transfer-total-label');
    if (qrisLabel) qrisLabel.textContent = formatRp(total);
    if (modalQrisLabel) modalQrisLabel.textContent = formatRp(total);
    if (transferLabel) transferLabel.textContent = formatRp(total);
    updateKembalian();
}

function setExactCash() {
    const total = getTotal();
    document.getElementById('input-cash-amount').value = total;
    updateKembalian();
}

function setCashValue(val) {
    document.getElementById('input-cash-amount').value = val;
    updateKembalian();
}

function addCash(amount) {
    const input = document.getElementById('input-cash-amount');
    const current = parseInt(input.value) || 0;
    input.value = current + amount;
    updateKembalian();
}

function updateKembalian() {
    const total = getTotal();
    const btn = document.getElementById('bayar-btn');
    const kembalianEl = document.getElementById('kembalian-display');
    const alertEl = document.getElementById('checkout-alert');
    if (alertEl) alertEl.classList.add('hidden');

    if (currentMethod !== 'Cash') {
        kembalianEl.textContent = formatRp(0);
        document.getElementById('hidden_jumlah_bayar').value = total;
        return;
    }

    const bayar = parseInt(document.getElementById('input-cash-amount').value) || 0;
    document.getElementById('hidden_jumlah_bayar').value = bayar;

    const kembalian = bayar - total;
    kembalianEl.textContent = formatRp(kembalian < 0 ? 0 : kembalian);
    kembalianEl.className = kembalian >= 0 ? 'font-black text-emerald-600 tabular-nums text-lg' : 'font-black text-red-500 tabular-nums text-lg';
}

function getPanelEl(method) {
    if (method === 'Cash') return document.getElementById('cash-section');
    if (method === 'QRIS') return document.getElementById('qris-section');
    if (method === 'Transfer') return document.getElementById('transfer-section');
    return null;
}

function setPaymentMethod(method) {
    if (currentMethod === method) return;

    const tabs = ['Cash', 'QRIS', 'Transfer'];
    tabs.forEach(m => {
        const tabBtn = document.getElementById('tab-' + m);
        if (tabBtn) {
            if (m === method) {
                tabBtn.className = 'payment-tab-btn flex flex-col items-center justify-center py-2 px-1 rounded-lg text-xs font-bold transition-all duration-200 bg-zinc-900 text-white shadow-sm';
            } else {
                tabBtn.className = 'payment-tab-btn flex flex-col items-center justify-center py-2 px-1 rounded-lg text-xs font-medium transition-all duration-200 text-zinc-600 hover:text-zinc-900 hover:bg-white/50';
            }
        }
    });

    const currentPanel = getPanelEl(currentMethod);
    const nextPanel = getPanelEl(method);

    if (currentPanel) {
        currentPanel.classList.remove('panel-visible');
        currentPanel.classList.add('panel-hidden');
    }

    setTimeout(() => {
        tabs.forEach(m => {
            const p = getPanelEl(m);
            if (p && m !== method) {
                p.style.setProperty('display', 'none', 'important');
                p.classList.remove('panel-visible');
                p.classList.add('panel-hidden');
            }
        });

        if (nextPanel) {
            nextPanel.style.setProperty('display', 'flex', 'important');
            void nextPanel.offsetWidth;
            nextPanel.classList.remove('panel-hidden');
            nextPanel.classList.add('panel-visible');
        }
        currentMethod = method;
        document.getElementById('metode_bayar').value = method;

        const btn = document.getElementById('bayar-btn');
        if (method === 'Cash') {
            btn.textContent = 'Bayar & Cetak Struk';
        } else if (method === 'QRIS') {
            btn.textContent = 'Verifikasi QRIS & Cetak Struk';
        } else if (method === 'Transfer') {
            btn.textContent = 'Konfirmasi Transfer & Cetak Struk';
        }

        updateKembalian();
    }, 120);
}

function selectBank(bankKey) {
    activeBankKey = bankKey;
    const bank = bankData[bankKey];
    if (!bank) return;

    ['BCA', 'Mandiri', 'BRI'].forEach(k => {
        const btn = document.getElementById('bank-btn-' + k);
        if (btn) {
            if (k === bankKey) {
                btn.className = 'bank-choice-btn py-1.5 px-2 text-xs font-bold rounded-lg border border-zinc-900 bg-zinc-900 text-white transition-all text-center shadow-sm';
            } else {
                btn.className = 'bank-choice-btn py-1.5 px-2 text-xs font-bold rounded-lg border border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 transition-all text-center';
            }
        }
    });

    document.getElementById('transfer-bank-name').textContent = bank.name;
    document.getElementById('transfer-account-no').textContent = bank.no;
    document.getElementById('transfer-account-name').textContent = bank.an;
}

function copyBankNumber() {
    const bank = bankData[activeBankKey];
    if (!bank) return;
    const cleanNumber = bank.no.replace(/\s+/g, '');
    navigator.clipboard.writeText(cleanNumber).then(() => {
        const copyText = document.getElementById('copy-status-text');
        copyText.textContent = 'Tersalin!';
        copyText.className = 'text-[11px] font-bold text-emerald-600';
        setTimeout(() => {
            copyText.textContent = 'Salin';
            copyText.className = 'text-[11px] font-medium text-zinc-600';
        }, 1800);
    }).catch(() => {});
}

function openQrisModal() {
    document.getElementById('qris-modal').classList.remove('hidden');
}

function closeQrisModal() {
    document.getElementById('qris-modal').classList.add('hidden');
}

async function refreshCsrfToken() {
    try {
        const response = await fetch('{{ route('csrf.refresh') }}');
        if (response.ok) {
            const data = await response.json();
            if (data.token) {
                const tokenInput = document.getElementById('csrf-token');
                if (tokenInput) tokenInput.value = data.token;
                const metaTag = document.querySelector('meta[name="csrf-token"]');
                if (metaTag) metaTag.setAttribute('content', data.token);
            }
        }
    } catch (err) {}
}

setInterval(refreshCsrfToken, 3 * 60 * 1000);
window.addEventListener('focus', refreshCsrfToken);

async function submitCheckout() {
    const alertEl = document.getElementById('checkout-alert');
    const items = Object.values(cart);
    const total = getTotal();

    if (items.length === 0 || total <= 0) {
        if (alertEl) {
            alertEl.textContent = 'Pilih minimal 1 menu sebelum melakukan transaksi!';
            alertEl.classList.remove('hidden');
        }
        return;
    }

    if (currentMethod === 'Cash') {
        const bayar = parseInt(document.getElementById('input-cash-amount').value) || 0;
        if (bayar < total) {
            if (alertEl) {
                alertEl.textContent = 'Uang tunai diterima kurang dari total belanja!';
                alertEl.classList.remove('hidden');
            }
            return;
        }
        document.getElementById('hidden_jumlah_bayar').value = bayar;
    } else {
        document.getElementById('hidden_jumlah_bayar').value = total;
    }

    const btn = document.getElementById('bayar-btn');
    btn.disabled = true;
    btn.textContent = 'Memproses Transaksi...';

    await refreshCsrfToken();

    document.getElementById('metode_bayar').value = currentMethod;
    document.getElementById('checkout-form').submit();
}
</script>

</body>
</html>
