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
use App\Http\Controllers\Api\OutcomeController; // <-- TAMBAHKAN IMPORT UNTUK OUTCOME CONTROLLER

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rute untuk mendapatkan informasi pengguna yang sedang login
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute publik untuk Autentikasi (Login, Register, Lupa Password)
Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api.password.email');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('api.password.update');
});

// Route untuk Meditasi (Publik)
Route::prefix('meditasi')->group(function () {
    Route::get('/', [MeditasiController::class, 'index']);
    Route::get('/{id}', [MeditasiController::class, 'show']);
});

// Route untuk Quotes (Publik)
Route::prefix('quotes')->group(function () {
    Route::get('/', [QuotesController::class, 'index']);
    Route::get('/{id}', [QuotesController::class, 'show']);
});

// Route untuk Rencana Self Care (Dilindungi Autentikasi)
Route::apiResource('rencana', RencanaController::class)->middleware('auth:sanctum');

// Route untuk Diagnosis dari Mobile (Dilindungi Autentikasi)
Route::prefix('diagnosa')->middleware('auth:sanctum')->group(function () { // Middleware bisa diletakkan di group
    Route::post('/submit', [DiagnosisController::class, 'submitDiagnosis']);
    Route::get('/history', [DiagnosisController::class, 'history']);
});

// --- ROUTE BARU UNTUK TES PERKEMBANGAN (OUTCOME) ---
Route::prefix('outcome')->middleware('auth:sanctum')->group(function () {
    // Endpoint untuk submit kuesioner tes perkembangan
    Route::post('/submit', [OutcomeController::class, 'submitOutcome']);

    // Endpoint untuk melihat riwayat tes perkembangan pengguna yang login
    Route::get('/history', [OutcomeController::class, 'history']);
});