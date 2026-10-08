@extends('layouts.app')

@section('title', 'Inventaris')
@section('section', 'Pengelolaan inventaris')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Katalog toko</p><h1>Inventaris produk</h1><p class="subheading">Kelola detail produk, harga jual, dan ketersediaan stok.</p></div>
        <a class="button" href="{{ route('products.create') }}">＋ Tambah produk</a>
    </div>
    <section class="card">
        <div class="card-heading"><div><h2>Semua produk</h2><p>{{ number_format($products->total(), 0, ',', '.') }} produk ditemukan</p></div></div>
        <form method="GET" action="{{ route('products.index') }}" class="form-grid" style="grid-template-columns:minmax(180px,1fr) minmax(180px,.6fr) auto;align-items:end;margin-bottom:18px">
            <div class="form-field"><label for="search">Cari nama atau barcode</label><input id="search" name="search" value="{{ $search }}" placeholder="Ketik nama / barcode"></div>
            <div class="form-field"><label for="category_id">Kategori</label><select id="category_id" name="category_id"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>@endforeach</select></div>
            <button class="button secondary" type="submit">Cari produk</button>
        </form>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Produk</th><th>Kategori</th><th>Harga modal / jual</th><th>Stok</th><th>Status</th><th>Barcode</th><th></th></tr></thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td><div class="cell-title">{{ $product->name }}</div><div class="cell-muted">{{ $product->description ?: 'Tanpa deskripsi' }}</div></td>
                        <td>{{ $product->category?->name ?? 'Tanpa kategori' }}</td>
                        <td><div>Jual <span class="money">Rp {{ number_format($product->price, 0, ',', '.') }}</span></div><div class="cell-muted">Modal {{ $product->cost_price === null ? 'Belum diatur' : 'Rp '.number_format($product->cost_price, 0, ',', '.') }}</div></td>
                        <td>{{ number_format($product->stock, 0, ',', '.') }} unit</td>
                        <td><span class="badge {{ $product->stock === 0 ? 'danger' : ($product->stock <= 10 ? 'warning' : '') }}">{{ $product->stock === 0 ? 'Habis' : ($product->stock <= 10 ? 'Menipis' : 'Tersedia') }}</span></td>
                        <td>{{ $product->barcode ?: '—' }}</td>
                        <td style="white-space:nowrap">
                            <a class="button secondary small" href="{{ route('products.edit', $product) }}">Ubah</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus produk ini dari inventaris?')">
                                @csrf @method('DELETE')
                                <button class="button danger small" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state">Belum ada produk. Tambahkan produk pertama untuk mulai membangun inventaris.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())<div class="pagination">{{ $products->links() }}</div>@endif
    </section>
@endsection
