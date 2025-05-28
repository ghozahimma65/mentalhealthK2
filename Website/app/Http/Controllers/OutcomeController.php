<?php

namespace App\Http\Controllers; // Namespace ini sudah benar (umum)

use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Import service Flask API
use App\Models\MentalHealthOutcome; // <--- PENTING: Ganti dari OutcomeResult ke MentalHealthOutcome
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user_id
use Illuminate\Support\Facades\Log; // Untuk logging error

class OutcomeController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
        // Middleware di sini akan berlaku untuk SEMUA metode di controller ini.
        // Jika Anda ingin beberapa metode bisa diakses tamu, JANGAN letakkan middleware di sini.
        // Lebih baik terapkan middleware di routes/web.php.
        // Contoh penerapan middleware di constructor (jika semua metode perlu auth):
        // $this->middleware('auth'); // Hanya yang sudah login yang bisa akses controller ini
        // $this->middleware('verified'); // Hanya user terverifikasi
    }

    /**
     * Menampilkan form kuesioner perkembangan pengobatan.
     * Dapat diakses oleh pengguna biasa dan admin (sesuai pengaturan rute).
     *
     * @return \Illuminate\View\View
     */
    public function create() // Mengubah nama metode dari showOutcomeForm menjadi create (sesuai resource)
    {
        // View ini harus ada di resources/views/outcome/create.blade.php
        // (Ini adalah file yang kita buat sebelumnya untuk kuesioner perkembangan)
        return view('outcome.create');
    }

    /**
     * Memproses data yang disubmit dari form perkembangan pengobatan.
     * Melakukan validasi, memanggil Flask API, menyimpan hasil, dan menampilkan hasil.
     * Dapat diakses oleh pengguna biasa dan admin (sesuai pengaturan rute).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function store(Request $request) // Mengubah nama metode dari predictOutcome menjadi store (sesuai resource)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'diagnosis' => 'required|integer', // Sesuaikan dengan nilai yang diizinkan (0,1,2,3,99)
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'medication' => 'required|integer', // Sesuaikan dengan encoding (0-5, 99)
            'therapy_type' => 'required|integer', // Sesuaikan dengan encoding (0-3, 99)
            'treatment_duration' => 'required|integer|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
        ]);

        // Mapping nama kolom ke nama yang diharapkan oleh Flask API
        $inputForFlask = [
            'Diagnosis' => (int)$validatedData['diagnosis'],
            'Symptom Severity (1-10)' => (int)$validatedData['symptom_severity'],
            'Mood Score (1-10)' => (int)$validatedData['mood_score'],
            'Physical Activity (hrs/week)' => (float)$validatedData['physical_activity'],
            'Medication' => (int)$validatedData['medication'],
            'Therapy Type' => (int)$validatedData['therapy_type'],
            'Treatment Duration (weeks)' => (int)$validatedData['treatment_duration'],
            'Stress Level (1-10)' => (int)$validatedData['stress_level'],
        ];

        // Panggil Flask API untuk prediksi outcome
        // Asumsi Flask API Anda memiliki endpoint untuk prediksi perkembangan
        $prediction = $this->flaskApiService->predictOutcome($inputForFlask);

        if ($prediction && isset($prediction['outcome_prediction'])) {
            // Simpan input dan hasil prediksi ke MongoDB
            try {
                // <--- PENTING: Gunakan MentalHealthOutcome::create()
                MentalHealthOutcome::create([ 
                    'user_id' => Auth::id(), // ID pengguna yang sedang login (admin atau pengguna biasa)
                    'input_data' => $inputForFlask, // Simpan input mentah
                    'predicted_outcome' => $prediction['outcome_prediction'], // Simpan hasil prediksi
                    'timestamp' => now(), // Waktu saat ini
                    'admin_processed' => false,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan prediksi outcome ke MongoDB: ' . $e->getMessage());
                // Anda bisa tambahkan flash message error ke pengguna jika perlu
                // session()->flash('db_error', 'Gagal menyimpan riwayat perkembangan Anda. Hasil tetap ditampilkan.');
            }

            // Mengarahkan ke view hasil outcome.
            // View ini bisa sama untuk admin dan pengguna biasa, atau berbeda jika perlu.
            // Untuk kesederhanaan, kita bisa menggunakan satu view:
            return view('outcome.result', ['outcome_prediction' => $prediction['outcome_prediction']]);
        } else {
            // Jika prediksi gagal atau tidak ada hasil yang valid dari Flask API
            Log::warning('Prediksi outcome Flask API gagal atau mengembalikan data tidak valid.', ['response' => $prediction]);
            return back()->with('error', 'Gagal mendapatkan prediksi perkembangan. Silakan coba lagi. Pastikan Flask API berjalan.');
        }
    }

    /**
     * Menampilkan riwayat atau tren perkembangan pengobatan.
     * Dapat diakses oleh pengguna biasa dan admin.
     *
     * @return \Illuminate\View\View
     */
    public function progress() // Metode baru untuk menampilkan riwayat/progress
    {
        // Jika admin, tampilkan semua data outcome
        if (Auth::user()->isAdmin()) { // Asumsi ada method isAdmin() di model User
            $outcomes = MentalHealthOutcome::latest()->paginate(10); // <--- PENTING: Gunakan MentalHealthOutcome
            return view('admin.outcome.progress', compact('outcomes')); // View khusus admin
        } else {
            // Jika pengguna biasa, tampilkan data outcome mereka sendiri
            $outcomes = MentalHealthOutcome::where('user_id', Auth::id()) // <--- PENTING: Gunakan MentalHealthOutcome
                                           ->latest()
                                           ->paginate(10);
            return view('outcome.progress', compact('outcomes')); // View untuk pengguna biasa
        }
    }

    /**
     * Menampilkan detail spesifik dari satu record perkembangan.
     *
     * @param MentalHealthOutcome $outcome
     * @return \Illuminate\View\View
     */
    public function show(MentalHealthOutcome $outcome) // Metode untuk menampilkan detail
    {
        // Pastikan pengguna memiliki hak akses untuk melihat outcome ini
        // (Misalnya, hanya pemilik atau admin)
        if (Auth::user()->isAdmin() || $outcome->user_id == Auth::id()) {
            return view('outcome.show', compact('outcome'));
        }
        abort(403, 'Unauthorized action.'); // Akses ditolak jika tidak memiliki hak
    }

    // Anda bisa menambahkan metode edit, update, destroy jika admin perlu mengelola data ini
}