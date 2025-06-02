<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MentalHealthOutcome; // Menggunakan model yang Anda berikan
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
// Jika Anda memiliki service khusus untuk prediksi outcome, import di sini
// use App\Services\MyOutcomePredictionService; // Contoh

class OutcomeController extends Controller
{
    // Jika Anda menggunakan service untuk prediksi, inject di sini
    // protected $myOutcomePredictionService;
    // public function __construct(MyOutcomePredictionService $myOutcomePredictionService)
    // {
    //     $this->myOutcomePredictionService = $myOutcomePredictionService;
    // }

    /**
     * Endpoint API untuk submit kuesioner tes perkembangan (outcome) dari mobile
     * dan mengembalikan hasil prediksi.
     */
    public function submitOutcome(Request $request)
    {
        // 1. Validasi input dari aplikasi mobile
        // Sesuaikan dengan field yang ada di model OutcomeInput Flutter Anda
        // dan yang ada di $fillable model MentalHealthOutcome
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'nullable|integer',
            'symptom_severity' => 'nullable|integer|min:1|max:10',
            'mood_score' => 'nullable|integer|min:1|max:10',
            'physical_activity' => 'nullable|numeric|min:0',
            'medication' => 'nullable|integer',
            'therapy_type' => 'nullable|integer',
            'treatment_duration' => 'nullable|integer|min:0',
            'stress_level' => 'nullable|integer|min:1|max:10',
            // user_id akan diambil dari Auth::id()
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi input gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        // 2. Logika untuk memprediksi outcome
        // Ini bisa berupa pemanggilan ke service lain (seperti Flask API),
        // atau logika internal di Laravel.
        // Untuk contoh ini, kita akan simulasikan hasil prediksi (0: Menurun, 1: Membaik, 2: Stabil)
        // Anda harus mengganti ini dengan logika prediksi Anda yang sebenarnya.
        $predictedOutcome = null;
        $feedbackMessage = "Terus pantau perkembangan Anda dan jangan ragu untuk mencari bantuan jika diperlukan.";

        // Contoh logika sederhana berdasarkan mood_score (HARUS DISESUAIKAN!)
        if (isset($validatedData['mood_score'])) {
            if ($validatedData['mood_score'] <= 3) {
                $predictedOutcome = 0; // Menurun
                $feedbackMessage = "Perkembangan Anda menunjukkan beberapa area yang memerlukan perhatian lebih. Pertimbangkan untuk berkonsultasi.";
            } elseif ($validatedData['mood_score'] >= 7) {
                $predictedOutcome = 1; // Membaik
                $feedbackMessage = "Selamat! Ada indikasi perkembangan positif. Terus pertahankan usaha baik Anda.";
            } else {
                $predictedOutcome = 2; // Stabil
                $feedbackMessage = "Kondisi Anda tampak stabil. Ini adalah waktu yang baik untuk refleksi dan konsistensi.";
            }
        } else {
            // Jika tidak ada data yang cukup untuk prediksi, bisa berikan nilai default
            $predictedOutcome = 2; // Default ke stabil jika tidak ada mood_score
        }
        // Akhir Logika Prediksi Contoh (HARUS DISESUAIKAN)


        // 3. Simpan input data dan hasil prediksi ke MongoDB
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Pengguna tidak terautentikasi.'], 401);
            }

