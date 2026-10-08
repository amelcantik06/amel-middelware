@extends('layouts.app')

@section('title', 'Kategori')
@section('section', 'Master data · Kategori')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Master data</p><h1>Kategori produk</h1><p class="subheading">Kelompokkan produk agar inventaris dan laporan lebih mudah dibaca.</p></div>
    </div>
    <section class="content-grid" style="grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr);align-items:start">
        <article class="card">
            <div class="card-heading"><div><h2>Tambah kategori</h2><p>Nama kategori harus unik.</p></div></div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-field"><label for="name">Nama kategori</label><input id="name" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Contoh: Minuman"></div>
                <div class="form-field" style="margin-top:15px"><label for="description">Deskripsi</label><textarea id="description" name="description" rows="3" maxlength="2000" placeholder="Keterangan opsional">{{ old('description') }}</textarea></div>
                <button class="button" type="submit" style="width:100%;margin-top:17px">Simpan kategori</button>
            </form>
        </article>
        <article class="card">
            <div class="card-heading"><div><h2>Daftar kategori</h2><p>{{ $categories->total() }} kategori terdaftar.</p></div></div>
            <div class="table-wrap"><table>
                <thead><tr><th>Kategori</th><th>Produk</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong><div class="cell-muted">{{ $category->description ?: 'Tidak ada deskripsi' }}</div></td>
                        <td>{{ $category->products_count }}</td>
                        <td style="min-width:245px">
                            <form action="{{ route('admin.categories.update', $category) }}" method="POST" style="display:grid;gap:6px">
                                @csrf @method('PUT')
                                <input class="input" name="name" value="{{ $category->name }}" aria-label="Nama kategori" required>
                                <input class="input" name="description" value="{{ $category->description }}" aria-label="Deskripsi kategori" placeholder="Deskripsi (opsional)">
                                <button class="button secondary small" type="submit">Ubah</button>
                            </form>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="margin-top:7px" onsubmit="return confirm('Hapus kategori ini? Produk tidak ikut terhapus.')">
                                @csrf @method('DELETE')<button class="button danger small" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty<tr><td colspan="3"><div class="empty-state">Belum ada kategori.</div></td></tr>@endforelse
                </tbody>
            </table></div>
            @if($categories->hasPages())<div class="pagination">{{ $categories->links() }}</div>@endif
        </article>
    </section>
@endsection
