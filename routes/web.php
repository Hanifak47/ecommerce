<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama (home)
Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

// route melihat produk
Route::get('/product/{product:slug}', [\App\Http\Controllers\ProductController::class, 'view'])->name('product.view');

// Route untuk halaman dashboard (membutuhkan otentikasi)v
// verified disini untuk memastikan yg login adalah yg terautohirsazion dan terverifikasi emailnya
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
