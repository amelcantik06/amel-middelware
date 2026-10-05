<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Minimarket
|--------------------------------------------------------------------------
*/

// 1. Route untuk Halaman Utama / Beranda
Route::get('/', [ProductController::class, 'index'])
    ->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// 2. Route otomatis CRUD untuk Panel Pengelolaan Produk
Route::resource('products', ProductController::class)->middleware('admin');


// 3. Route untuk Halaman Admin
Route::get('/admin', function () {
    return redirect()->route('products.index');
})->middleware('admin')->name('admin');


// 4. Route untuk Halaman Kasir
Route::get('/kasir', function () {
    return 'Selamat datang di Halaman Kasir!';
})->middleware('kasir');