<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Produk - Minimarket</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #fff; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 8px 12px; text-decoration: none; border: none; cursor: pointer; border-radius: 4px; }
        .btn-add { background-color: #4CAF50; color: white; font-weight: bold; }
        .btn-edit { background-color: #2196F3; color: white; margin-right: 5px; }
        .btn-delete { background-color: #f44336; color: white; }
        .alert { padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Daftar Manajemen Produk</h1>

    <!-- Notifikasi sukses jika ada operasi CRUD -->
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Navigasi ke Form Tambah -->
    <a href="{{ route('products.create') }}" class="btn btn-add">+ Tambah Produk Baru</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Deskripsi Lengkap</th>
                <th>Harga Satuan</th>
                <th>Jumlah Stok</th>
                <th>Aksi Pengelolaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->description ?? '-' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }} unit</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">Edit</a>
                        
                        <!-- Form Tombol Hapus -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 20px;">
                        Data produk masih kosong. Silakan tambahkan produk baru terlebih dahulu.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
