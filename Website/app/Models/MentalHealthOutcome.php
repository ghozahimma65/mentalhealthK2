<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Models\User; // Jika belum di- uncomment dan dibutuhkan

class MentalHealthOutcome extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'mental_health_outcomes';
    protected $primaryKey = '_id';

    protected $fillable = [
        'user_id',
        'input_data',         // Akan menyimpan array/objek dengan NAMA FITUR FLASK
        'predicted_outcome',
        // 'feedback_message', // Dihilangkan sesuai permintaan
        'timestamp',
        'admin_processed',
    ];

    // Tidak menggunakan $casts
    // public $timestamps = true; // Jika Anda ingin created_at dan updated_at otomatis

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id')->withDefault([
            'name' => 'Pengguna Tidak Dikenal'
        ]);
    }

    // Metode helper untuk deskripsi input dari input_data
    // PASTIKAN KUNCI DI SINI ('Diagnosis', 'Symptom Severity (1-10)', DLL)
    // ADALAH NAMA FITUR FLASK YANG ANDA SIMPAN DI input_data
    public function getDiagnosisDescriptionFromInput()
    {
        $value = $this->input_data['Diagnosis'] ?? null;
        $map = [
            '0' => 'Gangguan Bipolar', '1' => 'Gangguan Kecemasan Umum',
            '2' => 'Gangguan Depresi Mayor', '3' => 'Gangguan Panik', '99' => 'Lainnya / Tidak Tahu',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getSymptomSeverityDescriptionFromInput()
    {
        $value = $this->input_data['Symptom Severity (1-10)'] ?? null;
        $map = [
            '1' => '1-Sangat Ringan', '2' => '2-Ringan', '3' => '3-Sedang', '4' => '4-Agak Berat',
            '5' => '5-Berat', '6' => '6-Sangat Berat', '7' => '7-Ekstrem', '8' => '8-Kritis',
            '9' => '9-Sangat Kritis', '10' => '10-Maksimal',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getMoodScoreDescriptionFromInput()
    {
        $value = $this->input_data['Mood Score (1-10)'] ?? null;
        $map = [
            '1' => '1-Sangat Buruk (Depresi/Sedih)', '2' => '2-Buruk (Cemas/Resah)',
            '3' => '3-Agak Buruk (Kurang Bersemangat)', '4' => '4-Cukup Netral (Biasa Saja)',
            '5' => '5-Netral (Stabil)', '6' => '6-Agak Baik (Cukup Bersemangat)',
            '7' => '7-Baik (Senang)', '8' => '8-Sangat Baik (Gembira/Optimis)',
            '9' => '9-Luar Biasa (Bahagia/Antusias)', '10' => '10-Maksimal (Euforia/Penuh Energi)',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getPhysicalActivityDescriptionFromInput()
    {
        $value = $this->input_data['Physical Activity (hrs/week)'] ?? null;
        if ($value === null || $value === '') return 'Tidak Diketahui';
        $numericValue = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if ($numericValue == 0) return '0-Tidak Ada';
        if ($numericValue > 0 && $numericValue <= 3) return "$numericValue jam/minggu (Rendah)";
        if ($numericValue > 3 && $numericValue <= 7) return "$numericValue jam/minggu (Sedang)";
        if ($numericValue > 7) return "$numericValue jam/minggu (Tinggi)";
        return 'Tidak Diketahui (' . $value . ' jam/minggu)';
    }

    public function getMedicationDescriptionFromInput()
    {
        $value = $this->input_data['Medication'] ?? null;
        $map = [
            '0' => 'Antidepressants', '1' => 'Antipsychotics', '2' => 'Benzodiazepines',
            '3' => 'Mood Stabilizers', '4' => 'SSRIs', '5' => 'Anxiolytics',
            '99' => 'Tidak sedang mengonsumsi obat',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getTherapyTypeDescriptionFromInput()
    {
        $value = $this->input_data['Therapy Type'] ?? null;
        $map = [
            '0' => 'CBT', '1' => 'DBT', '2' => 'IPT',
            '3' => 'Mindfulness-Based Therapy', '99' => 'Tidak sedang menjalani terapi',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getTreatmentDurationDescriptionFromInput()
    {
        $value = $this->input_data['Treatment Duration (weeks)'] ?? null;
        if ($value === null || $value === '') return 'Tidak Diketahui';
        $numericValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        if ($numericValue == 0) return '0-Belum Ada';
        if ($numericValue > 0 && $numericValue <= 12) return "$numericValue Minggu (1-3 Bulan)";
        if ($numericValue > 12 && $numericValue <= 52) return "$numericValue Minggu (4-12 Bulan)";
        if ($numericValue > 52) return "$numericValue Minggu (Lebih dari 1 Tahun)";
        return 'Tidak Diketahui (' . $value . ' minggu)';
    }

    public function getStressLevelDescriptionFromInput()
    {
        $value = $this->input_data['Stress Level (1-10)'] ?? null;
        $map = [
            '1' => '1-Sangat Rendah', '2' => '2-Rendah', '3' => '3-Sedang', '4' => '4-Cukup Tinggi',
            '5' => '5-Tinggi', '6' => '6-Sangat Tinggi', '7' => '7-Berlebihan', '8' => '8-Kritis',
            '9' => '9-Parah', '10' => '10-Sangat Parah',
        ];
        return $map[(string)$value] ?? 'Tidak Diketahui (' . $value . ')';
    }

    public function getOutcomeDescription()
    {
        $value = $this->predicted_outcome;
        if ($value === null) return 'Belum Diprediksi';
        $map = [
            '0' => 'Kondisi Cenderung Menurun',
            '1' => 'Kondisi Cenderung Membaik',
            '2' => 'Kondisi Cukup Stabil',
        ];
        return $map[(string)$value] ?? 'Kode Tidak Dikenal (' . $value . ')';
    }
}