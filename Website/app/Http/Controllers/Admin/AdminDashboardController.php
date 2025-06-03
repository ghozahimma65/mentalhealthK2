<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DiagnosisResult;
use App\Models\MentalHealthOutcome; // Pastikan ini di-import jika digunakan
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // Pemindahan Metode mapDiagnosisCodeToName ke lingkup kelas
    /**
     * Helper function untuk memetakan kode diagnosis ke nama yang mudah dibaca.
     *
     * @param int|null $code Kode diagnosis. // Diubah ke ?int untuk memperbolehkan null
     * @param bool $isGlobal Jika true, gunakan label 'Lainnya / Tidak Tahu' untuk default.
     * @return string Nama diagnosis.
     */
    private function mapDiagnosisCodeToName(?int $code, bool $isGlobal = false): string
    {
        if ($code === null) { // Tambahkan pengecekan null
            return 'Tidak Diketahui';
        }

        switch ($code) {
            case 0: return 'Gangguan Bipolar';
            case 1: return 'Gangguan Kecemasan Umum';
            case 2: return 'Gangguan Depresi Mayor';
            case 3: return 'Gangguan Panik';
            default: return $isGlobal ? 'Lainnya / Tidak Tahu' : 'Lainnya';
        }
    }

    public function index()
    {
        // 1. Total Pengguna
        $totalUsers = User::count();

        // 2. Total Diagnosis yang Diproses Admin
        $totalProcessedDiagnoses = DiagnosisResult::where('admin_processed', true)->count();

        // 3. Distribusi Jenis Gangguan Mental
        $diagnosisDistribution = DiagnosisResult::where('admin_processed', true)
            ->get()
            ->groupBy(function($diagnosis) {
                // Menggunakan helper method yang sudah dipindahkan
                return $this->mapDiagnosisCodeToName((int)$diagnosis->predicted_diagnosis);
            })
            ->map->count();

        $diagnosisLabels = $diagnosisDistribution->keys()->toJson();
        $diagnosisData = $diagnosisDistribution->values()->toJson();

        // 4. Tren Diagnosis
        $dailyDiagnoses = DiagnosisResult::where('admin_processed', true)
            ->where('timestamp', '>=', Carbon::now('Asia/Jakarta')->subDays(7)->startOfDay())
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->timestamp)->timezone('Asia/Jakarta')->format('D, d M');
            })
            ->map->count()
            ->sortKeys();

        $dailyLabels = $dailyDiagnoses->keys()->toJson();
        $dailyData = $dailyDiagnoses->values()->toJson();

        // 5. Distribusi Gender
        $genderDistribution = DiagnosisResult::whereNotNull('input_data')
            ->get()
            ->map(function($diagnosis) {
                $inputData = is_array($diagnosis->input_data) ? $diagnosis->input_data : (is_object($diagnosis->input_data) ? (array)$diagnosis->input_data : []);
                // Pastikan kunci 'Gender' sesuai dengan yang disimpan di input_data
                $genderCode = $inputData['Gender'] ?? null; // Asumsi nama fitur Flask adalah 'Gender'
                if ($genderCode === 0 || $genderCode === '0') return 'Pria';
                if ($genderCode === 1 || $genderCode === '1') return 'Wanita';
                return 'Tidak Diketahui';
            })
            ->countBy();

        $genderLabels = $genderDistribution->keys()->toJson();
        $genderData = $genderDistribution->values()->toJson();

        return view('admin.dashboardcontent', compact(
            'totalUsers',
            'totalProcessedDiagnoses',
            'diagnosisLabels',
            'diagnosisData',
            'dailyLabels',
            'dailyData',
            'genderLabels',
            'genderData'
        ));
    }

    /**
     * Menampilkan halaman tren klasifikasi global (diagnosis dan outcome).
     *
     * @return \Illuminate\View\View
     */
    public function showClassificationTrends()
    {
        // --- 1. DATA UNTUK GRAFIK DISTRIBUSI DIAGNOSIS AWAL (GLOBAL) ---
        $allDiagnosisDistribution = DiagnosisResult::get()
            ->groupBy(function ($diagnosis) {
                // Menggunakan helper method yang sudah dipindahkan dan ada di lingkup kelas
                return $this->mapDiagnosisCodeToName((int)$diagnosis->predicted_diagnosis, true); // true untuk nama yang lebih umum
            })
            ->map->count();

        $diagnosisLabels = $allDiagnosisDistribution->keys();
        $diagnosisData = $allDiagnosisDistribution->values(); // Tidak perlu toArray() jika Blade bisa handle Collection

        $defaultDiagnosisColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#2ECC71', '#E74C3C', '#F1C40F'];
        $numDiagnoses = $diagnosisLabels->count(); // Gunakan count() pada Collection
        $diagnosisColors = collect($defaultDiagnosisColors)->slice(0, $numDiagnoses)->all();
        if ($numDiagnoses > count($defaultDiagnosisColors)) {
            for ($i = count($defaultDiagnosisColors); $i < $numDiagnoses; $i++) {
                $diagnosisColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
        }

        // --- 2. DATA UNTUK GRAFIK TREN PERKEMBANGAN (OUTCOME) GLOBAL ---
        $globalOutcomes = MentalHealthOutcome::orderBy('timestamp', 'asc')->get();
        $globalOutcomes_count = $globalOutcomes->count();

        $plotLabelsMap = [
            0 => 'Memburuk',
            1 => 'Tidak Berubah',
            2 => 'Membaik'
        ];

        $adminOutcomePlotValueMap = [
            0 => 0, // DB: Deteriorated (0) -> Chart Y-axis: Memburuk (0)
            1 => 2, // DB: Improved (1)     -> Chart Y-axis: Membaik (2)
            2 => 1, // DB: No Change (2)    -> Chart Y-axis: Tidak Berubah (1)
        ];

        $outcomesByDate = $globalOutcomes->groupBy(function ($outcome) {
            return Carbon::parse($outcome->timestamp)->timezone('Asia/Jakarta')->format('Y-m-d');
        });

        $aggregatedOutcomeData = [];
        foreach ($outcomesByDate as $date => $outcomesOnDate) {
            if ($outcomesOnDate->isNotEmpty()) {
                $sumMappedValues = 0;
                $countValidOutcomes = 0;
                foreach ($outcomesOnDate as $o) {
                    if (isset($adminOutcomePlotValueMap[$o->predicted_outcome])) {
                        $sumMappedValues += $adminOutcomePlotValueMap[$o->predicted_outcome];
                        $countValidOutcomes++;
                    }
                }
                if ($countValidOutcomes > 0) {
                    $averageMappedValue = $sumMappedValues / $countValidOutcomes;
                    $aggregatedOutcomeData[Carbon::parse($date)->timezone('Asia/Jakarta')->format('d M')] = round($averageMappedValue);
                }
            }
        }

        uksort($aggregatedOutcomeData, function ($a, $b) {
            return Carbon::createFromFormat('d M', $a, 'Asia/Jakarta')->startOfDay()->timestamp - Carbon::createFromFormat('d M', $b, 'Asia/Jakarta')->startOfDay()->timestamp;
        });

        $outcomeChartLabels = array_keys($aggregatedOutcomeData);
        $outcomeChartData = array_values($aggregatedOutcomeData);

        return view('admin.classification_trends', compact(
            'diagnosisLabels',
            'diagnosisData',
            'diagnosisColors',
            'outcomeChartLabels',
            'outcomeChartData',
            'plotLabelsMap',
            'globalOutcomes_count'
        ));
    }

    // Metode mapDiagnosisCodeToName SEKARANG ADA DI LUAR showClassificationTrends(),
    // sebagai metode dari kelas AdminDashboardController. (Sudah dipindahkan ke atas)
}