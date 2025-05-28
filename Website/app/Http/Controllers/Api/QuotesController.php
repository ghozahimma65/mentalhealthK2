<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote; // Asumsi Anda memiliki model Quote

class QuotesController extends Controller
{
    /**
     * Display a listing of the quote resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil semua data kutipan dari koleksi 'quotes'
            // Menggunakan orderBy agar urutan sesuai kebutuhan (misal, terbaru)
            $quotes = Quote::orderBy('created_at', 'desc')->get();

            // Kembalikan data dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Data kutipan berhasil diambil.',
                'data' => $quotes
            ], 200);

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kutipan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified quote resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Cari kutipan berdasarkan ID
            $quote = Quote::find($id);

            // Jika kutipan tidak ditemukan
            if (!$quote) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kutipan tidak ditemukan.'
                ], 404);
            }

            // Kembalikan data dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Detail kutipan berhasil diambil.',
                'data' => $quote
            ], 200);

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail kutipan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Anda bisa menambahkan method store, update, destroy jika diperlukan untuk API
}