<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Route ke halaman landing (tanpa login)
Route::get('/', function () {
    return view('landing');
});

// Route ke dashboard pakai controller, harus login & terverifikasi
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group route yang butuh autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', function () {
    return view('admin_dashboard');
})->name('admin_dashboard');

Route::get('/admin/tambah', function () {
    return view('tambah_admin');
})->name('tambah_admin');



// Route tambahan dari Laravel Breeze/Fortify
require __DIR__.'/auth.php';
