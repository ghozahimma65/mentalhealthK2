<?php

namespace App\Services;

use Illuminate\Support\Facades\Http; // <--- TAMBAHKAN INI UNTUK LARAVEL HTTP CLIENT
use Exception;
use Illuminate\Support\Facades\Log; // Pastikan ini juga diimport jika belum

class FlaskApiService
{
    protected $baseUrl;

    public function __construct()
    {
        // Pastikan variabel lingkungan ini sudah diatur di .env Anda
        $this->baseUrl = env('FLASK_API_BASE_URL', 'http://127.0.0.1:5000'); 
    }

    /**
     * Memanggil model diagnosis di Flask API.
     * Menggunakan Laravel HTTP Client.
     *
     * @param array $data Input data untuk model diagnosis.
     * @return array|null Hasil prediksi atau null jika terjadi error.
     */
    public function predictDiagnosis(array $data): ?array
    {
        try {
            // Menggunakan Laravel HTTP Client (Http::)
            // 'json()' secara otomatis mengatur Content-Type ke application/json
            $response = Http::timeout(30)->post("{$this->baseUrl}/predict_diagnosis", $data);

            $response->throw(); // Melempar exception jika status code >= 400

            return $response->json(); // Menguraikan respons JSON secara otomatis
        } catch (Exception $e) {
            // Log error atau tangani sesuai kebutuhan
            Log::error('Gagal memanggil Flask API untuk diagnosis: ' . $e->getMessage(), ['data_sent' => $data]);
            return null;
        }
    }

    /**
     * Memanggil model outcome di Flask API.
     * Menggunakan Laravel HTTP Client.
     *
     * @param array $data Input data untuk model outcome.
     * @return array|null Hasil prediksi atau null jika terjadi error.
     */
    public function predictOutcome(array $data): ?array
    {
        try { 
            // Menggunakan Laravel HTTP Client (Http::)
            $response = Http::timeout(30)->post("{$this->baseUrl}/predict_outcome", $data); 
            
            $response->throw(); // Melempar exception jika status code >= 400
            
            return $response->json(); // Menguraikan respons JSON secara otomatis
        } catch (\Exception $e) { 
            Log::error("Flask API (Outcome) Error: {$e->getMessage()}", ['data_sent' => $data]); 
            return null; 
        }
    }
}