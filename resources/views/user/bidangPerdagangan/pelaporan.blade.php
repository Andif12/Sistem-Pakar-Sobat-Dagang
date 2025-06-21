@extends('layouts.home')
@section('title', 'Pelaporan')
@section('content')

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<div class="relative w-full h-64">
    <img src="{{ asset('assets\img\background\dagang.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <a href="{{ route('user.dashboard') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">arrow_back</span>
    </a>
    <div class="absolute bottom-0 transform -translate-x-1/2 translate-y-1/2 left-1/2">
        <p class="px-6 py-3 font-bold text-[#083358] bg-white shadow-md text-md font-istok rounded-3xl shadow-black/40">
            PELAPORAN PENYALURAN PUPUK BERSUBSIDI
        </p>
    </div>
</div>

<div class="container p-6 mx-auto mt-8">
    <div class="judul-tabel">
        <p class="px-6 py-3 text-xl font-bold font-istok rounded-3xl text-[#083458]">TOKO</p>
    </div>
    <div class="overflow-x-auto hide-scrollbar rounded-2xl border-[#889EAF] shadow-md shadow-black/40">
        <table class="min-w-full border-collapse table-auto">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Nama</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Kecamatan</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">No Register</th>
                    <th class="px-4 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Rencana Kebutuhan</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tokos as $toko)
                    <tr class="border-b-2 border-[#889EAF] hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r-2 border-[#889EAF]">{{ $toko->nama_toko }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $toko->kecamatan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $toko->no_register }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $toko->rencana->jumlah ?? 'N/A' }} sak</td>
                        
                        <td class="flex items-center justify-center gap-2 px-6 py-4 text-sm text-gray-700">
                            <a href="{{ route('pelaporan.showDataDistribusi', ['id_toko' => $toko->id_toko]) }}">
                                <button class="px-3 py-1 text-xs font-semibold rounded-md text-white bg-[#083458] hover:bg-[#0a416d] transition">
                                    Distribusi
                                </button>
                            </a>

                            <button 
                                class="px-3 py-1 text-xs font-semibold text-white transition bg-red-600 rounded-md hover:bg-red-700"
                                onclick="openModal('{{ $toko->id_toko }}')"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-center mt-6">
            <nav class="inline-flex -space-x-px">
                @if ($tokos->onFirstPage())
                    <span class="px-4 py-2 text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg">«</span>
                @else
                    <a href="{{ $tokos->previousPageUrl() }}" class="px-4 py-2 text-[#083458]-600 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100">«</a>
                @endif

                {{-- Halaman --}}
                @foreach ($tokos->getUrlRange(1, $tokos->lastPage()) as $page => $url)
                    @if ($page == $tokos->currentPage())
                        <span class="px-4 py-2 text-white bg-[#083458] border border-gray-300">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" class="px-4 py-2 text-[#083458]-600 bg-white border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Tombol Selanjutnya --}}
                @if ($tokos->hasMorePages())
                    <a href="{{ $tokos->nextPageUrl() }}" class="px-4 py-2 text-[#083458]-600 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100">»</a>
                @else
                    <span class="px-4 py-2 text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg">»</span>
                @endif
            </nav>
        </div>
        <div class="py-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('pelaporan.showInputForm') }}">
                <p class="px-6 py-3 text-sm font-bold font-istok rounded-xl text-white bg-[#083458] w-fit">
                    Tambahkan Data untuk Toko
                </p>
            </a>

            <button 
                data-modal-target="modalPengaduan" 
                data-modal-toggle="modalPengaduan"
                class="px-6 py-3 text-sm font-bold font-istok rounded-xl text-white bg-red-600 w-fit"
            >
                Pengaduan Distributor
            </button>
        </div>
</div>

<div id="modalPengaduan" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50">
  <div class="flex items-center justify-center min-h-screen px-4 py-6">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6">
      
      <h2 class="text-lg font-bold mb-4 text-center text-gray-800">Formulir Pengaduan Distributor</h2>
      <form action="{{ route('pelaporan.pengaduan.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Pengirim</label>
          <input type="text" class="w-full border border-gray-300 p-2 rounded-xl bg-gray-100" value="{{ ucwords(auth()->guard('user')->user()->nama) }}" readonly>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
          <input type="text" name="judul" class="w-full border border-gray-300 p-2 rounded-xl" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Isi Pengaduan</label>
          <textarea name="isi" rows="4" class="w-full border border-gray-300 p-2 rounded-xl" required></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-2">
          <button type="button" onclick="document.getElementById('modalPengaduan').classList.add('hidden')" class="px-5 py-2 bg-gray-300 text-gray-700 rounded-full hover:bg-gray-400 transition">
            Batal
          </button>
          <button type="submit" class="px-5 py-2 bg-[#083458]  text-white rounded-full hover:bg-blue-300 hover:text-black transition">
            Kirim
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

@if(session('success'))
<div id="modalSukses" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 sm:px-6">
  <div class="bg-white relative rounded-2xl shadow-xl w-full max-w-sm sm:max-w-md md:max-w-lg p-6 sm:p-8 text-center">

    <button onclick="document.getElementById('modalSukses').classList.add('hidden')" 
      class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold focus:outline-none">
      &times;
    </button>

    <h2 class="text-lg sm:text-xl font-bold text-green-600 mb-2">Berhasil!</h2>
    <p class="text-sm sm:text-base text-gray-700 mb-2">{{ session('success') }}</p>

  </div>
</div>
@endif

<div class="container p-6 mx-auto mt-8 overflow-x-hidden">
    <form method="GET" id="filterForm">
        <div class="flex flex-wrap justify-end w-full gap-4 mb-4 pilihanbulandantahun">
            <!-- Dropdown Toko -->
            <div class="w-full sm:w-auto">
                <select name="toko" id="tokoSelect"
                    class="block w-full px-4 py-2 text-white text-sm border border-[#889EAF] rounded-lg focus:ring-[#083458] focus:border-[#889EAF] bg-[#083458]">
                    <option value="">Pilih Toko</option>
                    @foreach ($tokoview as $toko)
                        <option value="{{ $toko->id_toko }}" {{ request('toko') == $toko->id_toko ? 'selected' : '' }}>
                            {{ $toko->nama_toko }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Bulan -->
            <div class="w-full sm:w-auto">
                <select name="bulan" id="bulanSelect"
                    class="block w-full px-4 py-2 text-white text-sm border border-[#889EAF] rounded-lg focus:ring-[#083458] focus:border-[#889EAF] bg-[#083458]"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">Pilih Bulan</option>
                    @for ($b = 1; $b <= 12; $b++)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Dropdown Tahun -->
            <div class="w-full sm:w-auto">
                <select name="tahun" id="tahunSelect"
                    class="block w-full px-4 py-2 text-white text-sm border border-[#889EAF] rounded-lg focus:ring-[#083458] focus:border-[#889EAF] bg-[#083458]"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">Pilih Tahun</option>
                    @for ($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </form>

    <div class="judul-tabel">
        <p class="px-6 py-2 text-xl font-bold font-istok rounded-3xl text-[#083458]">DISTRIBUSI</p>
    </div>

    <div class="overflow-x-auto hide-scrollbar rounded-2xl border-[#889EAF] shadow-md shadow-black/40">
        <table class="min-w-full border-collapse table-auto">
            <thead>
                <tr>
                    <th rowspan="2"
                        class="px-6 py-3 text-center align-middle text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">
                        Nama Barang</th>
                    @for ($i = 1; $i <= 4; $i++)
                        <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]" colspan="3">
                            Minggu {{ $i }}
                        </th>
                    @endfor
                </tr>
                <tr>
                    @for ($i = 1; $i <= 4; $i++)
                        <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Stok Awal (sak)</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Penyaluran (sak)</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-white bg-[#083458] border-2 border-[#889EAF]">Stok Akhir (sak)</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($dataByMinggu as $nama_barang => $mingguData)
                    <tr class="border-b-2 border-[#889EAF] hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r-2 border-[#889EAF]">{{ $nama_barang }}</td>
                        @for ($i = 1; $i <= 4; $i++)
                            <td class="text-center px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $mingguData["minggu_$i"]['stok_awal'] }}</td>
                            <td class="text-center px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $mingguData["minggu_$i"]['penyaluran'] }}</td>
                            <td class="text-center px-6 py-4 text-sm text-gray-700 border-r-2 border-[#889EAF]">{{ $mingguData["minggu_$i"]['stok_akhir'] }}</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-40">
        <div class="w-full max-w-sm p-6 text-center bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
            <p class="mb-6 text-sm text-gray-600">Apakah Anda yakin ingin menghapus toko ini?</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeModal()" class="px-4 py-1 text-xs bg-gray-300 rounded-md hover:bg-gray-400">Batal</button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-1 text-xs text-white bg-red-600 rounded-md hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .hide-scrollbar {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE 10+ */
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Opera */
    }
</style>

<script>
    document.getElementById('tokoSelect').addEventListener('change', function () {
        const bulanSelect = document.getElementById('bulanSelect');
        const tahunSelect = document.getElementById('tahunSelect');

        // Jika user belum pilih bulan/tahun, set otomatis ke sekarang
        if (!bulanSelect.value) {
            bulanSelect.value = new Date().getMonth() + 1; // Bulan dimulai dari 0
        }

        if (!tahunSelect.value) {
            tahunSelect.value = new Date().getFullYear();
        }

        // Kirim form
        document.getElementById('filterForm').submit();
    });
    function openModal(id) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('deleteForm');
        form.action = `/toko/${id}`; // Atur URL dinamis

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
    
    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        const target = button.getAttribute('data-modal-target');
        button.addEventListener('click', () => {
        document.getElementById(target).classList.remove('hidden');
        });
    });
</script>
@endsection