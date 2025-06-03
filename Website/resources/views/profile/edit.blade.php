@extends('layouts.main')

@section('title', 'Pengaturan Profil')

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-2 text-4xl font-extrabold" style="color: #7A9CC6;">🌿 Pengaturan Profil</h1>
        <p class="mb-6 italic" style="color: #7A9CC6;">"Merawat diri dimulai dari mengenali diri sendiri."</p>

        {{-- Notifikasi --}}
        @foreach (['profile-updated' => 'Profil berhasil diperbarui.', 'password-updated' => 'Kata sandi berhasil diperbarui.', 'profile-deleted' => 'Akun berhasil dihapus.'] as $status => $message)
            @if (session('status') === $status)
                <x-alert-success :message="$message" />
            @endif
        @endforeach

        {{-- Informasi Profil --}}
        <x-card>
            <x-slot name="title" >
                <span style="color: #7A9CC6;">🧠 Informasi Profil</span>
            </x-slot>
            <x-slot name="description">
                <span style="color: #7A9CC6;">
                    Perbarui nama dan email Anda. Kami di sini untuk membantu Anda tetap terhubung dan sehat.
                </span>
            </x-slot>

            <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PATCH')

                <x-input-group label="Nama" name="name" :value="old('name', $user->name)" />
                <x-input-group label="Email" name="email" type="email" :value="old('email', $user->email)" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="text-sm" style="color: #7A9CC6;">
                        Email Anda belum diverifikasi.
                        <button form="send-verification" class="underline hover:text-blue-800" style="color: #7A9CC6;">
                            Kirim ulang verifikasi
                        </button>
                    </p>
                @endif

                <x-button-primary style="background-color: #7A9CC6; border-color: #7A9CC6;">Simpan</x-button-primary>
            </form>
        </x-card>

        {{-- Perbarui Kata Sandi --}}
        <x-card class="mt-10">
            <x-slot name="title">
                <span style="color: #7A9CC6;">🔒 Perbarui Kata Sandi</span>
            </x-slot>
            <x-slot name="description">
                <span style="color: #7A9CC6;">
                    Gunakan kata sandi yang kuat untuk melindungi kesejahteraan digital Anda.
                </span>
            </x-slot>

            <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <x-input-group label="Kata Sandi Saat Ini" name="current_password" type="password" />
                <x-input-group label="Kata Sandi Baru" name="password" type="password" />
                <x-input-group label="Konfirmasi Kata Sandi" name="password_confirmation" type="password" />

                <x-button-primary style="background-color: #7A9CC6; border-color: #7A9CC6;">Simpan</x-button-primary>
            </form>
        </x-card>

            {{-- Hapus Akun --}}
        <x-card class="mt-10 border border-pink-200 bg-pink-50">
            <x-slot name="title">
                <span style="color: #e3342f;">⚠️ Hapus Akun</span>
            </x-slot>
            <x-slot name="description">
                <span style="color: #e3342f;">
                    Menghapus akun berarti mengakhiri perjalanan digital ini. Pastikan Anda sudah yakin dan menyimpan semua data penting.
                </span>
            </x-slot>

            <button
                type="button"
                x-data
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-600"
            >
                Hapus Akun
            </button>

            {{-- Modal Konfirmasi --}}
            <div id="confirm-user-deletion" style="display: none;">
                <div class="fixed inset-0 flex items-center justify-center p-4 bg-black bg-opacity-50">
                    <div class="w-full max-w-md p-6 text-center bg-white shadow-xl rounded-xl">
                        <h3 class="mb-4 text-xl font-semibold" style="color: #e3342f;">Yakin ingin menghapus akun Anda?</h3>
                        <p class="mb-6" style="color: #e3342f;">Langkah ini tidak bisa dibatalkan. Masukkan kata sandi Anda untuk konfirmasi.</p>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')

                            <x-input-group name="password" type="password" placeholder="Kata Sandi" class="text-center" />

                            <div class="flex justify-center gap-4 mt-4">
                                <button type="button" x-on:click="$dispatch('close-modal')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                                    Batal
                                </button>
                                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                                    Hapus Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
@endsection
