@extends('layouts.app')

@section('title', 'Supplier')
@section('section', 'Master data · Supplier')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Master data</p><h1>Supplier</h1><p class="subheading">Simpan kontak pemasok untuk mencatat penerimaan stok dengan rapi.</p></div>
    </div>
    <section class="content-grid" style="grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr);align-items:start">
        <article class="card">
            <div class="card-heading"><div><h2>Tambah supplier</h2><p>Informasi kontak bisa dilengkapi kemudian.</p></div></div>
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="form-field"><label for="name">Nama supplier</label><input id="name" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Nama perusahaan"></div>
                <div class="form-field" style="margin-top:13px"><label for="contact_name">Nama kontak</label><input id="contact_name" name="contact_name" maxlength="255" value="{{ old('contact_name') }}" placeholder="Nama perwakilan"></div>
                <div class="form-grid" style="margin-top:13px">
                    <div class="form-field"><label for="phone">Telepon</label><input id="phone" name="phone" maxlength="40" value="{{ old('phone') }}" placeholder="08xx"></div>
                    <div class="form-field"><label for="email">Email</label><input id="email" type="email" name="email" maxlength="255" value="{{ old('email') }}" placeholder="supplier@email.com"></div>
                </div>
                <div class="form-field" style="margin-top:13px"><label for="address">Alamat</label><textarea id="address" name="address" rows="3" maxlength="2000">{{ old('address') }}</textarea></div>
                <button class="button" type="submit" style="width:100%;margin-top:17px">Simpan supplier</button>
            </form>
        </article>
        <article class="card">
            <div class="card-heading"><div><h2>Daftar supplier</h2><p>{{ $suppliers->total() }} supplier terdaftar.</p></div></div>
            <div class="table-wrap"><table>
                <thead><tr><th>Supplier / kontak</th><th>Riwayat</th><th>Perbarui data</th><th></th></tr></thead>
                <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td><strong>{{ $supplier->name }}</strong><div class="cell-muted">{{ $supplier->contact_name ?: 'Kontak belum diisi' }}</div></td>
                        <td>{{ $supplier->stock_receipts_count }}</td>
                        <td style="min-width:230px">
                            <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" style="display:grid;gap:6px">
                                @csrf @method('PUT')
                                <input class="input" name="name" value="{{ $supplier->name }}" aria-label="Nama supplier" required>
                                <input class="input" name="contact_name" value="{{ $supplier->contact_name }}" aria-label="Nama kontak" placeholder="Nama kontak">
                                <input class="input" name="phone" value="{{ $supplier->phone }}" aria-label="Telepon" placeholder="Telepon">
                                <input class="input" type="email" name="email" value="{{ $supplier->email }}" aria-label="Email" placeholder="Email">
                                <input class="input" name="address" value="{{ $supplier->address }}" aria-label="Alamat" placeholder="Alamat">
                                <button class="button secondary small" type="submit">Simpan perubahan</button>
                            </form>
                        </td>
                        <td style="white-space:nowrap">
                            <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Hapus supplier ini? Riwayat stok masuk tetap tersimpan.')">
                                @csrf @method('DELETE')<button class="button danger small" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty<tr><td colspan="4"><div class="empty-state">Belum ada supplier terdaftar.</div></td></tr>@endforelse
                </tbody>
            </table></div>
            @if($suppliers->hasPages())<div class="pagination">{{ $suppliers->links() }}</div>@endif
        </article>
    </section>
@endsection
