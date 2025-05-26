<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Import model dari package MongoDB

class DiagnosisResult extends Model
{
    protected $connection = 'mongodb'; // Pastikan koneksi ke MongoDB
    protected $collection = 'diagnosis_results'; // Nama koleksi di MongoDB

    protected $fillable = [
        'user_id',
        'input_data',
        'predicted_diagnosis',
        'timestamp',
        'admin_processed',
    ];
    

    public function user()
    {
        // Menggunakan withDefault() untuk menangani kasus user_id tidak ditemukan
        return $this->belongsTo(User::class, 'user_id', '_id')->withDefault([
            'name' => 'Pengguna Tidak Dikenal'
        ]);
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk symptom_severity.
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
        return $map[(string)$value] ?? $value; // Cast to string for key lookup
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk mood_score.
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
        return $map[(string)$value] ?? $value;
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
        return $map[(string)$value] ?? $value;
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk physical_activity.
     *
     * @param int|string $value
     * @return string
     */
    public function getPhysicalActivityDescription($value)
    {
        $map = [
            '1' => '1-Sangat Jarang (Tidak Aktif)',
            '2' => '2-Jarang (Sangat Sedikit Aktivitas)',
            '3' => '3-Cukup (Aktivitas Ringan-Sedang)',
            '4' => '4-Sering (Aktivitas Sedang-Tinggi)',
            '5' => '5-Sangat Sering (Sangat Aktif)',
            '6' => '6-Teratur (Aktivitas Terorganisir)',
            '7' => '7-Aktif (Sering Berolahraga)',
            '8' => '8-Sangat Aktif (Intensitas Tinggi)',
            '9' => '9-Profesional (Latihan Ekstrem)',
            '10' => '10-Atlet Elit (Aktivitas Maksimal)',
        ];
        return $map[(string)$value] ?? $value;
    }

    /**
     * Mengembalikan keterangan dari nilai numerik untuk stress_level.
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
        return $map[(string)$value] ?? $value;
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
        return $map[(string)$value] ?? $value;
    }

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
        return $map[(string)$value] ?? $value;
    }
}