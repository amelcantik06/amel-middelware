@extends('layouts.app')

@section('title', 'Struk transaksi')
@section('section', 'Detail penjualan')

@push('styles')
<style>
    .receipt-actions { display:flex; justify-content:flex-end; gap:9px; margin-bottom:18px; }
    .receipt-paper { width:100%; max-width:420px; margin:0 auto; padding:28px 26px; border:1px solid var(--line); border-radius:8px; background:#fff; box-shadow:var(--shadow); color:#111; font-family:"Courier New", Courier, monospace; font-size:12px; line-height:1.35; }
    .receipt-center { text-align:center; }
    .receipt-store { margin:0; font-size:19px; font-weight:700; letter-spacing:.035em; line-height:1.15; }
    .receipt-small { margin:3px 0; font-size:10px; }
    .receipt-rule { margin:8px 0; border:0; border-top:1px dashed #555; }
    .receipt-meta { display:grid; grid-template-columns:75px 1fr; gap:2px 5px; font-size:10px; }
    .receipt-meta span:nth-child(odd) { color:#444; }
    .receipt-item { margin:7px 0; }
    .receipt-item-name { margin-bottom:2px; font-size:11px; font-weight:700; overflow-wrap:anywhere; }
    .receipt-item-detail { display:grid; grid-template-columns:minmax(0,1fr) auto; gap:8px; font-size:10px; }
    .receipt-total { display:grid; gap:3px; }
    .receipt-total-line { display:grid; grid-template-columns:minmax(0,1fr) auto; gap:8px; font-size:10px; }
    .receipt-total-line strong { font-weight:700; }
    .receipt-grand { margin:4px 0; padding:5px 0; border-top:1px dashed #555; border-bottom:1px dashed #555; font-size:14px; font-weight:700; }
    .receipt-footer { margin:11px 0 0; font-size:10px; }
    .receipt-cut { height:1px; margin:19px -7px 0; border-top:1px dashed #aaa; }
    @media print {
        @page { size: 80mm auto; margin:0; }
        html, body { width:80mm!important; min-width:80mm!important; max-width:80mm!important; margin:0!important; padding:0!important; background:#fff!important; }
        body { color:#000!important; font-family:Arial, Helvetica, sans-serif!important; font-size:10pt!important; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
        body * { visibility:hidden!important; }
        .receipt-paper, .receipt-paper * { visibility:visible!important; }
        .receipt-paper { position:absolute!important; top:2mm!important; left:2mm!important; width:76mm!important; max-width:76mm!important; margin:0!important; padding:0 1mm!important; border:0!important; border-radius:0!important; box-shadow:none!important; background:#fff!important; color:#000!important; font-family:Arial, Helvetica, sans-serif!important; font-size:10pt!important; line-height:1.3!important; }
        .receipt-store { font-size:16pt!important; }
        .receipt-small { font-size:9pt!important; }
        .receipt-meta, .receipt-item-detail, .receipt-total-line, .receipt-footer { font-size:9pt!important; }
        .receipt-item-name { font-size:10pt!important; }
        .receipt-grand { font-size:12pt!important; }
        .receipt-rule { margin:1.5mm 0!important; }
        .receipt-item { margin:1.8mm 0!important; break-inside:avoid; }
        .receipt-cut { display:none!important; }
    }
</style>
<script>
    const receiptDocumentTitle = document.title;
    window.addEventListener('beforeprint', () => { document.title = ''; });
    window.addEventListener('afterprint', () => { document.title = receiptDocumentTitle; });
</script>
@endpush

@section('content')
    <div class="page-heading no-print">
        <div><p class="eyebrow">Transaksi berhasil</p><h1>Struk penjualan</h1><p class="subheading">Siap dicetak menggunakan printer thermal POS 80 mm.</p></div>
    </div>
    <div class="receipt-actions no-print">
        <button class="button secondary" type="button" onclick="window.print()">Cetak struk POS 80</button>
        <a class="button" href="{{ auth()->user()->role === 'admin' ? route('admin.transactions') : route('kasir.transactions') }}">Kembali</a>
    </div>

    <article class="receipt-paper" aria-label="Struk pembayaran">
        <header class="receipt-center">
            <h2 class="receipt-store">{{ config('app.name', 'MINIMARKET') }}</h2>
            <p class="receipt-small">Terima kasih telah berbelanja</p>
        </header>

        <hr class="receipt-rule">
        <div class="receipt-meta">
            <span>No.</span><strong>{{ $sale->invoice_number }}</strong>
            <span>Tanggal</span><span>{{ $sale->created_at->format('d/m/Y H:i') }}</span>
            <span>Kasir</span><span>{{ $sale->cashier->name }}</span>
            <span>Pelanggan</span><span>{{ $sale->customer_name ?: 'Umum' }}</span>
            @if($sale->customer_reference)
                <span>Member/HP</span><span>{{ $sale->customer_reference }}</span>
            @endif
            <span>Pembayaran</span><span>{{ strtoupper(str_replace('_', ' ', $sale->payment_method)) }}</span>
        </div>

        <hr class="receipt-rule">
        @foreach($sale->items as $item)
            <div class="receipt-item">
                <div class="receipt-item-name">{{ $item->product_name }}</div>
                <div class="receipt-item-detail">
                    <span>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                    <strong>{{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                </div>
            </div>
        @endforeach

        <hr class="receipt-rule">
        <div class="receipt-total">
            <div class="receipt-total-line"><span>Subtotal</span><span>{{ number_format($sale->subtotal, 0, ',', '.') }}</span></div>
            @if($sale->discount_amount > 0)
                <div class="receipt-total-line"><span>Diskon{{ (float) $sale->discount_percent > 0 ? ' ('.rtrim(rtrim(number_format((float) $sale->discount_percent, 2, '.', ''), '0'), '.').'%)' : '' }}</span><span>-{{ number_format($sale->discount_amount, 0, ',', '.') }}</span></div>
            @endif
            @if($sale->tax_amount > 0)
                <div class="receipt-total-line"><span>Pajak/PPN</span><span>{{ number_format($sale->tax_amount, 0, ',', '.') }}</span></div>
            @endif
            @if($sale->additional_fee > 0)
                <div class="receipt-total-line"><span>Biaya lain</span><span>{{ number_format($sale->additional_fee, 0, ',', '.') }}</span></div>
            @endif
            <div class="receipt-total-line receipt-grand"><strong>TOTAL</strong><strong>{{ number_format($sale->total, 0, ',', '.') }}</strong></div>
            <div class="receipt-total-line"><span>Dibayar</span><span>{{ number_format($sale->amount_paid, 0, ',', '.') }}</span></div>
            <div class="receipt-total-line"><strong>Kembalian</strong><strong>{{ number_format($sale->change_due, 0, ',', '.') }}</strong></div>
        </div>

        <footer class="receipt-center receipt-footer">
            <p style="margin:0">Barang yang sudah dibeli tidak dapat</p>
            <p style="margin:0">ditukar atau dikembalikan.</p>
            <p style="margin:5px 0 0">Simpan struk ini sebagai bukti transaksi.</p>
        </footer>
        <div class="receipt-cut" aria-hidden="true"></div>
    </article>
@endsection
