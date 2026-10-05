<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Minimarket Modern</title>
    <!-- Import Font Modern Google Inter -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --success: #10b981;
            --success-hover: #059669;
            --warning: #f59e0b;
            --warning-hover: #d97706;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --background: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            padding: 30px 20px;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Style */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 24px 32px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            margin-bottom: 24px;
            border: 1px solid var(--border);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .header p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Buttons Styling */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-add {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .btn-add:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-edit {
            background-color: #f1f5f9;
            color: var(--text-main);
            border: 1px solid var(--border);
            margin-right: 8px;
        }

        .btn-edit:hover {
            background-color: #e2e8f0;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: #fca5a5;
            color: #7f1d1d;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Alert Toast */
        .alert {
            padding: 16px 20px;
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Content Card & Table Container */
        .card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f8fafc;
            padding: 16px 24px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            color: #334155;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .product-name {
            font-weight: 600;
            color: var(--text-main);
            font-size: 15px;
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 13px;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Badges */
        .badge-price {
            background-color: #eff6ff;
            color: #1e40af;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-family: monospace;
            font-size: 14px;
        }

        .badge-stock {
            background-color: #f0fdf4;
            color: #166534;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-stock.empty {
            background-color: #9f14e5;
            color: #991b1b;
        }

        .empty-state {
            padding: 60px 24px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Flash Alert Sukses -->
    @if(session('success'))
        <div class="alert">
            ✨ {{ session('success') }}
        </div>
    @endif

    <!-- Modern App Header -->
    <header class="header">
        <div>
            <h1>Dashboard Minimarket</h1>
            <p>Kelola inventaris data produk toko Anda dalam satu panel instan.</p>
        </div>
        <div class="header-actions">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="btn btn-add">
                        <span style="margin-right: 8px; font-size: 16px;">+</span> Tambah Produk Baru
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-edit">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-edit">Masuk</a>
            @endauth
        </div>
    </header>

    <!-- Main Table Card -->
    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Informasi Produk</th>
                        <th>Harga Satuan</th>
                        <th>Status Stok</th>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <th style="width: 200px; text-align: right;">Aksi Panel</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                   @forelse($products as $product)
    <tr>
        {{-- ID Produk --}}
        <td>
            <span style="color: var(--text-muted); font-weight: 500;">
                #{{ $product->id }}
            </span>
        </td>

        {{-- Informasi Produk --}}
        <td>
            <div class="product-name">
                {{ $product->name }}
            </div>

            <div
                class="product-desc"
                title="{{ $product->description }}"
            >
                {{ $product->description ?: 'Tidak ada keterangan produk.' }}
            </div>
        </td>

        {{-- Harga --}}
        <td>
            <span class="badge-price">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
        </td>

        {{-- Stok --}}
        <td>
            @if($product->stock > 0)
                <span class="badge-stock">
                    {{ $product->stock }} Tersedia
                </span>
            @else
                <span class="badge-stock empty">
                    🔴 Habis
                </span>
            @endif
        </td>

        {{-- Aksi --}}
        @auth
        @if(auth()->user()->role === 'admin')
        <td style="text-align: right;">
            <div style="display: inline-flex; align-items: center; gap: 8px;">

                {{-- Tombol Edit --}}
                <a
                    href="{{ route('products.edit', $product->id) }}"
                    class="btn btn-edit"
                >
                    ✏️ Ubah
                </a>

                {{-- Tombol Hapus --}}
                <form
                    action="{{ route('products.destroy', $product->id) }}"
                    method="POST"
                    onsubmit="return confirm('Hapus data produk ini permanen?')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-delete"
                    >
                        🗑️ Hapus
                    </button>
                </form>

            </div>
        </td>
        @endif
        @endauth
    </tr>

@empty

    {{-- Jika produk belum ada --}}
    <tr>
        <td colspan="{{ auth()->check() && auth()->user()->role === 'admin' ? 5 : 4 }}">
            <div class="empty-state">

                <!-- Icon Box Empty -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    style="width: 48px; height: 48px; margin-bottom: 16px;"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.245 2.118H6.62a2.25 2.25 0 01-2.245-2.118L3.75 7.5m16.5 0h-16.5m14.25 0l-1.5-3.375A2.25 2.25 0 0014.945 3h-5.89a2.25 2.25 0 00-2.055 1.125L5.5 7.5m5.25 4.5v4.5m3-4.5v4.5"
                    />
                </svg>

                <h3>Belum Ada Produk</h3>

                <p>
                    Belum ada data produk yang tersedia.
                </p>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a
                            href="{{ route('products.create') }}"
                            class="btn btn-add"
                            style="margin-top: 15px;"
                        >
                            ➕ Tambah Produk Baru
                        </a>
                    @endif
                @endauth

            </div>
        </td>
    </tr>

@endforelse

            </tbody>
        </table>
    </div>
</div>

