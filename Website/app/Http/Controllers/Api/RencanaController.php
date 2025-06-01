<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan; // Pastikan ini adalah model Plan Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Untuk validasi
use Illuminate\Support\Facades\Auth;    // Untuk mendapatkan user yang terautentikasi

class RencanaController extends Controller
{
    /**
     * Menampilkan daftar rencana milik pengguna yang terautentikasi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil hanya rencana milik pengguna yang sedang login, urutkan dari terbaru
            $rencanaList = Plan::where('user_id', Auth::id()) 
                               ->orderBy('created_at', 'desc')
                               ->get();

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
     * Menyimpan rencana baru milik pengguna yang terautentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_completed' => 'sometimes|boolean', // Jika Anda punya field ini
        ], [
            'title.required' => 'Judul rencana wajib diisi.',
            // Anda bisa tambahkan pesan validasi lain jika perlu
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422); // Status 422 Unprocessable Entity
        }

        try {
            $rencana = Plan::create([
                'title' => $request->title,
                'description' => $request->description,
                'is_completed' => $request->input('is_completed', false), // Default false jika tidak ada
                'user_id' => Auth::id(), // <-- Mengaitkan dengan pengguna yang login
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil ditambahkan.',
                'data' => $rencana
            ], 201); // Status 201 Created

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan detail satu rencana milik pengguna yang terautentikasi.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $rencana = Plan::where('id', $id)
                           ->where('user_id', Auth::id()) // <-- Hanya milik user ini
                           ->first();

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan atau Anda tidak berhak mengaksesnya.'
                ], 404); // Status 404 Not Found (atau 403 Forbidden)
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
     * Memperbarui rencana milik pengguna yang terautentikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255', // 'sometimes' berarti hanya validasi jika ada
            'description' => 'nullable|string|max:1000',
            'is_completed' => 'sometimes|boolean',
        ],[
            'title.required' => 'Judul rencana wajib diisi jika ingin diubah.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $rencana = Plan::where('id', $id)
                           ->where('user_id', Auth::id()) // <-- Hanya milik user ini
                           ->first();

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan atau Anda tidak berhak mengubahnya.'
                ], 404); // Atau 403
            }

            // Hanya update field yang dikirim oleh request
            $dataToUpdate = $request->only(['title', 'description', 'is_completed']);
            // Jika ada field kosong yang tidak ingin diupdate, pastikan logic ini sesuai.
            // Atau, Anda bisa lakukan:
            // if ($request->has('title')) $rencana->title = $request->title;
            // if ($request->has('description')) $rencana->description = $request->description;
            // if ($request->has('is_completed')) $rencana->is_completed = $request->is_completed;
            // $rencana->save();
            $rencana->update($dataToUpdate);


            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil diperbarui.',
                'data' => $rencana->fresh() // Ambil data terbaru dari database
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
     * Menghapus rencana milik pengguna yang terautentikasi.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $rencana = Plan::where('id', $id)
                           ->where('user_id', Auth::id()) // <-- Hanya milik user ini
                           ->first();

            if (!$rencana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rencana tidak ditemukan atau Anda tidak berhak menghapusnya.'
                ], 404); // Atau 403
            }

            $rencana->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rencana berhasil dihapus.'
            ], 200); // Bisa juga 204 No Content jika tidak ada body

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus rencana.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}