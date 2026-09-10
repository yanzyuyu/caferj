<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk {{ $transaction->no_invoice }} — Cafe RJ</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --sb-thumb: #d4d4d8;
    --sb-thumb-hover: #71717a;
    --sb-track: transparent;
}
* {
    scrollbar-width: thin;
    scrollbar-color: var(--sb-thumb) var(--sb-track);
}
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: var(--sb-track);
}
::-webkit-scrollbar-thumb {
    background: var(--sb-thumb);
    border-radius: 9999px;
    transition: background 0.15s ease;
}
::-webkit-scrollbar-thumb:hover {
    background: var(--sb-thumb-hover);
}

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #18181b;
    background: #f4f4f5;
    padding: 24px 16px;
}

.no-print {
    max-width: 800px;
    margin: 0 auto 20px auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #ffffff;
    padding: 12px 18px;
    border-radius: 12px;
    border: 1px solid #e4e4e7;
}

.btn-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.15s;
    border: none;
    font-family: inherit;
}

.btn-primary { background: #18181b; color: #ffffff; }
.btn-primary:hover { background: #27272a; }
.btn-outline { background: #ffffff; color: #3f3f46; border: 1px solid #d4d4d8; }
.btn-outline:hover { background: #f4f4f5; color: #18181b; }

.receipt-card {
    background: #ffffff;
    max-width: 800px;
    margin: 0 auto;
    padding: 36px 40px;
    border-radius: 16px;
    border: 1px solid #e4e4e7;
    width: 100%;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 2px solid #18181b;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.brand-title {
    font-size: 24px;
    font-weight: 800;
    letter-spacing: -0.02em;
    color: #18181b;
}

.brand-subtitle {
    font-size: 12px;
    color: #71717a;
    margin-top: 4px;
    line-height: 1.5;
}

.invoice-badge {
    text-align: right;
}

.invoice-title {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 700;
    color: #a1a1aa;
}

.invoice-number {
    font-family: monospace;
    font-size: 16px;
    font-weight: 700;
    color: #18181b;
    margin-top: 2px;
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    background: #fafafa;
    border: 1px solid #f4f4f5;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 24px;
    font-size: 13px;
}

.meta-item { display: flex; flex-direction: column; }
.meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #a1a1aa; font-weight: 600; margin-bottom: 3px; }
.meta-val { font-weight: 600; color: #27272a; }

.table-wrap {
    width: 100%;
    margin-bottom: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

thead th {
    text-align: left;
    padding: 10px 12px;
    background: #fafafa;
    border-top: 1px solid #e4e4e7;
    border-bottom: 2px solid #e4e4e7;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #52525b;
    font-weight: 700;
}

tbody td {
    padding: 12px;
    border-bottom: 1px solid #f4f4f5;
    color: #27272a;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.tabular-nums { font-variant-numeric: tabular-nums; }

.summary-container {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 24px;
}

.summary-box {
    width: 320px;
    background: #fafafa;
    border: 1px solid #e4e4e7;
    border-radius: 12px;
    padding: 16px 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    margin-bottom: 8px;
    color: #52525b;
}

.summary-row.total-row {
    border-top: 2px dashed #d4d4d8;
    padding-top: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 800;
    color: #18181b;
}

.footer-section {
    text-align: center;
    border-top: 1px solid #e4e4e7;
    padding-top: 20px;
    color: #71717a;
    font-size: 12px;
    line-height: 1.6;
}

.receipt-card.mode-thermal {
    max-width: 320px;
    padding: 20px 16px;
    border-radius: 0;
    font-family: monospace;
    font-size: 12px;
}

.receipt-card.mode-thermal .header-top {
    flex-direction: column;
    text-align: center;
    align-items: center;
    border-bottom: 1px dashed #000;
    padding-bottom: 12px;
}

.receipt-card.mode-thermal .invoice-badge {
    text-align: center;
    margin-top: 8px;
}

.receipt-card.mode-thermal .meta-grid {
    grid-template-columns: 1fr;
    gap: 6px;
    background: transparent;
    border: none;
    padding: 0;
    border-bottom: 1px dashed #000;
    padding-bottom: 10px;
}

.receipt-card.mode-thermal .meta-item {
    flex-direction: row;
    justify-content: space-between;
}

.receipt-card.mode-thermal .summary-box {
    width: 100%;
    background: transparent;
    border: none;
    padding: 0;
}

.receipt-card.mode-thermal thead th {
    background: transparent;
    border-top: none;
    border-bottom: 1px dashed #000;
}

.receipt-card.mode-thermal tbody td {
    border-bottom: 1px dashed #eee;
    padding: 8px 4px;
}

.receipt-card.mode-thermal .footer-section {
    border-top: 1px dashed #000;
}

@media (max-width: 640px) {
    body {
        padding: 12px 8px;
    }

    .no-print {
        flex-direction: column;
        align-items: stretch;
        padding: 12px;
        gap: 8px;
    }

    .btn-group {
        flex-direction: column;
        width: 100%;
        gap: 8px;
    }

    .btn {
        width: 100%;
        justify-content: center;
        padding: 10px 14px;
        font-size: 13px;
    }

    .receipt-card {
        padding: 20px 14px;
        border-radius: 12px;
    }

    .header-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding-bottom: 14px;
        margin-bottom: 16px;
    }

    .brand-title {
        font-size: 20px;
    }

    .invoice-badge {
        text-align: left;
    }

    .meta-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 8px 12px;
        padding: 12px 14px;
        margin-bottom: 16px;
    }

    .meta-label {
        font-size: 9px;
    }

    .meta-val {
        font-size: 12px;
    }

    .table-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 16px;
    }

    table {
        min-width: 320px;
        font-size: 12px;
    }

    thead th {
        padding: 8px 6px;
        font-size: 10px;
    }

    tbody td {
        padding: 8px 6px;
        font-size: 12px;
    }

    .col-no {
        display: none;
    }

    .summary-container {
        justify-content: stretch;
        margin-bottom: 16px;
    }

    .summary-box {
        width: 100%;
        padding: 14px 16px;
    }

    .summary-row {
        font-size: 12px;
        margin-bottom: 6px;
    }

    .summary-row.total-row {
        font-size: 15px;
        padding-top: 8px;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .footer-section {
        padding-top: 14px;
        font-size: 11px;
    }
}

@media print {
    body {
        background: #ffffff !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .no-print {
        display: none !important;
    }

    @page {
        size: auto;
        margin: 10mm 15mm;
    }

    .receipt-card {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }

    .receipt-card.mode-thermal {
        max-width: 80mm !important;
        width: 80mm !important;
    }
}
</style>
</head>
<body>

<div class="no-print">
    <div class="btn-group">
        <button type="button" onclick="printFull()" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak Layar Penuh (Full)
        </button>
        <button type="button" onclick="printThermal()" class="btn btn-outline">
            Cetak Struk Mini (80mm)
        </button>
    </div>
    <a href="{{ route('pos.index') }}" class="btn btn-outline">
        &larr; Transaksi Baru
    </a>
</div>

<div id="receipt-box" class="receipt-card">
    <div class="header-top">
        <div>
            <h1 class="brand-title">CAFE RJ</h1>
            <p class="brand-subtitle">
                Jl. Pemuda No. 12, Kota<br>
                Telp: (021) 1234-5678 &middot; caferj.local
            </p>
        </div>
        <div class="invoice-badge">
            <p class="invoice-title">Bukti Pembayaran</p>
            <p class="invoice-number">{{ $transaction->no_invoice }}</p>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-item">
            <span class="meta-label">Tanggal &amp; Waktu</span>
            <span class="meta-val">{{ $transaction->tanggal->format('d/m/Y H:i') }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Kasir</span>
            <span class="meta-val">{{ $transaction->user->nama }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Metode Pembayaran</span>
            <span class="meta-val">{{ $transaction->metode_bayar }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Status</span>
            <span class="meta-val">Lunas</span>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="col-no" style="width: 5%;">No</th>
                    <th>Nama Menu</th>
                    <th class="text-right" style="width: 20%;">Harga Satuan</th>
                    <th class="text-center" style="width: 15%;">Qty</th>
                    <th class="text-right" style="width: 25%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $index => $detail)
                <tr>
                    <td class="col-no text-zinc-400 tabular-nums">{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $detail->product->nama_menu }}</td>
                    <td class="text-right tabular-nums">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                    <td class="text-center tabular-nums font-semibold">{{ $detail->jumlah_beli }}</td>
                    <td class="text-right tabular-nums font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary-container">
        <div class="summary-box">
            <div class="summary-row">
                <span>Subtotal Pesanan</span>
                <span class="tabular-nums font-semibold">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Pajak (PB1)</span>
                <span class="tabular-nums font-semibold">Rp 0</span>
            </div>
            <div class="summary-row total-row">
                <span>Total Belanja</span>
                <span class="tabular-nums">Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Bayar ({{ $transaction->metode_bayar }})</span>
                <span class="tabular-nums font-semibold">Rp {{ number_format($transaction->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            @if($transaction->metode_bayar === 'Cash')
            <div class="summary-row">
                <span>Kembalian</span>
                <span class="tabular-nums font-semibold">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="footer-section">
        <p style="font-weight: 600; color: #27272a;">Terima kasih atas kunjungan Anda di Cafe RJ</p>
        <p>Struk ini merupakan bukti pembayaran yang sah.</p>
    </div>
</div>

<script>
function printFull() {
    document.getElementById('receipt-box').classList.remove('mode-thermal');
    window.print();
}

function printThermal() {
    document.getElementById('receipt-box').classList.add('mode-thermal');
    window.print();
}

window.addEventListener('load', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('print') !== 'false') {
        setTimeout(function() { window.print(); }, 350);
    }
});
</script>

</body>
</html>
