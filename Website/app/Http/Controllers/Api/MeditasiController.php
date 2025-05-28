<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meditasi; // Asumsi Anda memiliki model Meditasi

class MeditasiController extends Controller
{
    /**
     * Display a listing of the meditation resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil semua data meditasi dari koleksi 'meditasis'
            $meditasis = Meditasi::all();

            // Kembalikan data dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Data meditasi berhasil diambil.',
                'data' => $meditasis
            ], 200);

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data meditasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified meditation resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Cari meditasi berdasarkan ID
            $meditasi = Meditasi::find($id);

            // Jika meditasi tidak ditemukan
            if (!$meditasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Meditasi tidak ditemukan.'
                ], 404);
            }

            // Kembalikan data dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Detail meditasi berhasil diambil.',
                'data' => $meditasi
            ], 200);

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail meditasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Anda bisa menambahkan method store, update, destroy jika diperlukan untuk API
}