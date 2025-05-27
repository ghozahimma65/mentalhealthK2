<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Import service Flask API
use App\Models\DiagnosisResult; 
use Illuminate\Support\Facades\Log;

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
     * Ini adalah halaman yang diakses pengguna tanpa login.
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
     * Melakukan validasi, memanggil Flask API, menyimpan hasil (opsional),
     * dan menampilkan hasil diagnosis atau pesan error.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function submitDiagnosis(Request $request)
    {
        // 1. Validasi input dari form
        // Laravel akan secara otomatis mengarahkan kembali dengan error jika validasi gagal.
        $validatedData = $request->validate([
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|integer|in:0,1', // Sesuaikan dengan encoding gender Anda (misal: 0=Laki-laki, 1=Perempuan)
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'sleep_quality' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
            'ai_detected_emotional_state' => 'required|integer|in:0,1,2,3,4', // Sesuaikan dengan encoding emosi Anda
        ]);

        // 2. Mapping nama kolom dari form ke nama yang diharapkan oleh Flask API
        // Pastikan nama kunci di array ini SAMA PERSIS dengan yang diharapkan oleh Flask API (case-sensitive).
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
        $prediction = $this->flaskApiService->predictDiagnosis($inputForFlask);

        // 4. Periksa hasil prediksi dari Flask API
        if ($prediction && isset($prediction['diagnosis'])) {
            // 5. Simpan hasil diagnosis ke MongoDB (opsional)
            // Pastikan model DiagnosisResult sudah dibuat dan dikonfigurasi untuk MongoDB.
            // Baris ini sudah diaktifkan untuk menyimpan data.
            try {
                DiagnosisResult::create([
                    'user_id' => auth()->id() ?? null, // Akan null jika pengguna tidak login
                    'input_data' => $inputForFlask, // Simpan input yang dikirim ke model
                    'predicted_diagnosis' => $prediction['diagnosis'], // Simpan hasil prediksi
                    'timestamp' => now() // Waktu saat ini
                ]);
            } catch (\Exception $e) {
                // Log error jika gagal menyimpan ke database, tapi jangan hentikan alur aplikasi
                Lo g::error('Gagal menyimpan hasil diagnosis ke MongoDB: ' . $e->getMessage());
            }

            // 6. Mengarahkan ke view hasil diagnosis dan meneruskan data diagnosis.
            // File ini harus ada di resources/views/diagnosis/result.blade.php
            return view('diagnosis.result', ['diagnosis' => $prediction['diagnosis']]);
        } else {
            // Jika prediksi gagal atau tidak ada hasil yang valid dari Flask API,
            // kembalikan pengguna ke form sebelumnya dengan pesan error.
            return back()->with('error', 'Gagal mendapatkan diagnosis. Silakan coba lagi. Pastikan Flask API berjalan.');
        }
    }
}
