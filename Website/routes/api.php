<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeditasiController;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\RencanaController;
use App\Http\Controllers\Api\DiagnosisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk Meditasi
Route::prefix('meditasi')->group(function () {
    Route::get('/', [MeditasiController::class, 'index']); // Mengambil semua data meditasi
    Route::get('/{id}', [MeditasiController::class, 'show']); // Mengambil detail meditasi berdasarkan ID
});

// Route baru untuk Quotes
Route::prefix('quotes')->group(function () {
    Route::get('/', [QuotesController::class, 'index']); // Mengambil semua data kutipan
    Route::get('/{id}', [QuotesController::class, 'show']); // Mengambil detail kutipan berdasarkan ID
});

Route::apiResource('rencana', RencanaController::class); // Ini akan membuat semua 5 route di atas

// Route untuk Diagnosis dari Mobile
Route::prefix('diagnosa')->group(function () {
    // Endpoint untuk submit kuesioner dan mendapatkan prediksi
    // SEKARANG DILINDUNGI OLEH AUTH:SANCTUM
    Route::middleware('auth:sanctum')->post('/submit', [DiagnosisController::class, 'submitDiagnosis']);

    // Endpoint untuk melihat riwayat diagnosis pengguna yang login (sudah dilindungi)
    Route::middleware('auth:sanctum')->get('/history', [DiagnosisController::class, 'history']);
});