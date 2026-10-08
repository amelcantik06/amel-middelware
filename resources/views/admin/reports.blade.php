@extends('layouts.app')

@section('title', 'Laporan')
@section('section', 'Analisis · Laporan')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Analisis penjualan</p><h1>Laporan toko</h1><p class="subheading">Ringkasan omzet, modal barang, dan laba kotor pada periode terpilih.</p></div>
    </div>
    <section class="card" style="margin-bottom:18px">
        <form method="GET" action="{{ route('admin.reports') }}" class="form-grid" style="grid-template-columns:1fr 1fr auto;align-items:end">
            <div class="form-field"><label for="from">Dari tanggal</label><input id="from" type="date" name="from" value="{{ $from->format('Y-m-d') }}" required></div>
            <div class="form-field"><label for="to">Sampai tanggal</label><input id="to" type="date" name="to" value="{{ $to->format('Y-m-d') }}" required></div>
            <button class="button" type="submit">Tampilkan laporan</button>
        </form>
        @if($errors->any())<div class="alert error" role="alert" style="margin:14px 0 0">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    </section>

    <section class="stats-grid" aria-label="Ringkasan laporan">
        <article class="stat-card"><div class="stat-top"><span>Transaksi</span><span class="stat-icon">◷</span></div><div class="stat-value">{{ number_format($summary['count'], 0, ',', '.') }}</div><div class="stat-note">Periode {{ $from->format('d/m/Y') }} – {{ $to->format('d/m/Y') }}</div></article>
        <article class="stat-card"><div class="stat-top"><span>Omzet</span><span class="stat-icon">↗</span></div><div class="stat-value" style="font-size:24px">Rp {{ number_format($summary['revenue'], 0, ',', '.') }}</div><div class="stat-note">Total pembayaran terjual</div></article>
        <article class="stat-card"><div class="stat-top"><span>Harga modal</span><span class="stat-icon">◇</span></div><div class="stat-value" style="font-size:24px">Rp {{ number_format($summary['cost'], 0, ',', '.') }}</div><div class="stat-note">HPP dari transaksi tercatat</div></article>
        <article class="stat-card"><div class="stat-top"><span>Laba kotor</span><span class="stat-icon">◎</span></div><div class="stat-value" style="font-size:24px">{{ $summary['profit'] === null ? 'Belum akurat' : 'Rp '.number_format($summary['profit'], 0, ',', '.') }}</div><div class="stat-note">{{ $summary['profit'] === null ? 'Ada item transaksi tanpa harga modal.' : 'Omzet dikurangi HPP.' }}</div></article>
    </section>

    @if($summary['uncosted'] > 0)
        <div class="alert error" role="alert">Laba belum dapat dihitung akurat: {{ $summary['uncosted'] }} baris transaksi tidak memiliki snapshot harga modal. Isi harga modal pada produk untuk transaksi berikutnya; transaksi lama tidak diubah.</div>
    @endif

    <section class="card" style="margin-bottom:18px">
        <div class="card-heading">
            <div><h2>Penjualan per hari</h2><p>Rangkuman transaksi berdasarkan tanggal.</p></div>
            <a class="button secondary" href="{{ route('admin.reports.export', ['from' => $from->format('Y-m-d'), 'to' => $to->format('Y-m-d')]) }}">↓ Ekspor CSV</a>
        </div>
        <div class="table-wrap"><table>
            <thead><tr><th>Tanggal</th><th>Transaksi</th><th>Omzet</th></tr></thead>
            <tbody>
            @forelse($daily as $day)
                <tr><td class="cell-title">{{ \Illuminate\Support\Carbon::parse($day->sale_date)->format('d/m/Y') }}</td><td>{{ $day->transactions }}</td><td class="money">Rp {{ number_format($day->revenue, 0, ',', '.') }}</td></tr>
            @empty<tr><td colspan="3"><div class="empty-state">Tidak ada transaksi di periode ini.</div></td></tr>@endforelse
            </tbody>
        </table></div>
    </section>

    <section class="card">
        <div class="card-heading"><div><h2>Rincian transaksi</h2><p>{{ $sales->total() }} transaksi pada rentang tanggal tersebut.</p></div></div>
        <div class="table-wrap"><table>
            <thead><tr><th>Nomor transaksi</th><th>Kasir</th><th>Item</th><th>Omzet</th><th>Waktu</th><th></th></tr></thead>
            <tbody>
            @forelse($sales as $sale)
                <tr><td class="cell-title">{{ $sale->invoice_number }}</td><td>{{ $sale->cashier->name }}</td><td>{{ $sale->items_count }}</td><td class="money">Rp {{ number_format($sale->total, 0, ',', '.') }}</td><td>{{ $sale->created_at->format('d/m/Y H:i') }}</td><td><a class="button secondary small" href="{{ route('sales.show', $sale) }}">Detail</a></td></tr>
            @empty<tr><td colspan="6"><div class="empty-state">Tidak ada transaksi di periode ini.</div></td></tr>@endforelse
            </tbody>
        </table></div>
        @if($sales->hasPages())<div class="pagination">{{ $sales->links() }}</div>@endif
    </section>
@endsection
