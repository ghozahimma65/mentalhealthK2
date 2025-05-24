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
Route::get('/gangguan/{id}', [GangguanController::class, 'show']); // Pastikan ini benar
Route::get('/gangguan/mood', [GangguanController::class, 'showMoodDisorder'])->name('gangguan.mood');

// Rute untuk halaman dashboard umum (bukan admin dashboard)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ========================================================================================
// ROUTE ADMIN: DIKELUARKAN DARI MIDDLEWARE 'auth' SEMENTARA UNTUK PENGEMBANGAN/TESTING
// ========================================================================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Route Dashboard Admin yang benar
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Route untuk Admin Tambah
    Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah'); // Contoh: admin.tambah (untuk menampilkan form)
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store'); // Contoh: admin.tambah.store (untuk menyimpan data)

    // Penting: Anda memiliki dua route POST ke '/tambah' yang sama.
    // Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
    // Jika Anda ingin route ini memiliki nama 'admin.tambah.store', cukup satu baris ini saja.
    // Jika ada route lain seperti users.index, meditasi.index, tambahkan di sini:
    // Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    // Route::get('/meditasi', [\App\Http\Controllers\Admin\MeditasiController::class, 'index'])->name('meditasi.index');
    // dll.
});

// ========================================================================================
// ROUTE YANG MEMERLUKAN AUTENTIKASI: TETAPKAN ATAU TAMBAHKAN SESUAI KEBUTUHAN APLIKASI UTAMA
// ========================================================================================
Route::middleware('auth')->group(function () {
    // Profile routes (Laravel Breeze/Fortify)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk admin (outcome) -- Jika ini hanya bisa diakses admin setelah login
    Route::prefix('admin')->middleware('can:access-admin-panel')->group(function () { 
        // Pastikan 'can:access-admin-panel' sudah didefinisikan di AuthServiceProvider (Gates/Policies)
        // Jika belum, untuk testing, Anda bisa hapus middleware ini sementara atau ganti dengan middleware role sederhana.
        // use App\Http\Controllers\Admin\OutcomeController; // Impor ini jika digunakan
        // Route::get('/outcome', [OutcomeController::class, 'showOutcomeForm'])->name('admin.outcome.form');
        // Route::post('/outcome', [OutcomeController::class, 'predictOutcome'])->name('admin.outcome.predict');
    });

    // Tambahkan route lain yang memerlukan autentikasi di sini
});

// Rute untuk pengguna tanpa login (diagnosis)
Route::get('/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('diagnosis.form');
Route::post('/diagnosis', [DiagnosisController::class, 'submitDiagnosis'])->name('diagnosis.submit');

// Route Test MongoDB - pastikan koneksi MongoDB diatur di config/database.php
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
});

// Ini kemungkinan adalah route autentikasi dari Laravel Breeze/Fortify
require __DIR__.'/auth.php';

// Route tambahan dari Laravel Breeze/Fortify (jika Anda menggunakannya)
