<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeditasiController;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\RencanaController;
use App\Http\Controllers\Api\DiagnosisController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;

// Rute ini sudah benar dilindungi middleware auth:sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute publik untuk login
Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api.password.email');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('api.password.update');
});

// Route untuk Meditasi (Saat ini publik, sesuaikan jika perlu auth)
Route::prefix('meditasi')->group(function () {
    Route::get('/', [MeditasiController::class, 'index']);
    Route::get('/{id}', [MeditasiController::class, 'show']);
});

// Route baru untuk Quotes (Saat ini publik, sesuaikan jika perlu auth)
Route::prefix('quotes')->group(function () {
    Route::get('/', [QuotesController::class, 'index']);
    Route::get('/{id}', [QuotesController::class, 'show']);
});

// Route untuk Rencana Self Care, SEKARANG DILINDUNGI AUTHENTIKASI
Route::apiResource('rencana', RencanaController::class)->middleware('auth:sanctum');

// Route untuk Diagnosis dari Mobile
Route::prefix('diagnosa')->group(function () {
    // Endpoint untuk submit kuesioner dan mendapatkan prediksi
    // SEKARANG DILINDUNGI OLEH AUTH:SANCTUM
    Route::middleware('auth:sanctum')->post('/submit', [DiagnosisController::class, 'submitDiagnosis']);

    // Endpoint untuk melihat riwayat diagnosis pengguna yang login (sudah dilindungi)
    Route::middleware('auth:sanctum')->get('/history', [DiagnosisController::class, 'history']);
});