            // Menyimpan semua data yang divalidasi ke dalam field 'input_data'
            // dan field individual jika diperlukan oleh $fillable
            MentalHealthOutcome::create([
                'user_id' => Auth::id(),
                'diagnosis' => $validatedData['diagnosis'] ?? null,
                'symptom_severity' => $validatedData['symptom_severity'] ?? null,
                'mood_score' => $validatedData['mood_score'] ?? null,
                'physical_activity' => $validatedData['physical_activity'] ?? null,
                'medication' => $validatedData['medication'] ?? null,
                'therapy_type' => $validatedData['therapy_type'] ?? null,
                'treatment_duration' => $validatedData['treatment_duration'] ?? null,
                'stress_level' => $validatedData['stress_level'] ?? null,
                'input_data' => $validatedData, // Simpan semua input yang divalidasi
                'predicted_outcome' => $predictedOutcome,
                'feedback_message' => $feedbackMessage, // Simpan pesan feedback jika ada
                'timestamp' => now(),
                'admin_processed' => false, // Default
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan hasil tes perkembangan ke MongoDB: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan hasil tes perkembangan.'], 500);
        }

        // 4. Mengembalikan hasil prediksi ke aplikasi mobile
        return response()->json([
            'success' => true,
            'message' => 'Hasil tes perkembangan berhasil dikirim.',
            'predicted_outcome' => $predictedOutcome, // integer
            'feedback_message' => $feedbackMessage, // string (opsional)
            'timestamp' => now()->toIso8601String(), // string ISO 8601
            'input_data' => $validatedData // Kirim kembali input jika diperlukan oleh halaman hasil di Flutter
        ], 200);
    }

    /**
     * Menampilkan riwayat tes perkembangan (outcome) untuk pengguna yang login.
     */
    public function history(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login untuk melihat riwayat tes perkembangan.'
            ], 401);
        }

        try {
            $history = MentalHealthOutcome::where('user_id', Auth::id())
                                    ->orderBy('timestamp', 'desc')
                                    ->get();

            // Memformat data untuk menyertakan deskripsi jika diperlukan oleh Flutter
            // Meskipun Flutter Anda mungkin sudah memiliki logika ini, ini adalah contoh
            // bagaimana Anda bisa melakukannya di backend.
            $formattedHistory = $history->map(function($item) {
                // Pastikan input_data adalah array atau objek sebelum diakses
                $inputData = is_array($item->input_data) ? $item->input_data : (is_object($item->input_data) ? (array) $item->input_data : []);

                return [
                    '_id' => $item->_id,
                    'user_id' => $item->user_id,
                    'predicted_outcome' => $item->predicted_outcome,
                    'feedback_message' => $item->feedback_message,
                    'timestamp' => $item->timestamp ? $item->timestamp->toIso8601String() : null,
                    // Mengambil data dari kolom individual jika ada, atau dari input_data sebagai fallback
                    'diagnosis' => $item->diagnosis ?? ($inputData['diagnosis'] ?? null),
                    'symptom_severity' => $item->symptom_severity ?? ($inputData['symptom_severity'] ?? null),
                    'mood_score' => $item->mood_score ?? ($inputData['mood_score'] ?? null),
                    'physical_activity' => $item->physical_activity ?? ($inputData['physical_activity'] ?? null),
                    'medication' => $item->medication ?? ($inputData['medication'] ?? null),
                    'therapy_type' => $item->therapy_type ?? ($inputData['therapy_type'] ?? null),
                    'treatment_duration' => $item->treatment_duration ?? ($inputData['treatment_duration'] ?? null),
                    'stress_level' => $item->stress_level ?? ($inputData['stress_level'] ?? null),
                    'input_data' => $inputData, // Sertakan input_data asli jika Flutter membutuhkannya
                    // Anda bisa menambahkan deskripsi menggunakan helper method dari model jika perlu
                    // 'diagnosis_description' => $item->getDiagnosisDescription($item->diagnosis ?? ($inputData['diagnosis'] ?? null)),
                    // 'mood_score_description' => $item->getMoodScoreDescription($item->mood_score ?? ($inputData['mood_score'] ?? null)),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Riwayat tes perkembangan berhasil diambil.',
                'data' => $formattedHistory
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error mengambil riwayat tes perkembangan untuk user ' . Auth::id() . ': ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat tes perkembangan.',
                'error' => $e->getMessage() // Kirim pesan error aktual untuk debugging
            ], 500);
        }
    }
}