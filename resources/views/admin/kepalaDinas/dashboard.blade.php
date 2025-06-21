@extends('layouts.metrologi.kadis')
@section('title', 'Dashboard Kepala Dinas')
@section('content')

<div class="min-h-screen p-4 bg-gray-100">
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
        <div class="flex items-center p-4 space-x-4 bg-white shadow-md rounded-xl">
            <img src="{{ asset('assets/img/icon/folder-download.png') }}" class="w-10 h-10">
            <div>
                <p class="text-sm text-gray-500">Jumlah Surat Masuk</p>
                <p class="text-xl font-bold text-blue-600">{{ $totalSuratSmuaBidang['totalSuratKeseluruhan'] }}</p>
            </div>
        </div>
        <div class="flex items-center p-4 space-x-4 bg-white shadow-md rounded-xl">
            <img src="{{ asset('assets/img/icon/Verif.png') }}" class="w-10 h-10">
            <div>
                <p class="text-sm text-gray-500">Jumlah Surat Disetujui</p>
                <p class="text-xl font-bold text-yellow-500">{{ $totalSuratSmuaBidang['totalSuratTerverifikasiKeseluruhan'] }}</p>
            </div>
        </div>
        <div class="flex items-center p-4 space-x-4 bg-white shadow-md rounded-xl">
            <img src="{{ asset('assets/img/icon/surat_ditolak.png') }}" class="w-10 h-10">
            <div>
                <p class="text-sm text-gray-500">Jumlah Surat Ditolak</p>
                <p class="text-xl font-bold text-green-600">{{ $totalSuratSmuaBidang['totalSuratDitolakKeseluruhan'] }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik Metrologi -->
    <div class="p-4 mb-6 bg-white shadow-md rounded-xl">
        <h3 class="mb-2 text-sm font-semibold text-gray-700">Bidang Metrologi</h3>
        <p class="mb-4 text-lg font-semibold">Grafik Perbandingan Jumlah Tera</p>
        <div class="h-[280px]">
            <canvas id="chartLine"></canvas>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('kadis-metro') }}" class="mt-auto block w-full bg-[#083458] text-white px-4 py-2 rounded-md text-center text-sm hover:bg-blue-300 hover:text-black">Lihat Detail</a>
        </div>
    </div>

    <!-- Perdagangan dan Industri -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <!-- Bidang Perdagangan -->
        <div class="flex flex-col h-full p-4 bg-white shadow-md rounded-xl">
        <h3 class="mb-2 text-sm font-semibold text-gray-700">Bidang Perdagangan</h3>

        <select id="lokasiSelect" class="mb-4 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 w-fit">
            <option value="Pasar Sumpang" {{ $selectedLokasi == 'Pasar Sumpang' ? 'selected' : '' }}>Pasar Sumpang</option>
            <option value="Pasar Lakessi" {{ $selectedLokasi == 'Pasar Lakessi' ? 'selected' : '' }}>Pasar Lakessi</option>
        </select>

        <div class="flex flex-col flex-grow space-y-4 md:flex-row md:space-x-4 md:space-y-0">
            <!-- Chart Naik -->
            <div class="flex flex-col items-center flex-1">
                <p class="mb-1 font-medium text-center text-gray-600">Naik</p>
                <div class="w-full max-w-[180px] aspect-square">
                    <canvas id="chartPerdaganganNaik" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Chart Turun -->
            <div class="flex flex-col items-center flex-1">
                <p class="mb-1 font-medium text-center text-gray-600">Turun</p>
                <div class="w-full max-w-[180px] aspect-square">
                    <canvas id="chartPerdaganganTurun" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <a href="{{ route('kepalaDinas.perdagangan') }}" class="mt-4 block w-full bg-[#083458] text-white px-4 py-2 rounded-md text-center text-sm hover:bg-blue-300 hover:text-black">
            Lihat Detail
        </a>
    </div>


        <!-- Bidang Industri -->
        <div class="flex flex-col h-full p-4 bg-white shadow-md rounded-xl">
            <h3 class="mb-2 text-sm font-semibold text-gray-700">Bidang Industri</h3>
            <div class="max-w-full max-h-[220px] overflow-hidden flex-grow">
                <canvas id="chartIndustri" class="w-600px max-w-full max-h-[170px]"></canvas>
            </div>
            <a href="{{route('kadis.industri')}}" class="mt-auto block w-full bg-[#083458] text-white px-4 py-2 rounded-md text-center text-sm hover:bg-blue-300 hover:text-black">
                Lihat Detail
            </a>
        </div>
    </div>

</div>

<script>
    //Bidang Perdagangan Naik
    const naikCtx = document.getElementById('chartPerdaganganNaik');
    const turunCtx = document.getElementById('chartPerdaganganTurun');

    if (naikCtx) {
        const dataPieNaik = @json($topHargaNaik);
        new Chart(naikCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: dataPieNaik.map(i => i.label),
                datasets: [{
                    data: dataPieNaik.map(i => i.price_change),
                    backgroundColor: dataPieNaik.map(i => i.color),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'none' },
                    datalabels: {
                        formatter: (value, context) => {
                            const dataset = context.chart.data.datasets[0];
                            const total = dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return percentage + '%';
                        },
                        color: '#fff',
                        font: { weight: 'bold', size: 12 }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    if (turunCtx) {
        const dataPieTurun = @json($topHargaTurun);
        new Chart(turunCtx.getContext('2d'), {
            type: 'pie',
            data: {
                labels: dataPieTurun.map(i => i.label),
                datasets: [{
                    data: dataPieTurun.map(i => i.price_change),
                    backgroundColor: dataPieTurun.map(i => i.color),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'none' },
                    datalabels: {
                        formatter: (value, context) => {
                            const dataset = context.chart.data.datasets[0];
                            const total = dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = (value / total * 100).toFixed(1);
                            return percentage + '%';
                        },
                        color: '#fff',
                        font: { weight: 'bold', size: 12 }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Bidang Metrologi (linechart)
    const ctxLine = document.getElementById('chartLine');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [
                {
                    label: 'Tahun {{ $calibrationData['currentYear'] }}',
                    data: {{ $calibrationData['currentYearData'] }},
                    borderColor: '#60a5fa',
                    backgroundColor: 'rgba(96, 165, 250, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Tahun {{ $calibrationData['lastYear'] }}',
                    data: {{ $calibrationData['lastYearData'] }},
                    borderColor: '#0c3252',
                    backgroundColor: 'rgba(12, 50, 82, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Tera'
                    }
                }
            },
            maintainAspectRatio: false,
            responsive: true
        }
    });

    // Bar Chart Perbandingan IKM
    const levelLabels = {!! json_encode(array_keys($levelInvestasi)) !!};
    const levelData = {!! json_encode(array_values($levelInvestasi)) !!};
    const chartIndustriCtx = document.getElementById('chartIndustri').getContext('2d');
    const chartIndustri = new Chart(chartIndustriCtx, {
        type: 'bar',
        data: {
        labels: levelLabels,
        datasets: [{
            label: 'Jumlah IKM',
            data: levelData, 
            backgroundColor: [
            'rgba(255, 206, 86, 0.7)',  
            'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
            'rgba(255, 206, 86, 1)',
            'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1,
        }]
        },
        options: {
        responsive: true,
        plugins: {
            legend: {
            display: false,
            // position: 'bottom'
            },
            tooltip: {
            callbacks: {
                label: function(context) {
                return context.parsed.y + ' IKM';
                }
                }
            }
            },
        scales: {
            y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Jumlah IKM'
            }
            },
            x: {
            title: {
                display: true,
                text: 'Level IKM'
            }
            }
        }
        }
    });
</script>
<script>
    document.getElementById('lokasiSelect').addEventListener('change', function () {
        const selectedLokasi = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('lokasi', selectedLokasi); // tambahkan atau ubah param lokasi
        window.location.href = url.toString(); // reload halaman dengan parameter baru
    });
</script>

@endsection