<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // PASTIKAN MENGGUNAKAN NAMESPACE INI!
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // Jika Anda ingin membuat relasi ke model User

class MentalHealthOutcome extends Model
{
    use HasFactory;

    // Menentukan koneksi database yang akan digunakan model ini.
    // Jika 'mongodb' sudah diatur sebagai koneksi default di config/database.php,
    // baris ini bisa dihilangkan, tapi lebih aman untuk tetap menentukannya.
    protected $connection = 'mongodb'; 

    // Menentukan nama koleksi di MongoDB yang akan digunakan model ini.
    // Nama koleksi biasanya bentuk plural dari nama model, tapi eksplisit lebih baik.
    protected $collection = 'mental_health_outcomes'; 

    // Mendefinisikan primary key untuk koleksi MongoDB.
    // Secara default, MongoDB menggunakan '_id' sebagai primary key.
    protected $primaryKey = '_id'; 

    // Properti $fillable mendefinisikan atribut-atribut yang dapat diisi secara massal (mass assignable).
    // Ini penting untuk keamanan agar tidak ada kolom yang tidak diinginkan diisi.
    protected $fillable = [
        'user_id',              // ID pengguna yang mengisi kuesioner (bisa null jika tamu diizinkan)
        'diagnosis',            // Diagnosis terakhir (int)
        'symptom_severity',     // Tingkat keparahan gejala (int)
        'mood_score',           // Skor suasana hati (int)
        'physical_activity',    // Aktivitas fisik (float)
        'medication',           // Jenis pengobatan (int)
        'therapy_type',         // Jenis terapi (int)
        'treatment_duration',   // Durasi pengobatan (int)
        'stress_level',         // Tingkat stres (int)
        'predicted_outcome',    // Hasil prediksi perkembangan dari Flask API (misal: string, int, atau array)
        'input_data',           // Menyimpan semua input kuesioner mentah sebagai array/object (opsional, tapi bagus untuk debugging)
        'timestamp',            // Waktu saat data ini disimpan (jika tidak menggunakan Laravel timestamps)
    ];

    // Properti $casts mendefinisikan bagaimana atribut harus di-cast ke tipe data tertentu.
    // Ini berguna untuk input_data yang mungkin berupa JSON/array.
    protected $casts = [
        'input_data' => 'array', // Mengubah 'input_data' menjadi array PHP secara otomatis
        'timestamp' => 'datetime', // Mengubah 'timestamp' menjadi objek Carbon
        // Jika predicted_outcome adalah array/object, tambahkan juga:
        // 'predicted_outcome' => 'array',
    ];

    // Properti $timestamps secara default adalah true, yang berarti Laravel akan otomatis
    // mengelola kolom 'created_at' dan 'updated_at'. Jika Anda tidak ingin ini, set ke false.
    public $timestamps = true; 

    /**
     * Mendefinisikan relasi ke model User.
     * Asumsi: Model User Anda juga menggunakan MongoDB dan ID-nya adalah '_id'.
     * Jika model User Anda di database relasional (misal MySQL), relasi ini perlu penyesuaian khusus
     * atau Anda bisa mengambil user secara manual di controller.
     */
    public function user()
    {
        // 'user_id' adalah foreign key di koleksi 'mental_health_outcomes'
        // '_id' adalah local key di koleksi 'users'
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}