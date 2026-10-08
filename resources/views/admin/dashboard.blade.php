@extends('layouts.app')

@section('title', 'Ringkasan')
@section('section', 'Ringkasan operasional')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">Panel administrator</p>
            <h1>Selamat datang, {{ auth()->user()->name }}</h1>
            <p class="subheading">Pantau kondisi inventaris dan aktivitas toko Anda hari ini.</p>
        </div>
        <a class="button" href="{{ route('products.create') }}">＋ Tambah produk</a>
    </div>

    <section class="stats-grid" aria-label="Ringkasan toko">
        <article class="stat-card">
            <div class="stat-top"><span>Total produk</span><span class="stat-icon">▤</span></div>
            <div class="stat-value">{{ number_format($productCount, 0, ',', '.') }}</div>
            <div class="stat-note">Jenis produk terdaftar</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Nilai inventaris</span><span class="stat-icon">◈</span></div>
            <div class="stat-value" style="font-size:24px">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</div>
            <div class="stat-note">Perkiraan nilai stok saat ini</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Harga modal stok</span><span class="stat-icon">◇</span></div>
            <div class="stat-value" style="font-size:24px">Rp {{ number_format($costValue, 0, ',', '.') }}</div>
            <div class="stat-note">{{ $uncostedProducts }} produk belum memiliki modal</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Transaksi hari ini</span><span class="stat-icon">◷</span></div>
            <div class="stat-value">{{ number_format($todaySales, 0, ',', '.') }}</div>
            <div class="stat-note">Semua kasir</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span>Penjualan hari ini</span><span class="stat-icon">↗</span></div>
            <div class="stat-value" style="font-size:24px">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div class="stat-note">Dari transaksi tersimpan</div>
        </article>
    </section>

    <section class="stats-grid" style="grid-template-columns:repeat(3,minmax(0,1fr));margin-top:14px">
        <a class="stat-card" href="{{ route('admin.categories.index') }}" style="text-decoration:none"><div class="stat-top"><span>Kategori</span><span class="stat-icon">▦</span></div><div class="stat-value">{{ $categoryCount }}</div><div class="stat-note">Kelola kelompok produk</div></a>
        <a class="stat-card" href="{{ route('admin.suppliers.index') }}" style="text-decoration:none"><div class="stat-top"><span>Supplier</span><span class="stat-icon">♧</span></div><div class="stat-value">{{ $supplierCount }}</div><div class="stat-note">Kelola pemasok toko</div></a>
        <a class="stat-card" href="{{ route('admin.users.index') }}" style="text-decoration:none"><div class="stat-top"><span>Pengguna</span><span class="stat-icon">♙</span></div><div class="stat-value">{{ $userCount }}</div><div class="stat-note">Atur admin dan kasir</div></a>
    </section>

    <section class="content-grid">
        <article class="card">
            <div class="card-heading">
                <div><h2>Transaksi terbaru</h2><p>Aktivitas penjualan yang tercatat di sistem.</p></div>
                <a class="button secondary small" href="{{ route('admin.transactions') }}">Lihat semua</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nomor transaksi</th><th>Kasir</th><th>Total</th><th>Waktu</th></tr></thead>
                    <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td><a class="cell-title" href="{{ route('sales.show', $sale) }}">{{ $sale->invoice_number }}</a></td>
                            <td>{{ $sale->cashier->name }}</td>
                            <td class="money">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                            <td>{{ $sale->created_at->format('H:i') }}<div class="cell-muted">{{ $sale->created_at->format('d/m/Y') }}</div></td>
                        </tr>
                    @empty
                        <tr><td colspan="4"><div class="empty-state">Belum ada transaksi. Data penjualan akan muncul di sini.</div></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </article>
        <article class="card">
            <div class="card-heading">
                <div><h2>Perlu diperhatikan</h2><p>Produk dengan stok menipis (10 unit atau kurang).</p></div>
            </div>
            @forelse($lowStockProducts as $product)
                <div style="display:flex;justify-content:space-between;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--line)">
                    <div><div class="cell-title">{{ $product->name }}</div><div class="cell-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</div></div>
                    <span class="badge {{ $product->stock === 0 ? 'danger' : 'warning' }}">{{ $product->stock }} tersisa</span>
                </div>
            @empty
                <div class="empty-state">Semua stok produk berada dalam kondisi baik.</div>
            @endforelse
            <a class="button secondary" href="{{ route('products.index') }}" style="width:100%;margin-top:18px">Kelola inventaris</a>
        </article>
    </section>
@endsection
