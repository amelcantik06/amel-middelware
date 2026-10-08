@extends('layouts.app')

@section('title', 'Riwayat transaksi')
@section('section', 'Kasir · Riwayat')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Catatan penjualan</p><h1>Riwayat transaksi saya</h1><p class="subheading">Semua transaksi yang Anda proses.</p></div>
        <a class="button" href="{{ route('kasir') }}">＋ Transaksi baru</a>
    </div>
    <section class="card">
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nomor transaksi</th><th>Item</th><th>Total</th><th>Dibayar</th><th>Kembalian</th><th>Waktu</th><th></th></tr></thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td class="cell-title">{{ $sale->invoice_number }}</td>
                        <td>{{ $sale->items_count }} produk</td>
                        <td class="money">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sale->amount_paid, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sale->change_due, 0, ',', '.') }}</td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td><a class="button secondary small" href="{{ route('sales.show', $sale) }}">Struk</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state">Belum ada transaksi yang Anda proses.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())<div class="pagination">{{ $sales->links() }}</div>@endif
    </section>
@endsection
