@extends('layouts.admin')

@section('title', 'Master Admin')

@section('content')
<div class="px-4 py-6 mx-auto sm:px-6 lg:px-8 max-w-7xl">
    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-3">
        <div class="flex items-center p-6 space-x-5 bg-white shadow-md rounded-2xl">
            <div>
                <div class="text-sm font-semibold text-gray-700">Total Permohonan</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalPermohonan }}</div>
                <div class="text-sm text-gray-500">Total Keseluruhan</div>
            </div>
        </div>
        <div class="flex items-center p-6 space-x-5 bg-white shadow-md rounded-2xl">
            <img src="{{ asset('assets/img/icon/validation-approval.png') }}" alt="Icon" class="w-12 h-12">
            <div>
                <div class="text-sm font-semibold text-gray-700">Total Pengguna</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalPengguna }}</div>
                <div class="text-sm text-gray-500">Hingga Bulan Ini</div>
            </div>
        </div>
        <div class="flex items-center p-6 space-x-5 bg-white shadow-md rounded-2xl">
            <img src="{{ asset('assets/img/icon/validation-approval.png') }}" alt="Icon" class="w-12 h-12">
            <div>
                <div class="text-sm font-semibold text-gray-700">Total Pengaduan</div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalPengaduan }}</div>
                <div class="text-sm text-gray-500">Hingga Bulan Ini</div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-3">
        <div class="p-4 bg-white shadow-md xl:col-span-2 rounded-2xl">
            <h3 class="mb-5 text-xl font-semibold text-gray-800">Daftar Permohonan</h3>
            <div class="overflow-y-auto max-h-[calc(3.5rem*14)] rounded-xl shadow-inner">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-[#083458] text-white sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 rounded-tl-xl">Tanggal</th>
                            <th class="px-6 py-3">Nama Pengirim</th>
                            <th class="px-6 py-3">Bidang Terkait</th>
                            <th class="px-6 py-3 rounded-tr-xl">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($permohonan as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 whitespace-nowrap">{{ $p->tanggal }}</td>
                            <td class="px-6 py-3">{{ $p->nama_pengirim }}</td>
                            <td class="px-6 py-3">{{ $p->bidang_terkait }}</td>
                            @php
                                $status = $p->status;
                                $color = match($status) {
                                    'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                    'Disetujui' => 'bg-green-100 text-green-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Diproses' => 'bg-blue-100 text-blue-800',
                                    'Menunggu Persetujuan' => 'bg-blue-100 text-blue-800',
                                    'Butuh Revisi' => 'bg-orange-100 text-orange-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $color }}">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-8">
            <div class="flex flex-col gap-6 xl:flex-row">
                <div class="flex flex-col items-center flex-1 p-6 bg-white shadow-md rounded-2xl">
                    <img src="{{ asset('assets/img/icon/permintaan.png') }}" alt="Icon" class="mb-3 w-14 h-14">
                    <div class="text-base font-semibold text-center text-gray-700">Total Distributor</div>
                    <div class="text-3xl font-bold text-center text-gray-900">{{ $totalDistributor }}</div>
                </div>

                <div class="flex flex-col items-center flex-1 p-6 bg-white shadow-md rounded-2xl">
                    <img src="{{ asset('assets/img/icon/komoditas.png') }}" alt="Icon" class="mb-3 w-14 h-14">
                    <div class="text-base font-semibold text-center text-gray-700">Total IKM Terdaftar</div>
                    <div class="text-3xl font-bold text-center text-gray-900">{{ $totalKomoditas }}</div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-md rounded-2xl">
                <h3 class="mb-4 text-base font-semibold text-gray-800">Statistik Permohonan Perbulan</h3>
                <canvas id="chartPermohonan" height="180"></canvas>
            </div>

            <div class="p-6 bg-white shadow-md rounded-2xl">
                <h3 class="mb-4 text-base font-semibold text-gray-800">Status Permohonan</h3>
                <canvas id="combinedPieChart" height="180"></canvas>
            </div>

        </div>
    </div>
</div>
@php
    $labels = ['Menunggu', 'Disetujui', 'Ditolak'];
    $data = [
        $statusCounts['Menunggu'],
        $statusCounts['Disetujui'],
        $statusCounts['Ditolak'],
    ];
@endphp

<script>
    const ctxLine = document.getElementById('chartPermohonan').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelsPermohonan) !!},
            datasets: [{
                label: 'Jumlah Surat Masuk',
                data: {!! json_encode($dataPermohonan) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.2)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision:0
                    }
                }
            }
        }
    });


    const ctx = document.getElementById('combinedPieChart').getContext('2d');
    const combinedPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah',
                data: @json($data),
                backgroundColor: ['#facc15', '#22c55e', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

@endsection