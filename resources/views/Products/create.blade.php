<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; }
        .form-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #2196F3; text-decoration: none; }
        .error-list { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="form-container">
    <a href="{{ route('products.index') }}" class="btn-back">&larr; Kembali ke Daftar Produk</a>
    <h2>Form Tambah Produk Baru</h2>

    <!-- Validasi Input Error -->
    @if ($errors->any())
        <div class="error-list">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Produk:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Indomie Goreng" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk (Opsional):</label>
            <textarea id="description" name="description" rows="4" placeholder="Keterangan isi rasa, ukuran, dll...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga Jual (Rp):</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="Contoh: 3500" required>
        </div>

        <div class="form-group">
            <label for="stock">Stok Awal Barang:</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" placeholder="Contoh: 50" required>
        </div>

        <button type="submit" class="btn-submit">Simpan ke Database</button>
    </form>
</div>

</body>
</html>
