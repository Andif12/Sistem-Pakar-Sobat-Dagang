@extends('layouts.admin')
@section('title', 'Distribusi Pupuk Bersubsidi')

@section('content')
<div class="p-6 bg-white">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    <div class="space-y-6">

            <div class="p-4 space-y-4 rounded-xl">

                <div class="bg-[#083458] text-white px-4 py-2 rounded-md flex justify-between items-center">
                    <span class="font-semibold">Analisis Pupuk</span>
                </div>

                <div class="relative p-4 space-y-3 bg-white shadow-md rounded-xl">
                    <div class="flex items-center gap-1 font-semibold text-gray-800">
                        <span class="text-base material-symbols-outlined">tune</span>
                        <span>Filter</span>
                    </div>

                    <form method="GET" action="{{ route('distribusi.pupuk') }}">
                        <div class="flex gap-3">
                            <div class="relative w-full">
                                <select name="kecamatan" onchange="this.form.submit()" class="bg-[#CDE4F7] text-black px-4 py-2 rounded-lg w-full cursor-pointer">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <option value="Soreang" {{ request('kecamatan') == 'Soreang' ? 'selected' : '' }}>Soreang</option>
                                    <option value="Bacukiki" {{ request('kecamatan') == 'Bacukiki' ? 'selected' : '' }}>Bacukiki</option>
                                    <option value="Bacukiki Barat" {{ request('kecamatan') == 'Bacukiki Barat' ? 'selected' : '' }}>Bacukiki Barat</option>
                                    <option value="Ujung" {{ request('kecamatan') == 'Ujung' ? 'selected' : '' }}>Ujung</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex justify-between items-center bg-[#CDE4F7] px-4 py-2 rounded-full text-black font-medium">
                            <span>UREA</span>
                            <span>{{ number_format($dataPupuk['UREA'] ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-[#CDE4F7] px-4 py-2 rounded-full text-black font-medium">
                            <span>NPK-FK</span>
                            <span>{{ number_format($dataPupuk['NPK-FK'] ?? 0) }}</span>
                        </div>
                        <div class="col-span-2 flex justify-between items-center bg-[#CDE4F7] px-4 py-2 rounded-full text-black font-medium">
                            <span>NPK</span>
                            <span>{{ number_format($dataPupuk['NPK'] ?? 0) }}</span>
                        </div>
                    </div>

                </div>
    
                <div class="p-4 space-y-2 bg-white shadow rounded-xl">
                        <h2 class="mb-1 text-lg font-medium text-black">Informasi Penyaluran</h2>
                        <canvas id="pieChart" height="180"></canvas>
                </div>
            </div>

        </div>
        <div class="space-y-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="flex flex-col justify-between h-32 p-4 bg-white shadow rounded-xl">
                    <p class="text-base font-semibold text-black">Jumlah Toko</p>
                    <h1 class="text-3xl font-extrabold text-black">{{ $jumlahToko }}</h1>
                    <p class="text-sm text-gray-500">Total toko</p>
                </div>

                <div class="flex flex-col justify-between h-32 p-4 bg-white shadow rounded-xl">
                        <p class="text-base font-semibold text-black">Jumlah Pupuk Terdistribusi</p>
                        <h1 class="text-3xl font-extrabold text-black">{{ number_format($totalDistribusi) }}</h2>
                        <p class="text-sm text-gray-500">Sak</p>
                </div>
            </div>

            <div class="p-4 bg-white shadow rounded-xl">
                <h2 class="mb-4 text-lg font-medium">Distribusi Pupuk</h2>
                
                <div class="overflow-x-auto">
                    <div class="max-h-[320px] overflow-y-auto border border-gray-300 rounded-t-lg">
                        <table class="w-full border-collapse table-auto">
                            <thead class="bg-[#083458] text-base sticky top-0 z-10">
                                <tr>
                                    <th class="p-3 text-center text-white border-r border-gray-300 bg-[#083458]" rowspan="2">Nama Usaha</th>
                                    <th class="p-3 text-center text-white border-r border-gray-300 bg-[#083458]" rowspan="2">No. Register</th>
                                    <th colspan="3" class="p-3 text-center text-white border-r border-gray-300 bg-[#083458]">Jumlah Distribusi</th>
                                </tr>
                                <tr>
                                    <th class="p-3 text-center text-white border-r border-gray-300 bg-[#083458]">UREA</th>
                                    <th class="p-3 text-center text-white border-r border-gray-300 bg-[#083458]">NPK</th>
                                    <th class="p-3 text-center text-white bg-[#083458]">NPK-FK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $namaToko => $barangList)
                                    @php
                                        $no_register = $barangList->first()->no_register;
                                        $urea = $barangList->firstWhere('nama_barang', 'UREA')->total_penyaluran ?? 0;
                                        $npk = $barangList->firstWhere('nama_barang', 'NPK')->total_penyaluran ?? 0;
                                        $npk_fk = $barangList->firstWhere('nama_barang', 'NPK-FK')->total_penyaluran ?? 0;
                                    @endphp
                                    <tr class="border-t hover:bg-gray-100">
                                        <td class="p-2">{{ ucwords(strtolower($namaToko)) }}</td>
                                        <td class="p-2">{{ $no_register }}</td>
                                        <td class="p-2 text-center">{{ $urea }}</td>
                                        <td class="p-2 text-center">{{ $npk }}</td>
                                        <td class="p-2 text-center">{{ $npk_fk }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <p class="mb-2 text-lg font-semibold">Grafik Perkembangan Pupuk</p>
                <canvas id="lineChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    Chart.register(ChartDataLabels);

    const pieLabels = @json($dataPupuk->keys());
    const pieData = @json($dataPupuk->values());

    const pieCtx = document.getElementById('pieChart').getContext('2d');

    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56',
                    '#4BC0C0', '#9966FF', '#FF9F40', '#E7E9ED'
                ],
                borderWidth: 4,
                hoverOffset: 10,
            }]
        },
        options: {
            radius: '60%', // default biasanya '100%' atau penuh
            plugins: {
                datalabels: {
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: (value) => value  // Hanya tampilkan nilai saja, tanpa %
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        font: { size: 16 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}`;
                        }
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });


    // Line Chart
    const lineLabels = @json($lineLabels);
    const lineDatasets = @json($lineDatasets);

    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: lineDatasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Penyaluran'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tahun'
                    }
                }
            }
        }
    });
</script>
@endsection