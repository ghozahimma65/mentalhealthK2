<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTambahController;
use App\Http\Controllers\AuthController;


// Halaman landing
Route::get('/', function () {
    return view('landing');
});

// Rute untuk halaman dashboard umum
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Rute untuk Tambah Admin
        // GET untuk menampilkan form tambah admin
        Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah'); // Ini akan membuat rute bernama 'admin.tambah'

        // POST untuk menyimpan data admin baru
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store'); // Ini akan membuat rute bernama 'admin.tambah.store'

        // Rute untuk Gejala
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
});
Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
});



// Auth routes dari Laravel Breeze
require __DIR__.'/auth.php';
