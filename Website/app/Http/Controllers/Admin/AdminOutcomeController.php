<?php

namespace App\Http\Controllers\Admin;

use App\Models\MentalHealthOutcome; // <-- Ubah dari OutcomeResult
use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Asumsikan Anda menggunakan FlaskApiService untuk prediksi outcome
use Illuminate\Support\Facades\Log;
use App\Models\User; // Digunakan untuk relasi user
use App\Http\Controllers\Controller; // Impor base Controller

class AdminOutcomeController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    /**
     * Menampilkan daftar outcome yang diajukan pengguna untuk diprediksi oleh admin.
     * Menggunakan view 'admin.adminoutcome'.
     *
     * @return \Illuminate\View\View
     */
    public function listForPrediction()
    {
        // Mengambil outcome yang belum diproses admin
        // PERBAIKAN: Gunakan MentalHealthOutcome
        $outcomeResults = MentalHealthOutcome::with('user')
                                         ->where('admin_processed', false)
                                         ->orderBy('timestamp', 'desc')
                                         ->get();

        return view('admin.adminoutcome', compact('outcomeResults'));
    }

    /**
     * Melakukan prediksi outcome berdasarkan data yang sudah ada di database (dari user/pasien).
     * Logika ini diasumsikan mirip dengan prediksi diagnosis.
     *
     * @param string $id ID dari dokumen mental_health_outcomes di MongoDB
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prediksi($id)
    {
        // PERBAIKAN: Gunakan MentalHealthOutcome
        $originalOutcomeRecord = MentalHealthOutcome::find($id);

        if (!$originalOutcomeRecord) {
            return redirect()->back()->with('error', 'Data outcome pasien tidak ditemukan.');
        }

        // input_data harus mengandung semua data yang dibutuhkan oleh Flask API
        $inputForFlask = $originalOutcomeRecord->input_data;

        if (empty($inputForFlask)) {
            return redirect()->back()->with('error', 'Data input (outcome) tidak ditemukan untuk record ini.');
        }

        $predictedOutcomeFromFlask = null;
        $errorMessage = null;

        try {
            // Asumsikan FlaskApiService memiliki method predictOutcome
            $prediction = $this->flaskApiService->predictOutcome($inputForFlask);

            if ($prediction && isset($prediction['outcome'])) {
                $predictedOutcomeFromFlask = $prediction['outcome'];
            } else {
                $errorMessage = 'Gagal mendapatkan outcome dari layanan prediksi. Respon tidak valid.';
                Log::error('Flask API Invalid Response (Outcome): ' . json_encode($prediction));
            }
        } catch (\Exception $e) {
            $errorMessage = 'Gagal terhubung ke layanan prediksi outcome. Pastikan Flask API berjalan. Error: ' . $e->getMessage();
            Log::error('Flask API Connection Error (Outcome): ' . $e->getMessage());
        }

        if ($predictedOutcomeFromFlask === null) {
            return redirect()->back()->with('error', $errorMessage ?? 'Tidak dapat melakukan prediksi outcome. Mohon coba lagi.');
        }

        try {
            // Membuat entri baru untuk hasil prediksi outcome oleh admin
            // PERBAIKAN: Gunakan MentalHealthOutcome
            MentalHealthOutcome::create([
                'user_id' => $originalOutcomeRecord->user_id,
                'input_data' => $inputForFlask,
                'predicted_outcome' => $predictedOutcomeFromFlask,
                'timestamp' => now(),
                'admin_processed' => true,
                // Anda mungkin juga ingin menyertakan nilai-nilai input terpisah di sini
                // jika Anda menyimpannya sebagai kolom terpisah di model MentalHealthOutcome,
                // misalnya:
                // 'diagnosis' => $originalOutcomeRecord->diagnosis,
                // 'symptom_severity' => $originalOutcomeRecord->symptom_severity,
                // ... dan seterusnya untuk kolom lain
            ]);

            // Menandai record asli sebagai sudah diproses oleh admin
            $originalOutcomeRecord->admin_processed = true;
            $originalOutcomeRecord->save();

            $message = 'Prediksi outcome berhasil disimpan sebagai riwayat admin.';
            // Catatan: Jika $originalOutcomeRecord->predicted_outcome awalnya null
            // (karena user hanya mengisi input_data), perbandingan ini akan selalu true.
            // Ini tetap valid, hanya perlu diketahui.
            if ($originalOutcomeRecord->predicted_outcome !== $predictedOutcomeFromFlask) {
                $message = 'Prediksi outcome berhasil disimpan sebagai riwayat admin. Hasil outcome berbeda dengan yang tercatat sebelumnya.';
            } else {
                $message = 'Prediksi outcome berhasil disimpan sebagai riwayat admin. Hasil outcome sama dengan yang tercatat sebelumnya.';
            }

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan riwayat outcome admin ke MongoDB: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Prediksi outcome berhasil, tetapi gagal menyimpan riwayat admin. Error: ' . $e->getMessage());
        }

        // Mengarahkan ke halaman riwayat outcome setelah prediksi
        return redirect()->route('admin.riwayatoutcome.index')->with('success', $message);
    }
}