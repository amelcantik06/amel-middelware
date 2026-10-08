@extends('layouts.app')

@section('title', 'Tambah produk')
@section('section', 'Inventaris · Produk baru')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Katalog toko</p><h1>Tambah produk</h1><p class="subheading">Lengkapi informasi produk untuk dicatat ke inventaris.</p></div>
        <a class="button secondary" href="{{ route('products.index') }}">Kembali ke inventaris</a>
    </div>
    <section class="card" style="max-width:780px">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-field full">
                    <label for="name">Nama produk</label>
                    <input id="name" name="name" value="{{ old('name') }}" maxlength="255" placeholder="Contoh: Kopi susu 250 ml" required>
                    @error('name')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id">
                        <option value="">Tanpa kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="barcode">Barcode <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <input id="barcode" name="barcode" value="{{ old('barcode') }}" maxlength="100" placeholder="Pindai atau masukkan barcode">
                    @error('barcode')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field full">
                    <label for="description">Deskripsi <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <textarea id="description" name="description" rows="4" placeholder="Informasi singkat tentang produk">{{ old('description') }}</textarea>
                    @error('description')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="price">Harga jual (Rp)</label>
                    <input id="price" type="number" name="price" value="{{ old('price') }}" min="0" step="1" placeholder="0" required>
                    @error('price')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="cost_price">Harga modal (Rp) <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price') }}" min="0" step="1" placeholder="Diisi agar laporan laba akurat">
                    @error('cost_price')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="stock">Stok awal</label>
                    <input id="stock" type="number" name="stock" value="{{ old('stock') }}" min="0" step="1" placeholder="0" required>
                    @error('stock')<span class="input-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px">
                <a class="button secondary" href="{{ route('products.index') }}">Batal</a>
                <button class="button" type="submit">Simpan produk</button>
            </div>
        </form>
    </section>
@endsection
