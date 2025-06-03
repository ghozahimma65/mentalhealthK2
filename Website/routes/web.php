<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\DiagnosisController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DetailPenggunaController;
use App\Http\Controllers\Admin\AdminDiagnosisController;
use App\Http\Controllers\RiwayatDiagnosisController;
use App\Http\Controllers\Admin\MeditationController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PredictionHistoryController;
use App\Http\Controllers\Admin\AdminOutcomeController; 
use App\Http\Controllers\Admin\RiwayatOutcomeController;
use App\Http\Controllers\Admin\AdminTambahController;


// --- RUTE PUBLIK / UMUM ---

// Halaman landing page
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


// --- RUTE YANG MEMERLUKAN AUTENTIKASI (PENGGUNA BIASA & ADMIN) ---
// Middleware 'verified' ditambahkan untuk verifikasi email
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/outcome/create', [OutcomeController::class, 'create'])->name('outcome.create');
    // Proses submit form perkembangan
    Route::post('/outcome', [OutcomeController::class, 'store'])->name('outcome.store');
    // Melihat riwayat/progress perkembangan (metode progress() sudah punya logika user/admin)
    Route::get('/outcome/comprehensive-history', [OutcomeController::class, 'viewComprehensiveHistory'])->name('outcome.comprehensive_history'); 
    // Rute untuk detail satu record perkembangan
    Route::get('/outcome/{outcome}', [OutcomeController::class, 'show'])->name('outcome.show');

    Route::get('/predictions/history', [DiagnosisController::class, 'historyIndex'])->name('predictions.history');
    Route::get('/predictions/{diagnosisResult}', [DiagnosisController::class, 'historyShow'])->name('predictions.show');

    Route::get('/history/select-type', [PredictionHistoryController::class, 'selectHistoryType'])->name('history.select_type');
    // --- PENGATURAN PROFIL PENGGUNA ---
    // Uncomment jika Anda menggunakan ProfileController
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin (akan memanggil AdminDashboardController@index)
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

    Route::get('/outcome-pending', [AdminOutcomeController::class, 'listForPrediction'])->name('outcome.pending');
    Route::post('/outcome-predict/{id}', [AdminOutcomeController::class, 'prediksi'])->name('outcome.prediksi');

    // --- Rute untuk Riwayat Diagnosis (RiwayatDiagnosisController) ---
    // Ini menampilkan semua riwayat diagnosis, termasuk yang sudah diproses admin/user.
    Route::get('/riwayat-diagnosis', [RiwayatDiagnosisController::class, 'index'])->name('riwayatdiagnosis.index');

    Route::get('/riwayat-outcome', [RiwayatOutcomeController::class, 'index'])->name('riwayatoutcome.index');

    // Rute untuk Manajemen Meditasi
    Route::get('/meditations', [MeditationController::class, 'index'])->name('meditations.index');
    Route::post('/meditations', [MeditationController::class, 'store'])->name('meditations.store');
    Route::delete('/meditations/{meditation}', [MeditationController::class, 'destroy'])->name('meditations.destroy');

    // Rute untuk Manajemen Quotes & Affirmation
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');

    Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah');
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store');

    Route::get('/classification-trends', [AdminDashboardController::class, 'showClassificationTrends'])->name('classification_trends');
});


// --- RUTE AUTENTIKASI BAWAAN LARAVEL BREEZE/FORTIFY ---

    // Rute untuk admin melihat semua data outcome dari semua pengguna
    // Metode 'progress' di OutcomeController sudah memiliki logika isAdmin()
    Route::get('/outcomes/all', [OutcomeController::class, 'progress'])->name('outcomes.all');



// Rute autentikasi bawaan Laravel (login, register, reset password, dll.)
require __DIR__.'/auth.php';