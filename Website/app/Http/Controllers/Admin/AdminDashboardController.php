<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DiagnosisResult;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pengguna
        $totalUsers = User::count();

        // 2. Total Diagnosis yang Diproses Admin
        $totalProcessedDiagnoses = DiagnosisResult::where('admin_processed', true)->count();

        // 3. Distribusi Jenis Gangguan Mental
        // Ambil diagnosis yang sudah diproses admin dan kelompokkan
        $diagnosisDistribution = DiagnosisResult::where('admin_processed', true)
            ->get()
            ->groupBy(function($diagnosis) {
                // Map angka ke nama gangguan seperti di riwayat.blade.php
                switch ((int)$diagnosis->predicted_diagnosis) {
                    case 0: return 'Gangguan Bipolar';
                    case 1: return 'Gangguan Kecemasan Umum';
                    case 2: return 'Gangguan Depresi Mayor';
                    case 3: return 'Gangguan Panik';
                    default: return 'Lainnya';
                }
            })
            ->map->count();

        // Data untuk Chart.js (Labels dan Data)
        $diagnosisLabels = $diagnosisDistribution->keys()->toJson();
        $diagnosisData = $diagnosisDistribution->values()->toJson();

        // 4. Tren Diagnosis (contoh: per hari dalam 7 hari terakhir)
        $dailyDiagnoses = DiagnosisResult::where('admin_processed', true)
            ->where('timestamp', '>=', Carbon::now('Asia/Jakarta')->subDays(7)->startOfDay())
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->timestamp)->timezone('Asia/Jakarta')->format('D, d M'); // Format untuk label grafik
            })
            ->map->count()
            ->sortKeys(); // Urutkan berdasarkan tanggal

        $dailyLabels = $dailyDiagnoses->keys()->toJson();
        $dailyData = $dailyDiagnoses->values()->toJson();

        // Data untuk inputan gejala pada detail pengguna (Contoh: Distribusi Gender)
        // Ambil 'input_data' dari DiagnosisResult, yang harusnya di-cast ke array di model
        $genderDistribution = DiagnosisResult::whereNotNull('input_data')
            ->get()
            ->groupBy(function($diagnosis) {
                $gender = $diagnosis->input_data['gender'] ?? null;
                if ($gender === '0') return 'Pria';
                if ($gender === '1') return 'Wanita';
                return 'Tidak Diketahui';
            })
            ->map->count();

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
}