<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTambahController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\Admin\OutcomeController;
use Illuminate\Support\Facades\Auth; 

// --- RUTE PUBLIK / UMUM ---

// -------KALAU MAU NAMBAHIN ROUTE SESUAIKAN TEMPATNYA YA(ROUTE UNTUK ADMIN DAN USER-------)
// Halaman landing
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Rute untuk halaman diagnosis (bisa diakses tanpa login)
Route::get('/diagnosis', [DiagnosisController::class, 'showDiagnosisForm'])->name('diagnosis.form');
Route::post('/diagnosis', [DiagnosisController::class, 'submitDiagnosis'])->name('diagnosis.submit');

// Rute untuk pengujian koneksi MongoDB
Route::get('/test-mongo', function () {
    try {
        // Ambil client MongoDB mentah
        $mongo = DB::connection('mongodb')->getMongoClient();

        // Akses database dan koleksi
        $collection = $mongo->diagnosa->test_koneksi; // Sesuaikan dengan nama database & koleksi Anda

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
Route::middleware('auth')->group(function () {
    // Rute untuk dashboard umum (akan mengarahkan ke dashboard admin jika user adalah admin)
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); // View untuk pengguna biasa
    })->name('dashboard');

    // // Rute profil pengguna
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk fitur prediksi (jika ini untuk pengguna biasa, bukan admin)
    Route::get('/predict', [PredictionController::class, 'showCreateForm'])->name('predictions.create');
    Route::post('/predict', [PredictionController::class, 'predict'])->name('predictions.predict');
    Route::get('/history', [PredictionController::class, 'showHistory'])->name('predictions.history');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk menambah data (misal: tambah user, tambah gejala, dll.)
    Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah');
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store');

    // Rute untuk manajemen Outcome (misal: prediksi hasil, dll.)
    Route::get('/outcome', [OutcomeController::class, 'showOutcomeForm'])->name('outcome.form');
    Route::post('/outcome', [OutcomeController::class, 'predictOutcome'])->name('outcome.predict');

});



require __DIR__.'/auth.php';