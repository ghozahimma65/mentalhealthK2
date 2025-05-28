<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan; // Mengganti App\Models\Rencana menjadi App\Models\Plan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RencanaController extends Controller
{
    /**
     * Display a listing of the rencana resources.
     * Mengambil semua data rencana.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil semua data rencana, diurutkan dari yang terbaru
            // Menggunakan model Plan
            $rencanaList = Plan::orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data rencana berhasil diambil.',
                'data' => $rencanaList
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created rencana resource in storage.
     * Menyimpan rencana baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari mobile
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000', // Deskripsi opsional
        ], [
            'title.required' => 'Judul rencana wajib diisi.',
            'title.string' => 'Judul rencana harus berupa teks.',
            'title.max' => 'Judul rencana maksimal 255 karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat rencana baru menggunakan model Plan
            $rencana = Plan::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil ditambahkan.',
                'data' => $rencana
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified rencana resource.
     * Mengambil detail rencana berdasarkan ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Menggunakan model Plan
            $rencana = Plan::find($id);

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail rencana berhasil diambil.',
                'data' => $rencana
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified rencana resource in storage.
     * Memperbarui rencana.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'Judul rencana wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Menggunakan model Plan
            $rencana = Plan::find($id);

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan.'
                ], 404);
            }

            $rencana->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil diperbarui.',
                'data' => $rencana
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified rencana resource from storage.
     * Menghapus rencana.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Menggunakan model Plan
            $rencana = Plan::find($id);

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan.'
                ], 404);
            }

            $rencana->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil dihapus.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}