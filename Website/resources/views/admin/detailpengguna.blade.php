@extends('admin.dashboard')

@section('title', 'Manajemen Pengguna')
@section('header_title', 'Detail Pengguna')

@section('content')
    <div class="container mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Manajemen Pengguna Aplikasi</h1>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama User</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user) {{-- Pastikan controller mengirimkan variabel $users --}}
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->email ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                {{-- Link untuk edit user (diperbaiki ke rute yang sesuai: admin.detailpengguna.edit) --}}
                                <a href="{{ route('admin.detailpengguna.edit', $user->id) }}" class="action-button bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm mr-2">Edit</a>
                                {{-- Form untuk hapus user (diperbaiki ke rute yang sesuai: admin.detailpengguna.destroy) --}}
                                <form action="{{ route('admin.detailpengguna.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 border-b border-gray-200 text-center text-gray-500">Tidak ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        /* Tambahkan atau sesuaikan styling action-button jika belum ada */
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem; /* text-sm */
            font-weight: 700; /* font-bold */
            text-decoration: none;
            border-radius: 0.25rem; /* rounded */
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        .action-button:hover {
            opacity: 0.9;
            transform: translateY(-0.5px);
        }
    </style>
@endpush