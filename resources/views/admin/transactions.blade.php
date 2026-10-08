@extends('layouts.app')

@section('title', 'Transaksi')
@section('section', 'Penjualan toko')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Aktivitas toko</p><h1>Semua transaksi</h1><p class="subheading">Riwayat penjualan dari seluruh kasir.</p></div>
    </div>
    <section class="card">
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nomor transaksi</th><th>Kasir</th><th>Item</th><th>Total</th><th>Pembayaran</th><th>Tanggal</th><th></th></tr></thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td class="cell-title">{{ $sale->invoice_number }}</td>
                        <td>{{ $sale->cashier->name }}</td>
                        <td>{{ $sale->items_count }} produk</td>
                        <td class="money">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        <td><span class="badge">Lunas</span></td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td><a class="button secondary small" href="{{ route('sales.show', $sale) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state">Belum ada transaksi yang tercatat.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())<div class="pagination">{{ $sales->links() }}</div>@endif
    </section>
@endsection
