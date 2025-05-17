<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTambahController;
use App\Http\Controllers\AuthController;




// Halaman landing
Route::get('/', function () {
    // Data untuk seksi "Gangguan Mood" yang akan ditampilkan di landing page
    $featuredDisorder = [
        'kode' => 'P001',
        'nama_gangguan' => 'Gangguan Mood',
        'kesimpulan' => 'Jadi dapat disimpulkan bahwa pasien mengalami tingkat depresi yaitu Depresi ringan kepastian yaitu 0%',
        'path_gambar' => 'images/gangguan_mood_illustration.png', // GANTI DENGAN PATH GAMBAR ANDA YANG BENAR (relatif terhadap folder public)
        'deskripsi_gangguan_intro' => 'Gangguan mood terjadi karena berbagai faktor yang bisa berasal dari aspek biologis, psikologis, maupun lingkungan. Berikut beberapa penyebab umum gangguan mood:',
        'poin_utama_deskripsi' => [
            'Ketidakseimbangan Kimia Otak: Neurotransmitter seperti serotonin, dopamin, dan norepinefrin berperan penting dalam mengatur suasana hati. Ketidakseimbangan zat-zat kimia ini dapat memicu gangguan mood seperti depresi atau bipolar.'
            // Anda bisa menambahkan poin ringkasan lain jika ada
        ],
        'link_detail' => route('gangguan.mood') // Menggunakan nama route untuk halaman detail
    ];
    // Mengirimkan data $featuredDisorder ke view 'landing'
    return view('landing', compact('featuredDisorder'));
})->name('landing'); // Memberi nama pada route landing page

// Route untuk halaman detail Gangguan Mood
// Ini akan ditangani oleh method showMoodDisorder di GangguanController
Route::get('/gangguan/mood', [GangguanController::class, 'showMoodDisorder'])->name('gangguan.mood');
Route::get('/cek/diagnosa', [DiagnosaController::class, 'showCekDiagnosaPage'])->name('diagnosa.cek');

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
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('tambah.store'); // Ini akan membuat rute bernama 'admin.tambah.store'

        // Rute untuk Gejala
        Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');

 
});
Route::post('/tambah', [AdminTambahController::class, 'store'])->name('admin.tambah.store');
});
    // Anda bisa menambahkan route lain yang memerlukan login di sini

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

// Auth routes dari Laravel Breeze

// Route tambahan dari Laravel Breeze/Fortify (jika Anda menggunakannya)
require __DIR__.'/auth.php';