@extends('layouts.admin')
@section('title', 'Dashboard Perdagangan')

@section('content')
<div class="min-h-screen p-6 bg-white">
    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 md:grid-cols-3">
        <a href="#" class="flex items-center p-5 space-x-4 transition bg-white shadow-md rounded-2xl hover:shadow-lg">
            <img src="{{ asset('assets/img/icon/folder-download.png') }}" alt="Surat Masuk" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-black">Jumlah Surat Masuk</p>
                <p class="text-2xl font-bold text-blue-600">{{ $totalSuratPerdagangan }}</p>
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

<div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-2">
    <div class="overflow-x-auto rounded-xl shadow max-h-[500px] overflow-y-auto scrollbar-hide">
        <table class="min-w-full text-sm text-left border-separate border-spacing-0">
            <thead class="sticky top-0 z-10 text-black bg-blue-300">
                <tr>
                    <th class="px-4 py-2 rounded-tl-xl">Nama Barang</th>
                    <th class="px-4 py-2">Kategori Barang</th>
                    <th class="px-4 py-2">Harga Satuan (kg)</th>
                    <th class="px-4 py-2 rounded-tr-xl">Update Terakhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarHarga as $harga)
                    <tr class="border-b odd:bg-white even:bg-gray-100">
                        <td class="px-4 py-2 ">{{ $harga->nama_barang }}</td>
                        <td class="px-4 py-2">{{ $harga->kategori_barang }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($harga->harga_satuan, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($harga->tanggal)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Tidak ada data harga barang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="w-full max-w-xl p-4 mx-auto bg-white shadow-lg rounded-2xl">
        <div class="flex items-center gap-2 mb-4 text-base font-semibold text-gray-800 sm:text-lg">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3v18h18" />
                <path d="M4 14l4-4 5 5 7-7" />
            </svg>
            Statistik Indeks Harga
        </div>

        <div class="relative w-full mb-4 h-60 sm:h-80">
            <canvas id="hargaChart" class="w-full h-full"></canvas>
        </div>

        <div class="grid grid-cols-2 text-sm text-center gap-y-4 gap-x-2 sm:grid-cols-4">
            <div>
                <p class="text-gray-500">Terendah</p>
                <p id="terendah" class="text-base font-semibold sm:text-lg">Rp 20.000</p>
            </div>
            <div>
                <p class="text-gray-500">Rata-rata</p>
                <p id="rata_rata" class="text-base font-semibold sm:text-lg">Rp 36.446</p>
            </div>
            <div>
                <p class="text-gray-500">Tertinggi</p>
                <p id="tertinggi" class="text-base font-semibold sm:text-lg">Rp 54.300</p>
            </div>
            <div>
                <p class="text-gray-500">Volatilitas</p>
                <p id="volatilitas" class="text-base font-semibold sm:text-lg">94.1%</p>
            </div>
        </div>
    </div>
</div>
<h2 class="mt-4 mb-4 text-lg font-semibold text-center text-black lg:text-left">Daftar Surat Masuk</h2>
    <div class="flex flex-col gap-6 mb-6 lg:flex-row lg:items-start ">
        <div class="w-full overflow-hidden border lg:w-3/4 rounded-xl">
            <div class="overflow-x-auto max-h-[500px] custom-scrollbar">
                <table class="min-w-full text-sm text-left">
                    <thead class="sticky top-0 z-10 bg-[#083358] text-white font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-center border-b rounded-tl-xl">No</th>
                            <th class="px-4 py-3 text-center border-b">Nama Pemohon</th>
                            <th class="px-4 py-3 text-center border-b">Jenis Surat</th>
                            <th class="px-4 py-3 text-center border-b">Tanggal Dikirim</th>
                            <th class="px-4 py-3 text-center border-b rounded-tr-xl">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataSurat as $index => $item)
                            <tr class="text-center border-b ">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $item->user->nama ?? 'Tidak Diketahui' }}</td>
                                @php
                                    $jenisSuratMap = [
                                        'surat_rekomendasi_perdagangan' => 'Surat Rekomendasi',
                                        'surat_keterangan_perdagangan' => 'Surat Keterangan',
                                    ];
                                @endphp
                                <td class="px-4 py-2">{{ $jenisSuratMap[$item->jenis_surat] ?? $item->jenis_surat }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->status == 'diterima')
                                        <span class="font-medium text-green-600">Disetujui</span>
                                    @elseif ($item->status == 'ditolak')
                                        <span class="font-medium text-red-600">Ditolak</span>
                                    @else
                                        <span class="font-medium text-yellow-400">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col w-full gap-4 lg:w-1/4">
            <div class="flex flex-col items-center gap-4 p-6 bg-white border border-gray-200 shadow-md rounded-2xl">
                <a href="{{ route('perdagangan.kelolaSurat') }}" 
                class="flex items-center justify-center gap-2 px-5 py-2 text-sm font-semibold text-black bg-white border border-gray-200 rounded-lg shadow transition hover:bg-gray-100 min-w-[150px]">
                    <img src="{{ asset('assets/img/icon/eye.png') }}" alt="Kelola Icon" class="w-4 h-4">
                    Kelola Surat
                </a>
                <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-[0_4px_20px_rgba(0,96,255,0.15)]">
                    <img src="{{ asset('assets/img/icon/quote.png') }}" alt="Quote" class="w-5 h-5">
                    <p class="text-sm italic text-center lg:text-left">Perdagangan yang sehat, <br>ekonomi yang kuat</p>
                </div>
            </div>
              <div class="p-4 bg-white shadow-lg rounded-2xl">
            <div class="mb-2 font-semibold text-center text-gray-800 y">
                Penyaluran Pupuk
            </div>
            <canvas id="pupukChart" class="mx-auto w-20 h-20"></canvas>
            <div class="flex justify-center gap-4 mt-2 text-sm">
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-900 rounded-full"></span> Urea</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-400 rounded-full"></span> NPK</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-200 rounded-full"></span> NPK-Fk</span>
            </div>
        </div>
        </div>
    </div>
    <div class="p-6 bg-white shadow-md rounded-2xl">
            <h2 class="mb-4 text-lg font-semibold text-black">Update Berita Terbaru</h2>
            <ul class="space-y-3 text-sm text-gray-700 max-h-64 overflow-y-auto">
                @foreach ($beritaTerbaru as $berita)
                <li>
                    <a href="{{ route('berita.utama', $berita->judul) }}" target="_blank" class="text-black font-semibold hover:text-blue-700 hover:underline">
                        {{ $berita->judul }}
                    </a>
                    <div class="text-xs text-gray-500">{{ $berita->created_at->format('d M Y') }}</div>
                </li>
                @endforeach
            </ul>
        </div>
