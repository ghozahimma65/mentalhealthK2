@extends('layouts.admin')

@section('content')
    <div class="overflow-hidden bg-white rounded-md shadow-md">
        <div class="p-4 border-b bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-700">Daftar Pengguna</h3>
        </div>
        <div class="p-4">
            @if ($users->isEmpty())
                <div class="p-3 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500 rounded-md" role="alert">
                    <p>Tidak ada pengguna terdaftar.</p>
                </div>
            @else
                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200">
                                ID
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200">
                                Nama
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b-2 border-gray-200">
                                Email
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-4 text-sm border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->id }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->name }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm border-b border-gray-200">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection