<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\PredictionController; // Ini mungkin controller untuk user biasa?
use App\Http\Controllers\DiagnosisController; // Controller untuk kuesioner pasien
use App\Http\Controllers\Admin\OutcomeController; // Kemungkinan tidak terpakai
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DetailPenggunaController;
use App\Http\Controllers\Admin\AdminDiagnosisController;
use App\Http\Controllers\RiwayatDiagnosisController;
use App\Http\Controllers\Admin\MeditationController;
use App\Http\Controllers\Admin\QuoteController;


// --- RUTE PUBLIK / UMUM ---

// Halaman landing
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Rute untuk halaman diagnosis (bisa diakses tanpa login) - Untuk Pasien/User Biasa
Route::get('/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('diagnosis.form');
Route::post('/diagnosis', [DiagnosisController::class, 'submitDiagnosis'])->name('diagnosis.submit');

// Rute untuk pengujian koneksi MongoDB
Route::get('/test-mongo', function () {
    try {
        $mongo = DB::connection('mongodb')->getMongoClient();
        $collection = $mongo->diagnosa->test_koneksi;
        $collection->insertOne([
            'check' => 'MongoDB Connected',
            'time' => now(),
        ]);
        return response()->json(['message' => 'Tersambung ke MongoDB!']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Gagal konek: ' . $e->getMessage()]);
    }
})->name('test.mongo');


// --- RUTE YANG MEMERLUKAN AUTENTIKASI (PENGGUNA BIASA) ---
Route::middleware('auth')->group(function () {
    // Rute untuk dashboard umum (akan mengarahkan ke dashboard admin jika user adalah admin)
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) { // Pastikan method isAdmin() ada di model User Anda
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); // View untuk pengguna biasa
    })->name('dashboard');

    // Rute untuk fitur prediksi (jika ini untuk pengguna biasa)
    Route::get('/predict', [PredictionController::class, 'showCreateForm'])->name('predictions.create');
    Route::post('/predict', [PredictionController::class, 'predict'])->name('predictions.predict');
    Route::get('/history', [PredictionController::class, 'showHistory'])->name('predictions.history');

    // Rute untuk profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- RUTE KHUSUS ADMIN ---
// Semua rute di dalam grup ini memerlukan autentikasi DAN peran 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // --- Rute untuk Manajemen Pengguna (DetailPenggunaController) ---
    // Rute utama untuk menampilkan daftar pengguna
    Route::get('/detail-pengguna', [DetailPenggunaController::class, 'index'])->name('detailpengguna'); // Nama rute sekarang 'admin.detailpengguna'
    Route::get('/detail-pengguna/{id}/edit', [DetailPenggunaController::class, 'edit'])->name('detailpengguna.edit');
    Route::put('/detail-pengguna/{id}', [DetailPenggunaController::class, 'update'])->name('detailpengguna.update');
    Route::delete('/detail-pengguna/{id}', [DetailPenggunaController::class, 'destroy'])->name('detailpengguna.destroy');


    // --- Rute untuk Daftar Diagnosis yang Menunggu Prediksi Admin (AdminDiagnosisController) ---
    // Ini yang akan menampilkan view admindiagnosis.blade.php
    Route::get('/diagnosis-pending', [AdminDiagnosisController::class, 'listForPrediction'])->name('diagnosis.pending');
    // Proses prediksi oleh admin
    Route::post('/diagnosis-predict/{id}', [AdminDiagnosisController::class, 'prediksi'])->name('diagnosis.prediksi');


    // --- Rute untuk Riwayat Diagnosis (RiwayatDiagnosisController) ---
    // Ini menampilkan semua riwayat diagnosis, termasuk yang sudah diproses admin/user.
    Route::get('/riwayat-diagnosis', [RiwayatDiagnosisController::class, 'index'])->name('riwayatdiagnosis.index');

    // Rute untuk Manajemen Meditasi
    Route::get('/meditations', [MeditationController::class, 'index'])->name('meditations.index');
    Route::post('/meditations', [MeditationController::class, 'store'])->name('meditations.store');
    Route::delete('/meditations/{meditation}', [MeditationController::class, 'destroy'])->name('meditations.destroy');

    // Rute untuk Manajemen Quotes & Affirmation
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
});


// --- RUTE AUTENTIKASI BAWAAN LARAVEL BREEZE/FORTIFY ---
require __DIR__.'/auth.php';