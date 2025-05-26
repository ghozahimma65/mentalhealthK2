<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTambahController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\OutcomeController;
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

    Route::get('/outcome/create', [OutcomeController::class, 'create'])->name('outcome.create');
    Route::post('/outcome', [OutcomeController::class, 'store'])->name('outcome.store');
    
    Route::get('/outcome/progress', [OutcomeController::class, 'progress'])->name('outcome.progress');
    
    Route::get('/outcome/{outcome}', [OutcomeController::class, 'show'])->name('outcome.show');
});


// --- RUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk menambah data 
    Route::get('/tambah', [AdminTambahController::class, 'create'])->name('tambah');
    Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store');

    Route::get('/outcomes/all', [OutcomeController::class, 'progress'])->name('outcomes.all');
});



require __DIR__.'/auth.php';