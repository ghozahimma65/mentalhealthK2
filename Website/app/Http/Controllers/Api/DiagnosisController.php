<?php

namespace App\Http\Controllers\Api; // Perhatikan namespace ini

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Import service Flask API
use App\Models\DiagnosisResult; // Import model DiagnosisResult
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user_id (opsional)
use Illuminate\Support\Facades\Log; // Untuk logging error
use Illuminate\Support\Facades\Validator; // Untuk validasi input API

class DiagnosaApiController extends Controller
{
    protected $flaskApiService;

    /**
     * Constructor untuk menginject FlaskApiService.
     */
    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    /**
     * Endpoint API untuk submit kuesioner diagnosis dari mobile
     * dan mengembalikan hasil prediksi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitDiagnosis(Request $request)
    {
        // 1. Validasi input dari aplikasi mobile
        $validator = Validator::make($request->all(), [
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|integer|in:0,1', // Sesuaikan dengan encoding gender Anda
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'sleep_quality' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
            'ai_detected_emotional_state' => 'required|integer|in:0,1,2,3,4,5', // Sesuaikan dengan encoding emosi Anda
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi input gagal.',
                'errors' => $validator->errors()
            ], 422); // HTTP 422 Unprocessable Entity
        }

        // 2. Mapping input dari mobile ke format yang diharapkan oleh Flask API
        $inputForFlask = [
            'Age' => (int)$request->age,
            'Gender' => (int)$request->gender,
            'Symptom Severity (1-10)' => (int)$request->symptom_severity,
            'Mood Score (1-10)' => (int)$request->mood_score,
            'Sleep Quality (1-10)' => (int)$request->sleep_quality,
            'Physical Activity (hrs/week)' => (float)$request->physical_activity,
            'Stress Level (1-10)' => (int)$request->stress_level,
            'AI-Detected Emotional State' => (int)$request->ai_detected_emotional_state,
        ];

        // 3. Panggil Flask API untuk mendapatkan prediksi
        $prediction = null;
        try {
            $prediction = $this->flaskApiService->predictDiagnosis($inputForFlask);
        } catch (\Exception $e) {
            Log::error('Error calling Flask API from DiagnosaApiController: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghubungi layanan prediksi. Mohon coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }

        // 4. Periksa hasil prediksi
        if ($prediction && isset($prediction['diagnosis'])) {
            $predictedDiagnosis = $prediction['diagnosis'];

            // 5. Simpan input data dan hasil prediksi ke MongoDB
            try {
                DiagnosisResult::create([
                    'user_id' => Auth::check() ? Auth::id() : null, // ID pengguna jika login, null jika tidak
                    'input_data' => $inputForFlask, // Simpan sebagai objek/dokumen di MongoDB
                    'predicted_diagnosis' => $predictedDiagnosis,
                    'timestamp' => now(), // Waktu saat ini
                    'admin_processed' => false, // Default untuk prediksi pasien dari mobile
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save diagnosis result to MongoDB from API: ' . $e->getMessage());
                // Tetap kembalikan hasil prediksi ke mobile meskipun penyimpanan gagal
                // Anda bisa menambahkan pesan peringatan ke mobile jika diinginkan
            }

            // 6. Mengembalikan hasil prediksi ke aplikasi mobile
            return response()->json([
                'success' => true,
                'message' => 'Diagnosis berhasil didapatkan.',
                'predicted_diagnosis' => $predictedDiagnosis,
                // Anda bisa mengembalikan input data juga jika diperlukan oleh mobile
                // 'input_data' => $inputForFlask
            ], 200);

        } else {
            Log::warning('Flask API prediction failed or returned invalid data in DiagnosaApiController.', ['response' => $prediction]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan hasil diagnosis dari layanan prediksi. Data tidak valid.',
            ], 500);
        }
    }

    // Anda bisa menambahkan method lain seperti index, show, destroy untuk riwayat diagnosis di mobile jika diperlukan
    // Misalnya, untuk menampilkan riwayat diagnosis pengguna yang login:
    /**
     * Display a listing of user's diagnosis history.
     * @return \Illuminate\Http\JsonResponse
     */
     public function history()
    {
        // Pastikan pengguna sudah login untuk bisa melihat riwayat
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melihat riwayat diagnosis.'
            ], 401); // 401 Unauthorized
        }

        try {
            // Ambil semua hasil diagnosis yang user_id-nya sesuai dengan user yang sedang login
            // Diurutkan dari yang terbaru (tanggal diagnosis terbaru)
            $history = DiagnosisResult::where('user_id', Auth::id())
                                        ->orderBy('timestamp', 'desc')
                                        ->get();

            // Opsional: Anda bisa memformat data di sini agar lebih mudah dikonsumsi mobile
            // Misalnya, menambahkan deskripsi untuk nilai numerik
            $formattedHistory = $history->map(function($result) {
                // Pastikan input_data adalah array sebelum mengaksesnya
                $inputData = is_array($result->input_data) ? $result->input_data : [];

                return [
                    '_id' => $result->_id, // ID dokumen MongoDB
                    'predicted_diagnosis' => $result->predicted_diagnosis,
                    'timestamp' => $result->timestamp->toDateTimeString(), // Format timestamp agar mudah dibaca
                    'age' => $inputData['Age'] ?? null,
                    'gender_description' => $result->getGenderDescription($inputData['Gender'] ?? null),
                    'symptom_severity_description' => $result->getSymptomSeverityDescription($inputData['Symptom Severity (1-10)'] ?? null),
                    'mood_score_description' => $result->getMoodScoreDescription($inputData['Mood Score (1-10)'] ?? null),
                    'sleep_quality_description' => $result->getSleepQualityDescription($inputData['Sleep Quality (1-10)'] ?? null),
                    'physical_activity_description' => $result->getPhysicalActivityDescription($inputData['Physical Activity (hrs/week)'] ?? null),
                    'stress_level_description' => $result->getStressLevelDescription($inputData['Stress Level (1-10)'] ?? null),
                    'emotional_state_description' => $result->getAiDetectedEmotionalStateDescription($inputData['AI-Detected Emotional State'] ?? null),
                    // Anda bisa menambahkan semua field lain yang ingin ditampilkan di riwayat mobile
                ];
            });


            return response()->json([
                'success' => true,
                'message' => 'Riwayat diagnosis berhasil diambil.',
                'data' => $formattedHistory // Menggunakan data yang sudah diformat
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching diagnosis history for user ' . Auth::id() . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat diagnosis.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}