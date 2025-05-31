<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use App\Models\DiagnosisResult; // Pastikan ini diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Pastikan ini diimport untuk manipulasi tanggal

class DiagnosisController extends Controller
{
    protected $flaskApiService;

    /**
     * Constructor untuk menginject FlaskApiService.
     * Laravel akan secara otomatis menyediakan instance FlaskApiService.
     */
    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    /**
     * Menampilkan form kuesioner diagnosis kepada pengguna.
     * Dapat diakses oleh pengguna umum (belum login) dan pengguna terautentikasi.
     *
     * @return \Illuminate\View\View
     */
    public function showDiagnosisForm()
    {
        // Mengembalikan view 'diagnosis.form' yang berisi kuesioner HTML.
        // File ini harus ada di resources/views/diagnosis/form.blade.php
        return view('diagnosis.form');
    }

    /**
     * Memproses data yang disubmit dari form diagnosis.
     * Melakukan validasi, memanggil Flask API, menyimpan hasil,
     * dan menampilkan hasil diagnosis atau pesan error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function submitDiagnosis(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|integer|in:0,1',
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'sleep_quality' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
            'ai_detected_emotional_state' => 'required|integer|in:0,1,2,3,4,5',
        ]);

        // 2. Mapping nama kolom dari form ke nama yang diharapkan oleh Flask API
        $inputForFlask = [
            'Age' => (int)$validatedData['age'],
            'Gender' => (int)$validatedData['gender'],
            'Symptom Severity (1-10)' => (int)$validatedData['symptom_severity'],
            'Mood Score (1-10)' => (int)$validatedData['mood_score'],
            'Sleep Quality (1-10)' => (int)$validatedData['sleep_quality'],
            'Physical Activity (hrs/week)' => (float)$validatedData['physical_activity'],
            'Stress Level (1-10)' => (int)$validatedData['stress_level'],
            'AI-Detected Emotional State' => (int)$validatedData['ai_detected_emotional_state'],
        ];

        // 3. Panggil Flask API untuk prediksi diagnosis
        $prediction = null;
        try {
            $prediction = $this->flaskApiService->predictDiagnosis($inputForFlask);
        } catch (\Exception $e) {
            Log::error('Error saat memanggil Flask API dari submitDiagnosis(): ' . $e->getMessage());
            return back()->with('error', 'Gagal terhubung ke layanan prediksi. Silakan coba lagi nanti.');
        }

        // 4. Periksa hasil prediksi dari Flask API
        if ($prediction && isset($prediction['diagnosis'])) {
            // 5. Simpan hasil diagnosis ke MongoDB (opsional)
            try {
                DiagnosisResult::create([
                    'user_id' => Auth::id(), // Akan null jika pengguna tidak login
                    'input_data' => $inputForFlask,
                    'predicted_diagnosis' => $prediction['diagnosis'],
                    'timestamp' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan hasil diagnosis ke MongoDB: ' . $e->getMessage());
            }

            // 6. Mengarahkan ke view hasil diagnosis dan meneruskan data diagnosis.
            return view('diagnosis.result', [
                'diagnosis' => $prediction['diagnosis'],
                'user_is_guest' => !Auth::check()
            ]);
        } else {
            Log::warning('Prediksi diagnosis Flask API gagal atau mengembalikan data tidak valid.', ['response' => $prediction]);
            return back()->with('error', 'Gagal mendapatkan diagnosis. Silakan coba lagi. Pastikan Flask API berjalan dengan benar.');
        }
    }

    /**
     * Menampilkan daftar riwayat diagnosis awal untuk pengguna.
     * Ini dipanggil oleh route('predictions.history').
     *
     * @return \Illuminate\View\View
     */
    public function historyIndex()
    {
        $user = Auth::user();

        $diagnosisResults = DiagnosisResult::where('user_id', $user->id)
                                             ->latest('timestamp')
                                             ->paginate(10); 

        $diagnosisNameMap = $this->getDiagnosisNameMap();

        return view('diagnosis.history', compact('diagnosisResults', 'diagnosisNameMap'));
    }

    /**
     * Menampilkan detail spesifik dari satu record diagnosis awal.
     * Dipanggil oleh route('predictions.show').
     *
     * @param DiagnosisResult $diagnosisResult
     * @return \Illuminate\View\View
     */
    public function historyShow(DiagnosisResult $diagnosisResult)
    {
        $user = Auth::user();
        // Otorisasi: Pastikan hanya pemilik atau admin yang bisa melihat
        if ($diagnosisResult->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $diagnosisNameMap = $this->getDiagnosisNameMap();
        
        return view('diagnosis.show', compact('diagnosisResult', 'diagnosisNameMap'));
    }

    /**
     * Helper: Memetakan kode diagnosis ke nama.
     * Ini harus ada di dalam kelas ini.
     * @return array
     */
    private function getDiagnosisNameMap()
    {
        return [
            0 => 'Gangguan Bipolar',
            1 => 'Gangguan Kecemasan Umum',
            2 => 'Gangguan Depresi Mayor',
            3 => 'Gangguan Panik',
            99 => 'Lainnya / Tidak Tahu',
        ];
    }

    /**
     * Helper function untuk memetakan kode diagnosis (dari Flask API) ke nama yang mudah dibaca.
     * Ini bisa duplikasi dari getDiagnosisNameMap jika hanya mengembalikan string.
     * @param int $code
     * @return string
     */
    private function mapDiagnosisCodeToName($code)
    {
        switch ($code) {
            case 0: return 'Gangguan Bipolar';
            case 1: return 'Gangguan Kecemasan Umum';
            case 2: return 'Gangguan Depresi Mayor';
            case 3: return 'Gangguan Panik';
            default: return 'Tidak Diketahui';
        }
    }

    /**
     * Helper function untuk mendapatkan kelas warna CSS berdasarkan kode diagnosis.
     *
     * @param int $code
     * @return string
     */
    private function getDiagnosisColorClass($code)
    {
        switch ($code) {
            case 0: return 'text-purple-600';
            case 1: return 'text-orange-600';
            case 2: return 'text-red-600';
            case 3: return 'text-yellow-600';
            default: return 'text-gray-800';
        }
    }
}
