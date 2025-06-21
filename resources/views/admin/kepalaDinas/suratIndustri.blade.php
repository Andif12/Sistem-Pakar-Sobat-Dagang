@extends('layouts.metrologi.kadis')
@section('title', 'Data Surat Bidang Industri')
@section('content')

<div class="relative w-full h-32 bg-white">
    <img src="{{ asset('assets\img\background\user_industri.png') }}" alt="Background" class="object-cover w-full h-full" />
    <div class="absolute bottom-0 w-full -left-4 h-60 -z-10">
        <img src="{{ asset('assets/img/background/user_industri.png') }}" alt="Background" class="object-cover w-full h-full -ml-16">
    </div>
    <a href="{{ route('persuratan-kadis') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">
            arrow_back
        </span>
    </a>
</div>
<div class="container px-4 mx-auto -mt-8 ">
    <div class="flex justify-center mb-6">
        <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <form method="GET" action="{{ route('kadis.industri.surat') }}">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">search</span>
            <input type="text" placeholder="Cari" name="search"
                class="w-full p-3 pl-10 bg-transparent border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                value="{{ request('search') }}"/>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mb-6 mx-7 sm:grid-cols-3 md:grid-cols-3">
        <a href="#" class="flex items-center p-5 space-x-4 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
            <img src="{{ asset('assets/img/icon/folder-download.png') }}" alt="Surat Masuk" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-black">Jumlah Surat Masuk</p>
                <p class="text-2xl font-bold text-blue-600">{{ $totalSuratIndustri }}</p>
            </div>
        </a>

        <a href="#" class="flex items-center p-5 space-x-4 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
            <img src="{{ asset('assets/img/icon/Verif.png') }}" alt="Terverifikasi" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-black">Jumlah Surat Terverifikasi</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $totalSuratTerverifikasi }}</p>
            </div>
        </a>

        <a href="#" class="flex items-center p-5 space-x-4 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
            <img src="{{ asset('assets/img/icon/surat_ditolak.png') }}" alt="Ditolak" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-black">Jumlah Surat Ditolak</p>
                <p class="text-2xl font-bold text-green-600">{{ $totalSuratDitolak }}</p>
            </div>
        </a>
    </div>   
    <div class="p-4 mb-6 rounded-xl">
        @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mt-1 ml-4 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="container px-4 pb-4 mx-auto">
            <div class="flex items-center justify-end gap-2 mb-4">
                <label for="filterStatus" class="text-sm font-medium text-gray-700">
                    Filter Status:
                </label>
                <select id="filterStatus"
                    class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 bg-white text-gray-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out hover:border-blue-400">
                    <option value="semua">Semua</option>
                    <option value="diterima">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="menunggu">Menunggu</option>
                </select>
            </div>
            <div class="overflow-hidden bg-white border border-gray-300 shadow-md rounded-xl">
                <div class="overflow-y-auto max-h-[500px] scrollbar-hide">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#083358] text-white font-semibold sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-2 text-center rounded-l">No</th>
                                <th class="px-4 py-2 text-center">Nama Pemohon</th>
                                <th class="px-4 py-2 text-center">Tanggal Dikirim</th>
                                <th class="px-4 py-2 text-center">Status</th>
                                <th class="px-4 py-2 text-center">Jenis Surat</th>
                                <th class="px-4 py-2 text-center">Dokumen Surat</th>
                                <th class="px-4 py-2 text-center rounded-r">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @php $nomor = 1; @endphp
                            @foreach($suratMasuk as $index => $surat)
                            <tr class="text-center border-b" data-status="{{ $surat->status }}">
                                <td class="px-4 py-2 text-center rounded-l">{{ $nomor++ }}</td>
                                <td class="px-4 py-2 text-center">{{ $surat->user->nama ?? 'Tidak Diketahui' }}</td>
                                <td class="px-4 py-2 text-center">{{ $surat->tgl_pengajuan }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if($surat->status == 'menunggu')
                                    <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-300 rounded-full">Menunggu</span>
                                    @elseif($surat->status == 'diterima')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-300 rounded-full">Diterima</span>
                                    @elseif($surat->status == 'ditolak')
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-300 rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                @php
                                $jenisSuratMap = [
                                'surat_rekomendasi_industri' => 'Surat Rekomendasi',
                                'surat_keterangan_industri' => 'Surat Keterangan',
                                'dan_lainnya_industri' => 'Surat Lainnya',
                                ];
                                @endphp
                                <td class="px-4 py-2 text-center">{{ $jenisSuratMap[$surat->jenis_surat] ?? 'Tidak tersedia' }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($surat->file_balasan)
                                        <a href="{{ asset('storage/' . $surat->file_balasan) }}" target="_blank" class="text-blue-600 underline">Lihat Balasan</a>
                                    @else
                                        <span class="italic text-gray-500">Belum tersedia</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if ($surat->file_balasan)
                                        @if ($surat->status !== 'menunggu')
                                            <button class="px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed" disabled>✓</button>
                                        @else
                                            <form action="{{ route('kadissuratPerdagangan.setujui', $surat->id_permohonan) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">Setujui</button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="flex items-center justify-center text-red-500">
                                            <span class="text-base material-symbols-outlined">warning</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const statusPieCtx = document.getElementById('statusPie').getContext('2d');
    const suratChartCtx = document.getElementById('suratChart').getContext('2d');

    let statusPie, suratChart;

    function renderCharts(statusCounts, dataBulanan) {
        if (statusPie) statusPie.destroy();
        if (suratChart) suratChart.destroy();

        statusPie = new Chart(statusPieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Disetujui', 'Ditolak', 'Menunggu'],
                datasets: [{
                    data: [statusCounts.diterima, statusCounts.ditolak, statusCounts.menunggu],
                    backgroundColor: ['#10b981', '#ef4444', '#facc15'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        suratChart = new Chart(suratChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Surat Masuk',
                    data: dataBulanan,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }


    // Handler ketika tahun diubah
    document.getElementById('filterTahun').addEventListener('change', function() {
        const selectedYear = this.value;

        fetch(`{{ route('kabid.industri') }}?tahun=${selectedYear}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderCharts(data.statusCounts, data.dataBulanan);
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterSelect = document.getElementById('filterStatus');
        const rows = document.querySelectorAll('tbody tr');

        filterSelect.addEventListener('change', function () {
            const selected = this.value;

            rows.forEach(row => {
                const status = row.getAttribute('data-status');

                if (selected === 'semua' || status === selected) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection