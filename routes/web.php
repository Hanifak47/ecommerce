<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama (home)
Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

// Route untuk halaman dashboard (membutuhkan otentikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
