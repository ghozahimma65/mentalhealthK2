<?php

namespace App\Http\Controllers\Admin;

use App\Models\MentalHealthOutcome;
use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Controller;

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
        $outcomeResults = MentalHealthOutcome::with('user')
            ->where('admin_processed', false)
            ->orderBy('timestamp', 'desc')
            ->get();

        // Decode input_data menjadi array agar bisa digunakan di view jika masih string
        foreach ($outcomeResults as $outcome) {
            if (is_string($outcome->input_data)) {
                $decoded = json_decode($outcome->input_data, true);
                $outcome->input_data = is_array($decoded) ? $decoded : [];
            }
        }

        return view('admin.adminoutcome', compact('outcomeResults'));
    }

    /**
     * Melakukan prediksi outcome berdasarkan data yang sudah ada di database.
     *
     * @param string $id ID dari dokumen mental_health_outcomes di MongoDB
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prediksi($id)
    {
        $originalOutcomeRecord = MentalHealthOutcome::find($id);

        if (!$originalOutcomeRecord) {
            return redirect()->back()->with('error', 'Data outcome pasien tidak ditemukan.');
        }

        // Pastikan input_data dalam format array (bukan string)
        $inputForFlask = is_string($originalOutcomeRecord->input_data)
            ? json_decode($originalOutcomeRecord->input_data, true)
            : $originalOutcomeRecord->input_data;

        if (empty($inputForFlask) || !is_array($inputForFlask)) {
            return redirect()->back()->with('error', 'Data input (outcome) tidak ditemukan atau tidak valid untuk record ini.');
        }

        $predictedOutcomeFromFlask = null;
        $errorMessage = null;

        try {
            $prediction = $this->flaskApiService->predictOutcome($inputForFlask);

            // Menggunakan 'outcome_prediction' agar sesuai dengan respons Flask API yang ada
            if ($prediction && isset($prediction['outcome_prediction'])) {
                $predictedOutcomeFromFlask = $prediction['outcome_prediction'];
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
            // --- PERUBAHAN UTAMA DI SINI ---
            // TIDAK PERLU membuat record baru. Cukup update record asli.
            $originalOutcomeRecord->predicted_outcome = $predictedOutcomeFromFlask; // Set hasil prediksi
            $originalOutcomeRecord->admin_processed = true; // Tandai sebagai sudah diproses
            $originalOutcomeRecord->save(); // Simpan perubahan ke database

            $message = 'Prediksi outcome berhasil disimpan sebagai riwayat admin.';
            // Logika pesan ini sekarang akan membandingkan hasil prediksi baru dengan yang sudah ada (jika ada)
            // Namun, karena ini adalah prediksi pertama oleh admin, predicted_outcome di record asli mungkin kosong.
            // Anda bisa menyesuaikan logika pesan ini jika diperlukan.
            // Untuk kasus ini, pesan default 'Prediksi outcome berhasil disimpan sebagai riwayat admin.' sudah cukup.
            // if ($originalOutcomeRecord->predicted_outcome !== $predictedOutcomeFromFlask) {
            //     $message = 'Prediksi outcome berhasil disimpan. Hasil berbeda dari sebelumnya.';
            // } else {
            //     $message = 'Prediksi outcome berhasil disimpan. Hasil sama dengan sebelumnya.';
            // }

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan riwayat outcome admin ke MongoDB: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Prediksi berhasil, tapi gagal menyimpan. Error: ' . $e->getMessage());
        }

        return redirect()->route('admin.riwayatoutcome.index')->with('success', $message);
    }
}
