<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Menampilkan Semua Data
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // 2. Menampilkan Form Tambah
    public function create()
    {
        return view('products.create');
    }

    // 3. Menyimpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create($request->all());
        return redirect('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 5. Memperbarui Data
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update($request->all());
        return redirect('/products')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. Menghapus Data
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('success', 'Produk berhasil dihapus!');
    }
}


