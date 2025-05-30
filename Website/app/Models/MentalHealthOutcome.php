<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class MentalHealthOutcome extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'mental_health_outcomes';
    protected $primaryKey = '_id';

    protected $fillable = [
        'user_id',
        'diagnosis', // Ini adalah input untuk prediksi outcome, bukan hasil prediksi sebelumnya
        'symptom_severity',
        'mood_score',
        'physical_activity',
        'medication',
        'therapy_type',
        'treatment_duration',
        'stress_level',
        'predicted_outcome',
        'input_data',
        'timestamp',
        'admin_processed',
    ];


    public $timestamps = true;

    public function user()
    {
        // Menggunakan withDefault() untuk menangani kasus user_id tidak ditemukan
        return $this->belongsTo(User::class, 'user_id', '_id')->withDefault([
            'name' => 'Pengguna Tidak Dikenal'
        ]);
    }

    // --- Helper Methods untuk Deskripsi Input Data (Disesuaikan untuk detail lebih lanjut) ---

    /**
     * Mengembalikan keterangan dari nilai numerik untuk diagnosis.
     * Menggunakan mapping dari form kuesioner outcome.
     *
     * @param int|string $value
     * @return string
     */
    public function getDiagnosisDescription($value)
    {
        $map = [
            '0' => 'Gangguan Bipolar',
            '1' => 'Gangguan Kecemasan Umum',
            '2' => 'Gangguan Depresi Mayor',
            '3' => 'Gangguan Panik',
            '99' => 'Lainnya / Tidak Tahu',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk symptom_severity.
     * Disesuaikan agar lebih detail seperti model DiagnosisResult.
     *
     * @param int|string $value
     * @return string
     */
    public function getSymptomSeverityDescription($value)
    {
        $map = [
            '1' => '1-Sangat Ringan',
            '2' => '2-Ringan',
            '3' => '3-Sedang',
            '4' => '4-Agak Berat',
            '5' => '5-Berat',
            '6' => '6-Sangat Berat',
            '7' => '7-Ekstrem',
            '8' => '8-Kritis',
            '9' => '9-Sangat Kritis',
            '10' => '10-Maksimal',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk mood_score.
     * Disesuaikan agar lebih detail seperti model DiagnosisResult.
     *
     * @param int|string $value
     * @return string
     */
    public function getMoodScoreDescription($value)
    {
        $map = [
            '1' => '1-Sangat Buruk (Depresi/Sedih)',
            '2' => '2-Buruk (Cemas/Resah)',
            '3' => '3-Agak Buruk (Kurang Bersemangat)',
            '4' => '4-Cukup Netral (Biasa Saja)',
            '5' => '5-Netral (Stabil)',
            '6' => '6-Agak Baik (Cukup Bersemangat)',
            '7' => '7-Baik (Senang)',
            '8' => '8-Sangat Baik (Gembira/Optimis)',
            '9' => '9-Luar Biasa (Bahagia/Antusias)',
            '10' => '10-Maksimal (Euforia/Penuh Energi)',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk physical_activity.
     * Disesuaikan agar lebih detail.
     *
     * @param float|int|string $value
     * @return string
     */
    public function getPhysicalActivityDescription($value)
    {
        if ($value == 0) return '0-Tidak Ada';
        if ($value > 0 && $value <= 3) return "$value-Rendah (Sampai 3 jam/minggu)";
        if ($value > 3 && $value <= 7) return "$value-Sedang (3-7 jam/minggu)";
        if ($value > 7) return "$value-Tinggi (Lebih dari 7 jam/minggu)";
        return 'Tidak Diketahui (' . $value . ' jam/minggu)';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk medication.
     * Menggunakan mapping dari form kuesioner outcome.
     *
     * @param int|string $value
     * @return string
     */
    public function getMedicationDescription($value)
    {
        $map = [
            '0' => 'Antidepressants (Antidepresan)',
            '1' => 'Antipsychotics (Antipsikotik)',
            '2' => 'Benzodiazepines (Benzodiazepin)',
            '3' => 'Mood Stabilizers (Penstabil Suasana Hati)',
            '4' => 'SSRIs (Selective Serotonin Reuptake Inhibitors)',
            '5' => 'Anxiolytics (Anxiolitik/Anti-kecemasan)',
            '99' => 'Tidak sedang mengonsumsi obat',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk therapy_type.
     * Menggunakan mapping dari form kuesioner outcome.
     *
     * @param int|string $value
     * @return string
     */
    public function getTherapyTypeDescription($value)
    {
        $map = [
            '0' => 'Cognitive Behavioral Therapy (CBT)',
            '1' => 'Dialectical Behavioral Therapy (DBT)',
            '2' => 'Interpersonal Therapy (IPT)',
            '3' => 'Mindfulness-Based Therapy (Terapi Berbasis Kesadaran)',
            '99' => 'Tidak sedang menjalani terapi',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk treatment_duration (dalam minggu).
     * Disesuaikan agar lebih detail.
     *
     * @param int|string $value
     * @return string
     */
    public function getTreatmentDurationDescription($value)
    {
        if ($value == 0) return '0-Belum Ada';
        if ($value > 0 && $value <= 12) return "$value Minggu (1-3 Bulan)";
        if ($value > 12 && $value <= 52) return "$value Minggu (4-12 Bulan)";
        if ($value > 52) return "$value Minggu (Lebih dari 1 Tahun)";
        return 'Tidak Diketahui (' . $value . ' minggu)';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk stress_level.
     * Disesuaikan agar lebih detail seperti model DiagnosisResult.
     *
     * @param int|string $value
     * @return string
     */
    public function getStressLevelDescription($value)
    {
        $map = [
            '1' => '1-Sangat Rendah (Tidak Stres)',
            '2' => '2-Rendah',
            '3' => '3-Sedang',
            '4' => '4-Cukup Tinggi',
            '5' => '5-Tinggi',
            '6' => '6-Sangat Tinggi',
            '7' => '7-Berlebihan',
            '8' => '8-Kritis',
            '9' => '9-Parah',
            '10' => '10-Sangat Parah (Tidak Terkendali)',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    // --- Helper Methods yang kemungkinan besar hanya relevan untuk DiagnosisResult ---
    // Metode ini mungkin tidak diperlukan di model MentalHealthOutcome jika data
    // 'Gender', 'Sleep Quality', atau 'AI-Detected Emotional State' tidak pernah
    // disimpan di kolom 'input_data' untuk outcome.

    /**
     * Mengembalikan keterangan dari nilai numerik untuk gender.
     *
     * @param int|string $value
     * @return string
     */
    public function getGenderDescription($value)
    {
        $map = [
            '0' => 'Pria 👨',
            '1' => 'Wanita 👩',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk sleep_quality.
     *
     * @param int|string $value
     * @return string
     */
    public function getSleepQualityDescription($value)
    {
        $map = [
            '1' => '1-Sangat Buruk (Tidak Tidur Sama Sekali)',
            '2' => '2-Buruk (Tidur Sangat Gelisah)',
            '3' => '3-Agak Buruk (Sulit Tidur Nyenyak)',
            '4' => '4-Cukup Buruk (Terbangun Berkali-kali)',
            '5' => '5-Sedang (Tidur Biasa Saja)',
            '6' => '6-Cukup Baik (Tidur Cukup Nyenyak)',
            '7' => '7-Agak Baik (Tidur Pulas)',
            '8' => '8-Baik (Tidur Sangat Nyenyak)',
            '9' => '9-Sangat Baik (Tidur Berkualitas Tinggi)',
            '10' => '10-Sangat Optimal (Tidur Sempurna dan Segar)',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk ai_detected_emotional_state.
     *
     * @param int|string $value
     * @return string
     */
    public function getAiDetectedEmotionalStateDescription($value)
    {
        $map = [
            '0' => '😟 Anxious (Cemas)',
            '1' => '😔 Depressed (Sedih)',
            '2' => '🤩 Excited (Gembira)',
            '3' => '😊 Happy (Senang)',
            '4' => '😐 Neutral (Netral)',
            '5' => '😥 Stressed (Stres)',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }
}
