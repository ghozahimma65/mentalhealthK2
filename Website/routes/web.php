<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\Admin\AdminDashboardController; 
use App\Http\Controllers\Admin\AdminTambahController; 
use App\Http\Controllers\DiagnosisController; 
use App\Http\Controllers\OutcomeController; 
use Illuminate\Support\Facades\Auth;

// --- RUTE PUBLIK / UMUM ---

// Halaman landing page
Route::get('/', function () {
    return view('landing'); 
})->name('landing'); 

// Rute untuk halaman diagnosis (bisa diakses tanpa login)
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
    // Jika user adalah admin, akan di-redirect ke admin.dashboard di dalam Controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk fitur prediksi (jika ini untuk pengguna biasa, bukan admin)
    Route::get('/predict', [PredictionController::class, 'showCreateForm'])->name('predictions.create');
    Route::post('/predict', [PredictionController::class, 'predict'])->name('predictions.predict');
    Route::get('/history', [PredictionController::class, 'showHistory'])->name('predictions.history');

    Route::get('/outcome/create', [OutcomeController::class, 'create'])->name('outcome.create');
    // Proses submit form perkembangan
    Route::post('/outcome', [OutcomeController::class, 'store'])->name('outcome.store');
    // Melihat riwayat/progress perkembangan (metode progress() sudah punya logika user/admin)
    Route::get('/outcome/progress', [OutcomeController::class, 'progress'])->name('outcome.progress');
    // Rute untuk detail satu record perkembangan
    Route::get('/outcome/{outcome}', [OutcomeController::class, 'show'])->name('outcome.show');

    // --- RIWAYAT DIAGNOSIS AWAL (Jika berbeda dengan outcome.progress) ---
    // Jika PredictionHistoryController@index hanya menampilkan diagnosis awal
    // Route::get('/predictions/history', [PredictionHistoryController::class, 'index'])->name('predictions.history');
    // Route::get('/predictions/{diagnosisResult}', [PredictionHistoryController::class, 'show'])->name('predictions.show');

    // --- PENGATURAN PROFIL PENGGUNA ---
    // Uncomment jika Anda menggunakan ProfileController
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin (akan memanggil AdminDashboardController@index)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk menambah data (AdminTambahController)
    Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah');
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store');

    // Rute untuk admin melihat semua data outcome dari semua pengguna
    // Metode 'progress' di OutcomeController sudah memiliki logika isAdmin()
    Route::get('/outcomes/all', [OutcomeController::class, 'progress'])->name('outcomes.all');

    // Manajemen Artikel Kesehatan Mental
    // Route::resource('articles', App\Http\Controllers\Admin\MentalHealthArticleController::class);
});


// Rute autentikasi bawaan Laravel (login, register, reset password, dll.)
require __DIR__.'/auth.php';