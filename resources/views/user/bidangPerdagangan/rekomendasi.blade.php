@extends('layouts.home')
@section('title', 'Rekomendasi Penyaluran Pupuk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-[#083458] mb-2">Rekomendasi Penyaluran Minggu Depan</h2>
        <p class="text-gray-600">Berikut hasil rekomendasi penyaluran berdasarkan data konsumsi terkini.</p>
    </div>

    @isset($error)
        <div class="bg-yellow-100 text-yellow-800 border-l-4 border-yellow-500 p-4 rounded mb-6">
            {{ $error }}
        </div>
    @endisset

    @isset($tanggalTerbaru)
        <div class="bg-blue-50 text-blue-800 border-l-4 border-blue-500 p-4 rounded mb-6">
            <strong>Tanggal Data Terbaru:</strong> {{ \Carbon\Carbon::parse($tanggalTerbaru)->translatedFormat('d F Y') }}
        </div>
    @endisset

    @if(!empty($results))
        <div class="overflow-x-auto bg-white rounded shadow ring-1 ring-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-semibold text-center">
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
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-800 capitalize">{{ $row['toko'] }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $row['barang'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full">
                                    {{ $row['rekomendasi'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $bg = match($row['klasifikasi']) {
                                        'Konsumsi Tinggi' => 'bg-red-100 text-red-700',
                                        'Konsumsi Sedang' => 'bg-yellow-100 text-yellow-700',
                                        'Konsumsi Rendah' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
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
        <div class="text-center mt-10 text-gray-500 text-lg">
            Tidak ada hasil rekomendasi untuk saat ini.
        </div>
    @endif
</div>
@endsection
