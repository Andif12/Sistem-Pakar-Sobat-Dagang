@extends('layouts.admin')

@section('title', 'Kelola Surat Permohonan')

@section('content')

<div class="relative w-full h-36">
    <img src="{{ asset('assets\img\background\dagang.jpg') }}" alt="Background" class="object-cover w-full h-full" />
    <a href="{{ route('dashboard.perdagangan') }}"
            class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
            <span class="text-2xl material-symbols-outlined">
                arrow_back
            </span>
    </a>
</div>
<div class="container px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6">
        <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <form method="GET" action="{{ route('perdagangan.kelolaSurat') }}">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">search</span>
            <input type="text" placeholder="Cari Nama Pengguna" name="search"
                class="w-full p-3 pl-10 bg-transparent border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                value="{{ request('search') }}"/>
            </form>
        </div>
    </div>
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
                        <th class="px-4 py-3 border-b rounded-tl-xl bg-[#083358] text-center">No</th>
                        <th class="px-4 py-3 border-b bg-[#083358] text-center">Nama Pemohon</th>
                        <th class="px-4 py-3 border-b bg-[#083358] text-center">Jenis Surat</th>
                        <th class="px-4 py-3 border-b bg-[#083358] text-center">Tanggal Dikirim</th>
                        <th class="px-4 py-3 border-b bg-[#083358] text-center">Status</th>
                        <th class="px-4 py-3 border-b bg-[#083358] text-center">Surat Balasan</th>
                        <th class="px-4 py-3 border-b rounded-tr-xl bg-[#083358] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataSurat as $index => $item)
                    <tr class="text-center border-b" data-status="{{ $item->status }}">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $item->user->nama ?? 'Tidak Diketahui' }}</td>
                        @php
                        $jenisSuratMap = [
                        'surat_rekomendasi_perdagangan' => 'Surat Rekomendasi',
                        'surat_keterangan_perdagangan' => 'Surat Keterangan',
                        'dan_lainnya_perdagangan' => 'Surat Lainnya',
                        ];
                        @endphp
                        <td class="px-4 py-2">
                            {{ $jenisSuratMap[$item->jenis_surat] ?? $item->jenis_surat }}
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if ($item->status == 'diterima')
                            <span class="font-medium text-green-600">Disetujui</span>
                            @elseif ($item->status == 'ditolak')
                            <span class="font-medium text-red-600">Ditolak</span>
                            @else
                            <span class="font-medium text-yellow-400">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($item->file_balasan)
                                <a href="{{ asset('storage/' . $item->file_balasan) }}" target="_blank" class="text-blue-600 underline">Lihat Balasan</a>
                            @else
                                <span class="italic text-gray-500">Belum tersedia</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('perdagangan.detailSurat', $item->id_permohonan) }}"
                                class="inline-block px-4 py-1.5 rounded-full bg-[#083358] text-white text-sm font-semibold transition hover:bg-blue-300 hover:text-black">
                                Lihat Permohonan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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
</div>
@endsection