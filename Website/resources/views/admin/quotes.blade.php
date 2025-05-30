@extends('admin.dashboard') {{-- Pastikan ini mengarah ke layout admin Anda yang benar --}}

@section('title', 'Manajemen Quotes & Affirmation')
@section('header_title', 'Manajemen Quotes & Affirmation')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Quotes & Affirmation Baru</h2>
        <form action="{{ route('admin.quotes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Quotes/Afirmasi:</label>
                <textarea name="content" id="content" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror" placeholder="Masukkan quotes atau afirmasi"></textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                <input type="text" name="category" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category') border-red-500 @enderror" placeholder="Contoh: Dukungan, Harapan, Motivasi">
                @error('category')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Tambah Quotes
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Quotes & Affirmation</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.103l-2.651 3.746a1.2 1.2 0 0 1-1.697-1.697l3.746-2.651-3.746-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.897l2.651-3.746a1.2 1.2 0 0 1 1.697 1.697L11.103 10l3.746 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        @if ($quotes->isEmpty())
            <p class="text-gray-600">Belum ada quotes atau afirmasi yang ditambahkan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quotes/Afirmasi</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotes as $quote)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-700">{{ $quote->content }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-700">{{ $quote->category }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus quotes ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection