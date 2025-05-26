<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote; // Import model Quote
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Menampilkan daftar quotes dan form tambah.
     */
    public function index()
    {
        $quotes = Quote::orderBy('created_at', 'desc')->get();
        return view('admin.quotes', compact('quotes'));
    }

    /**
     * Menyimpan quote baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'category' => 'required|string|max:255',
        ]);

        Quote::create([
            'content' => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.quotes.index')->with('success', 'Quotes & Affirmation berhasil ditambahkan!');
    }

    /**
     * Menghapus quote.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('admin.quotes.index')->with('success', 'Quotes & Affirmation berhasil dihapus!');
    }
}