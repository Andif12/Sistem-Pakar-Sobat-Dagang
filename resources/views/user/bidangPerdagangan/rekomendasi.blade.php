@extends('layouts.home')
@section('title', 'Rekomendasi Penyaluran Pupuk')

@section('content')
<div class="px-4 py-10 mx-auto max-w-7xl">
    <div class="mb-8 text-center">
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
                        <tr class="transition hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-800 capitalize">{{ $row['toko'] }}</td>
                            <td class="px-6 py-4 text-gray-800">{{ $row['barang'] }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
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
        <div class="mt-10 text-lg text-center text-gray-500">
            Tidak ada hasil rekomendasi untuk saat ini.
        </div>
    @endif
</div>
@endsection
