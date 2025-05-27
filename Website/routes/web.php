<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTambahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GangguanController;  
use App\Http\Controllers\PredictionController; 
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\Admin\OutcomeController;

Route::get('/gangguan/{id}', [GangguanController::class, 'show']);

// Halaman landing
Route::get('/', function () {
    
    return view('landing');
})->name('landing'); 

// Route untuk halaman detail Gangguan Mood
// Ini akan ditangani oleh method showMoodDisorder di GangguanController
Route::get('/gangguan/mood', [GangguanController::class, 'showMoodDisorder'])->name('gangguan.mood');

// Rute untuk halaman dashboard umum
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah'); // Ini akan membuat rute bernama 'admin.tambah'

        // POST untuk menyimpan data admin baru
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store'); 
        // Rute untuk Gejala
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
    });
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
});

// Contoh route untuk admin (sesuaikan dengan kebutuhan Anda)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin_dashboard') ; // Pastikan view admin_dashboard.blade.php ada
    })->name('dashboard');

    Route::get('/tambah', function () {
        return view('tambah_admin'); // Pastikan view tambah_admin.blade.php ada
    })->name('tambah');
    // Tambahkan route admin lainnya di sini
});

// Rute untuk pengguna tanpa login (diagnosis)
Route::get('/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('diagnosis.form');
Route::post('/diagnosis', [DiagnosisController::class, 'submitDiagnosis'])->name('diagnosis.submit');

// Rute untuk admin (outcome)
Route::prefix('admin')->middleware(['auth', 'can:access-admin-panel'])->group(function () { // Sesuaikan middleware admin Anda
    Route::get('/outcome', [OutcomeController::class, 'showOutcomeForm'])->name('admin.outcome.form');
    Route::post('/outcome', [OutcomeController::class, 'predictOutcome'])->name('admin.outcome.predict');
});
// web.php
// Route::middleware(['auth'])->group(function () {
//     Route::get('/predict', [PredictionController::class, 'showCreateForm'])->name('predictions.create');
//     Route::post('/predict', [PredictionController::class, 'predict'])->name('predictions.predict');
//     Route::get('/history', [PredictionController::class, 'showHistory'])->name('predictions.history');
// });

Route::get('/test-mongo', function () {
    try {
        // Ambil client MongoDB mentah
        $mongo = DB::connection('mongodb')->getMongoClient();

        // Akses database dan koleksi
        $collection = $mongo->diagnosa->test_koneksi; // Sesuaikan dengan nama database & koleksi kamu

        $collection->insertOne([
            'check' => 'MongoDB Connected',
            'time' => now(),
        ]);

        return response()->json(['message' => 'Tersambung ke MongoDB!']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Gagal konek: ' . $e->getMessage()]);
    }
});


require __DIR__.'/auth.php';


// Route tambahan dari Laravel Breeze/Fortify (jika Anda menggunakannya)
