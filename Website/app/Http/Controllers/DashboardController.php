<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiagnosisResult;
// use App\Models\MentalHealthArticle; // Model ini dikomentari karena tidak lagi digunakan di Blade dashboard
use App\Models\MentalHealthOutcome;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Statistik Diagnosis
        $diagnosesCount = DiagnosisResult::where('user_id', $user->id)->count();

        // 2. Ambil Hasil Diagnosis Terakhir (untuk kartu "Diagnosis Terakhir")
        $latestDiagnosis = DiagnosisResult::where('user_id', $user->id)
                                          ->latest('timestamp') // Mengurutkan berdasarkan timestamp terbaru
                                          ->first();
        
        // Memproses data latestDiagnosis jika ada (untuk nama dan kelas warna)
        if ($latestDiagnosis) {
            $diagnosisCode = $latestDiagnosis->predicted_diagnosis;
            $latestDiagnosis->result_name = $this->mapDiagnosisCodeToName($diagnosisCode);
            $latestDiagnosis->result_class = $this->getDiagnosisColorClass($diagnosisCode);
        }


        
        // 4. Waktu Prediksi Terakhir Keseluruhan (untuk kartu "Aktivitas Terbaru")
        $lastDiagnosisTime = DiagnosisResult::where('user_id', $user->id)->max('timestamp');
        $lastOutcomeTime = MentalHealthOutcome::where('user_id', $user->id)->max('timestamp');
        
        $lastPredictionOverall = null;
        if ($lastDiagnosisTime && $lastOutcomeTime) {
            $lastPredictionOverall = Carbon::parse($lastDiagnosisTime)->max(Carbon::parse($lastOutcomeTime));
        } elseif ($lastDiagnosisTime) {
            $lastPredictionOverall = Carbon::parse($lastDiagnosisTime);
        } elseif ($lastOutcomeTime) {
            $lastPredictionOverall = Carbon::parse($lastOutcomeTime);
        }

        // 5. Data untuk Grafik Tren Outcome (untuk bagian visualisasi)
        $userOutcomes = MentalHealthOutcome::where('user_id', $user->id)
                                           ->orderBy('timestamp', 'asc') // Urutkan dari yang terlama ke terbaru untuk tren
                                           ->get();

        // Inisialisasi variabel chart agar tidak undefined di Blade
        $chartLabels = [];
        $chartData = [];
        $plotValueMap = [0 => 0, 2 => 1, 1 => 2]; // Map untuk nilai plot (0=Memburuk, 1=Tidak Berubah, 2=Membaik)
        $plotLabelsMap = [0 => 'Memburuk', 1 => 'Tidak Berubah', 2 => 'Membaik']; // Map untuk label Y-axis

        // Populasikan data chart jika ada user outcomes
        foreach ($userOutcomes as $outcome) {
            $chartLabels[] = Carbon::parse($outcome->timestamp)->format('d M'); 
            $chartData[] = $plotValueMap[$outcome->predicted_outcome] ?? null; 
        }

        
        // $mentalHealthArticles = collect(); 

        // 7. Ambil Riwayat Diagnosis Awal (untuk tabel "Riwayat Prediksi Terbaru")
        $diagnosisHistories = DiagnosisResult::where('user_id', $user->id)
                                             ->latest('timestamp')
                                             ->take(5) // Ambil 5 terbaru untuk snapshot
                                             ->get();

        // 8. Ambil Riwayat Perkembangan (Outcome) (untuk tabel "Riwayat Prediksi Terbaru")
        $outcomeHistories = MentalHealthOutcome::where('user_id', $user->id)
                                                ->latest('timestamp')
                                                ->take(5) // Ambil 5 terbaru untuk snapshot
                                                ->get();
        
        // --- PERBAIKAN: Hitung Total Catatan Perkembangan dan Total Aktivitas ---
        $totalOutcomeRecords = MentalHealthOutcome::where('user_id', $user->id)->count(); // <--- INI SEKARANG DIDEFINISIKAN
        $totalActivities = $diagnosesCount + $totalOutcomeRecords; // Hitung total aktivitas
        // --- END PERBAIKAN ---

        // Helper maps untuk tabel riwayat
        $diagnosisNameMap = $this->getDiagnosisNameMap();
        $outcomeNameMap = $this->getOutcomeNameMap();


        // 9. Kembalikan View dengan Semua Data
        return view('dashboard', compact(
            'diagnosesCount', 
            'latestDiagnosis',
            'lastPredictionOverall',
            // 'mentalHealthArticles', // Tidak lagi dikirim
            'chartLabels',
            'chartData',
            'plotLabelsMap',
            'diagnosisHistories',
            'outcomeHistories',
            'diagnosisNameMap',
            'outcomeNameMap',
            'totalActivities' // Ini yang akan menggantikan di Blade
        ));
    }

    /**
     * Helper function untuk memetakan kode diagnosis (dari Flask API) ke nama yang mudah dibaca.
     * Harus ada di dalam kelas ini.
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
     * Harus ada di dalam kelas ini.
     * @param int $code
     * @return string
     */
    private function getDiagnosisColorClass($code)
    {
        switch ($code) {
            case 0: return 'text-purple-600'; // Bipolar
            case 1: return 'text-orange-600'; // Kecemasan
            case 2: return 'text-red-600';    // Depresi
            case 3: return 'text-yellow-600'; // Panik
            default: return 'text-gray-800';  // Default
        }
    }

    /**
     * Helper: Memetakan kode outcome ke nama.
     * Harus ada di dalam kelas ini.
     * @param int $code
     * @return array
     */
    private function getOutcomeNameMap()
    {
        return [
            0 => 'Deteriorated',
            1 => 'Improved',
            2 => 'No Change',
        ];
    }

    /**
     * Helper: Memetakan kode diagnosis ke nama (untuk tabel riwayat).
     * Harus ada di dalam kelas ini.
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
}