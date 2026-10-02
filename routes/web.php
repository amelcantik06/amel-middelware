<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Minimarket
|--------------------------------------------------------------------------
*/

// 1. Route untuk Halaman Utama / Beranda
Route::get('/', [ProductController::class, 'index'])
    ->name('home');

// 2. Route otomatis CRUD untuk Panel Pengelolaan Produk
Route::resource('products', ProductController::class);


// 3. Route untuk Halaman Admin
Route::get('/admin', function () {
    return 'Selamat datang di Halaman Admin!';
})->middleware('admin');


// 4. Route untuk Halaman Kasir
Route::get('/kasir', function () {
    return 'Selamat datang di Halaman Kasir!';
})->middleware('kasir');