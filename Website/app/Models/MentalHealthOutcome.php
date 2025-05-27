<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // PASTIKAN MENGGUNAKAN NAMESPACE INI!
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // Jika Anda ingin membuat relasi ke model User

class MentalHealthOutcome extends Model
{
    use HasFactory;

    protected $connection = 'mongodb'; 
    protected $collection = 'mental_health_outcomes'; 
    protected $primaryKey = '_id'; 

    protected $fillable = [
        'user_id',             // ID pengguna yang mengisi kuesioner
        'input_data',          // Akan menyimpan semua input kuesioner sebagai objek/sub-dokumen
        'predicted_outcome',   // Hasil prediksi perkembangan dari Flask API
        'timestamp',           // Waktu saat data ini disimpan
    ];

    // INI ADALAH BAGIAN KRUSIAL YANG HARUS BENAR
    protected $casts = [
        'user_id' => 'string',
        'input_data' => 'array',    // <--- PENTING: Gunakan 'array' di sini!
                                   //      Model MongoDB akan secara otomatis mengkonversi PHP array
                                   //      dengan string keys menjadi BSON Object (Embedded Document)
                                   //      Ini yang Anda inginkan.
        'predicted_outcome' => 'int', // Menggunakan 'int' sesuai diskusi terakhir Anda
        'timestamp' => 'datetime',
    ];

    public $timestamps = true; // Laravel akan mengelola created_at dan updated_at

    /**
     * Mendefinisikan relasi ke model User.
     * Asumsi: Model User Anda juga menggunakan MongoDB dan ID-nya adalah '_id'.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }
}