</div>

<script>
    // Grafik line harga pasar Sumpang dan Lakessi
    const ctxHarga = document.getElementById('hargaChart').getContext('2d');
    new Chart(ctxHarga, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Pasar Sumpang',
                    data: {!! json_encode($hargaSumpang) !!},
                    fill: false,
                    borderColor: '#3b82f6',
                    backgroundColor: '#3b82f6',
                    tension: 0.3
                },
                {
                    label: 'Pasar Lakessi',
                    data: {!! json_encode($hargaLakessi) !!},
                    fill: false,
                    borderColor: '#ef4444',
                    backgroundColor: '#ef4444',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Biar bisa tinggi sesuai container
            layout: {
                padding: {
                    left: 20, // Tambah ruang kiri agar label harga tidak kepotong
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString(), // Format harga
                        color: '#374151' // opsional, abu-abu gelap
                    },
                    title: {
                        display: true,
                        text: 'Harga (Rp)',
                        color: '#6b7280',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        color: '#374151',
                        maxRotation: 45,
                        minRotation: 30
                    }
                }
            }
        }
    });

    // Update statistik harga
    document.getElementById("terendah").innerText = "Rp {{ $terendah }}";
    document.getElementById("rata_rata").innerText = "Rp {{ $rata_rata }}";
    document.getElementById("tertinggi").innerText = "Rp {{ $tertinggi }}";
    document.getElementById("volatilitas").innerText = "{{ $volatilitas }}";

</script>

<script>
    const pupukChart = document.getElementById('pupukChart').getContext('2d');

    const dataPupuk = {
        labels: ['Urea', 'NPK', 'NPK-FK'],
        datasets: [{
            data: [
                {{ $pupukTahunan->urea ?? 0 }},
                {{ $pupukTahunan->npk ?? 0 }},
                {{ $pupukTahunan->npk_fk ?? 0 }}
            ],
            backgroundColor: [
                '#1e3a8a', // Blue-900
                '#60a5fa', // Blue-400
                '#bfdbfe'  // Blue-200
            ],
            borderWidth: 1
        }]
    };

    new Chart(pupukChart, {
        type: 'pie',
        data: dataPupuk,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // karena sudah pakai legend manual di bawah canvas
                }
            }
        }
    });
</script>

<style>
.custom-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.custom-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>


@endsection