@extends('layouts.home')
@section('title', 'Rekomendasi Penyaluran Pupuk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="mb-2">
        <a href="{{ url('/pelaporan') }}" class="inline-flex items-center text-bold font-bold text-[#083458]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-[#083458] mb-2">Rekomendasi Penyaluran Minggu Depan</h2>
        <p class="text-gray-600">Berikut hasil rekomendasi penyaluran berdasarkan data konsumsi terkini.</p>
    </div>

    @isset($error)
        <div class="p-4 mb-6 text-yellow-800 bg-yellow-100 border-l-4 border-yellow-500 rounded">
            {{ $error }}
        </div>
    @endisset

    @isset($tanggalTerbaru)
        <div class="p-4 mb-6 text-blue-800 border-l-4 border-blue-500 rounded bg-blue-50">
            <strong>Tanggal Data Terbaru:</strong> {{ \Carbon\Carbon::parse($tanggalTerbaru)->translatedFormat('d F Y') }}
        </div>
    @endisset

    @if(!empty($results))
        <div class="overflow-x-auto bg-white rounded shadow ring-1 ring-gray-200">
            <table class="min-w-full text-center divide-y divide-gray-200 text-semibold">
                <thead class="bg-[#083458] text-white text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Toko</th>
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4">Rekomendasi (sak)</th>
                        <th class="px-6 py-4">Klasifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($results as $row)
                        @php
                            $bg = match($row['klasifikasi']) {
                                'Konsumsi Tinggi' => 'bg-red-100 text-red-700',
                                'Konsumsi Sedang' => 'bg-yellow-100 text-yellow-700',
                                'Konsumsi Rendah' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-800 capitalize">{{ $row['toko'] }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $row['barang'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $bg }}">
                                    {{ $row['rekomendasi'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $bg }}">
                                    {{ $row['klasifikasi'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="mt-10 text-lg text-center text-gray-500">
            Tidak ada hasil rekomendasi untuk saat ini.
        </div>
    @endif
</div>
@endsection
