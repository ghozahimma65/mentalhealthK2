<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class FlaskApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('FLASK_API_URL', 'http://127.0.0.1:5000'); // Atur di .env
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10.0, // Timeout request dalam detik
        ]);
    }

    /**
     * Memanggil model diagnosis di Flask API.
     *
     * @param array $data Input data untuk model diagnosis.
     * @return array|null Hasil prediksi atau null jika terjadi error.
     */
    public function predictDiagnosis(array $data)
    {
        try {
            $response = $this->client->post('/predict_diagnosis', [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            // Log error atau tangani sesuai kebutuhan
            \Log::error('Gagal memanggil Flask API untuk diagnosis: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Memanggil model outcome di Flask API.
     *
     * @param array $data Input data untuk model outcome.
     * @return array|null Hasil prediksi atau null jika terjadi error.
     */
    public function predictOutcome(array $data)
    {
        try {
            $response = $this->client->post('/predict_outcome', [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            \Log::error('Gagal memanggil Flask API untuk outcome: ' . $e->getMessage());
            return null;
        }
    }
}