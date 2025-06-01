<?php

namespace App\Http\Controllers\Admin;

use App\Models\DiagnosisResult;
use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminDiagnosisController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    /**
     * Menampilkan daftar diagnosis yang diajukan pengguna untuk diprediksi oleh admin.
     * Menggunakan view 'admin.admindiagnosis'.
     *
     * @return \Illuminate\View\View
     */
    public function listForPrediction()
    {
        $diagnosisResults = DiagnosisResult::with('user')
                                           ->where('admin_processed', false) // Hanya tampilkan yang belum diproses admin
                                           ->orderBy('timestamp', 'desc')
                                           ->get();

        return view('admin.admindiagnosis', compact('diagnosisResults'));
    }

    /**
     * Melakukan prediksi diagnosis berdasarkan data yang sudah ada di database (dari user/pasien).
     *
     * @param string $id ID dari dokumen diagnosis_results di MongoDB (dokumen asli dari pasien)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prediksi($id)
    {
        $originalDiagnosisRecord = DiagnosisResult::find($id);

        if (!$originalDiagnosisRecord) {
            return redirect()->back()->with('error', 'Data diagnosis pasien tidak ditemukan.');
        }

        $inputForFlask = $originalDiagnosisRecord->input_data;

        if (empty($inputForFlask)) {
            return redirect()->back()->with('error', 'Data input (gejala) tidak ditemukan untuk diagnosis ini.');
        }

        $predictedDiagnosisFromFlask = null;
        $errorMessage = null;

        try {
            $prediction = $this->flaskApiService->predictDiagnosis($inputForFlask);

            if ($prediction && isset($prediction['diagnosis'])) {
                $predictedDiagnosisFromFlask = $prediction['diagnosis'];
            } else {
                $errorMessage = 'Gagal mendapatkan diagnosis dari layanan prediksi. Respon tidak valid.';
                Log::error('Flask API Invalid Response: ' . json_encode($prediction));
            }
        } catch (\Exception $e) {
            $errorMessage = 'Gagal terhubung ke layanan prediksi. Pastikan Flask API berjalan. Error: ' . $e->getMessage();
            Log::error('Flask API Connection Error: ' . $e->getMessage());
        }

        if ($predictedDiagnosisFromFlask === null) {
            return redirect()->back()->with('error', $errorMessage ?? 'Tidak dapat melakukan prediksi. Mohon coba lagi.');
        }

        try {
            // --- PERUBAHAN UTAMA DI SINI ---
            // TIDAK PERLU membuat record baru. Cukup update record asli.
            $originalDiagnosisRecord->predicted_diagnosis = $predictedDiagnosisFromFlask; // Set hasil prediksi
            $originalDiagnosisRecord->admin_processed = true; // Tandai sebagai sudah diproses
            $originalDiagnosisRecord->save(); // Simpan perubahan ke database

            $message = 'Prediksi berhasil disimpan sebagai riwayat admin.';
            // Logika pesan ini sekarang akan membandingkan hasil prediksi baru dengan yang sudah ada (jika ada)
            // Namun, karena ini adalah prediksi pertama oleh admin, predicted_diagnosis di record asli mungkin kosong.
            // Anda bisa menyesuaikan logika pesan ini jika diperlukan.
            // Untuk kasus ini, pesan default 'Prediksi berhasil disimpan sebagai riwayat admin.' sudah cukup.
            // if ($originalDiagnosisRecord->predicted_diagnosis !== $predictedDiagnosisFromFlask) {
            //     $message = 'Prediksi berhasil disimpan sebagai riwayat admin. Hasil diagnosis berbeda dengan yang tercatat sebelumnya.';
            // } else {
            //     $message = 'Prediksi berhasil disimpan sebagai riwayat admin. Hasil diagnosis sama dengan yang tercatat sebelumnya.';
            // }

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan riwayat diagnosis admin ke MongoDB: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Prediksi berhasil, tetapi gagal menyimpan riwayat admin. Error: ' . $e->getMessage());
        }

        return redirect()->route('admin.riwayatdiagnosis.index')->with('success', $message);
    }
}
