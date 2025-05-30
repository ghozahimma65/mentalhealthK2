<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditasi; // PASTIKAN NAMA MODEL SUDAH BENAR (Meditasi atau Meditation)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload file

class MeditationController extends Controller
{
    /**
     * Menampilkan daftar lagu meditasi dan form tambah.
     */
    public function index()
    {
        // Pastikan nama model di sini juga sesuai dengan yang diimpor
        $meditations = Meditasi::orderBy('created_at', 'desc')->get(); // Di sini harus Meditasi jika modelnya Meditasi
        return view('admin.mastermeditasi', compact('meditations')); // Perbaiki variabel dari 'meditation' menjadi 'meditations'
    }

    /**
     * Menyimpan lagu meditasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:20480', // Max 20MB (20480 KB)
        ], [
            'audio_file.required' => 'File audio wajib diunggah.',
            'audio_file.mimes' => 'Format file audio harus MP3, WAV, atau OGG.',
            'audio_file.max' => 'Ukuran file audio maksimal 20MB.',
        ]);

        $audioPath = $request->file('audio_file')->store('meditation_audios', 'public');

        Meditasi::create([ // Pastikan nama model di sini juga sesuai
            'title' => $request->title,
            'description' => $request->description,
            'audio_path' => $audioPath,
        ]);

        return redirect()->route('admin.meditations.index')->with('success', 'Lagu meditasi berhasil ditambahkan!'); // Ubah rute redirect ke meditations.index
    }

    /**
     * Menghapus lagu meditasi.
     */
    public function destroy(Meditasi $meditation) // Pastikan tipe-hinting menggunakan nama model yang benar
    {
        // Hapus file audio dari storage
        if (Storage::disk('public')->exists($meditation->audio_path)) {
            Storage::disk('public')->delete($meditation->audio_path);
        }

        $meditation->delete();

        return redirect()->route('admin.meditations.index')->with('success', 'Lagu meditasi berhasil dihapus!'); // Ubah rute redirect ke meditations.index
    }
}