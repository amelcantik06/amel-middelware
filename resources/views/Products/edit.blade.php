@extends('layouts.app')

@section('title', 'Ubah produk')
@section('section', 'Inventaris · Ubah produk')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">Katalog toko</p><h1>Ubah produk</h1><p class="subheading">Perbarui informasi {{ $product->name }}.</p></div>
        <a class="button secondary" href="{{ route('products.index') }}">Kembali ke inventaris</a>
    </div>
    <section class="card" style="max-width:780px">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-field full">
                    <label for="name">Nama produk</label>
                    <input id="name" name="name" value="{{ old('name', $product->name) }}" maxlength="255" required>
                    @error('name')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id">
                        <option value="">Tanpa kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="barcode">Barcode <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <input id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" maxlength="100" placeholder="Pindai atau masukkan barcode">
                    @error('barcode')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field full">
                    <label for="description">Deskripsi <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    @error('description')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="price">Harga jual (Rp)</label>
                    <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="1" required>
                    @error('price')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="cost_price">Harga modal (Rp) <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                    <input id="cost_price" type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" min="0" step="1" placeholder="Diisi agar laporan laba akurat">
                    @error('cost_price')<span class="input-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="stock">Stok saat ini</label>
                    <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" step="1" required>
                    @error('stock')<span class="input-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px">
                <a class="button secondary" href="{{ route('products.index') }}">Batal</a>
                <button class="button" type="submit">Simpan perubahan</button>
            </div>
        </form>
    </section>
@endsection
