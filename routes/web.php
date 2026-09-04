<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Minimarket
|--------------------------------------------------------------------------
*/

// 1. Rute untuk Halaman Utama / Beranda (welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute otomatis CRUD untuk Panel Pengelolaan Produk (Products/index.blade.php, dll)
Route::resource('products', ProductController::class);

