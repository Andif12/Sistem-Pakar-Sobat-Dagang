@extends('layouts.admin')
@section('title', 'Lihat Laporan Distribusi Barang')

@section('content')
<div class="relative w-full h-36">
    <img src="{{ asset('assets\img\background\dagang.jpg') }}" alt="Background" class="object-cover w-full h-full" />
    <a href="{{ route('lihat.laporan.distribusi') }}"
            class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
            <span class="text-2xl material-symbols-outlined">
                arrow_back
            </span>
    </a>
</div>
<div class="max-w-3xl p-6 mx-auto bg-white rounded shadow  mt-6">
    <h2 class="mb-4 text-2xl font-bold text-center">Cari Laporan Pupuk</h2>

    {{-- Info Toko --}}
    <div class="mb-4">
        <label class="block font-medium">Nama Toko:</label>
        <input type="text" value="{{ ucwords($toko->nama_toko) }}" disabled class="w-full p-2 bg-gray-100 border rounded-xl">
    </div>

    {{-- Form Filter --}}
    <form action="{{ route('admin.editLaporanPupuk') }}" method="GET">
        <input type="hidden" name="id_toko" value="{{ $toko->id_toko }}">
        <input type="hidden" name="id_stok_opname" value="{{ $toko->id_stok_opname }}">
        {{-- Jenis Pupuk --}}
        <div class="mb-4">
            <label class="block font-medium">Jenis Pupuk:</label>
            <select name="nama_barang" class="w-full p-2 border rounded-xl" required>
                <option value="">Pilih Jenis Pupuk</option>
                <option value="NPK" {{ request('nama_barang') == 'NPK' ? 'selected' : '' }}>NPK</option>
                <option value="UREA" {{ request('nama_barang') == 'UREA' ? 'selected' : '' }}>UREA</option>
                <option value="NPK-FK" {{ request('nama_barang') == 'NPK-FK' ? 'selected' : '' }}>NPK-FK</option>
            </select>
        </div>

        {{-- Tahun --}}
        <div class="mb-4">
            <label class="block font-medium">Tahun:</label>
            <select name="tahun" class="w-full p-2 border rounded-xl" required>
                <option value="">Pilih Tahun</option>
                @for ($year = date('Y'); $year >= 2020; $year--)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>

        {{-- Bulan --}}
        <div class="mb-4">
            <label class="block font-medium">Bulan:</label>
            <select name="bulan" class="w-full p-2 border rounded-xl" required>
                <option value="">Pilih Bulan</option>
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Minggu --}}
        <div class="mb-4">
            <label class="block font-medium">Minggu:</label>
            <select name="minggu" class="w-full p-2 border rounded-xl" required>
                <option value="">Pilih Minggu</option>
                <option value="1" {{ request('minggu') == 1 ? 'selected' : '' }}>Minggu 1 (1–7)</option>
                <option value="2" {{ request('minggu') == 2 ? 'selected' : '' }}>Minggu 2 (8–14)</option>
                <option value="3" {{ request('minggu') == 3 ? 'selected' : '' }}>Minggu 3 (15–21)</option>
                <option value="4" {{ request('minggu') == 4 ? 'selected' : '' }}>Minggu 4 (22–31)</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 rounded-xl text-white bg-[#083458] rounded hover:bg-blue-300 hover:text-black">
            Cari Data
        </button>
    </form>
    @if(session('success'))
        <div class="px-4 py-3 mt-4 mb-4 text-green-800 bg-green-100 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="px-4 py-3 mt-4 mb-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="px-4 py-3 mt-4 mb-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
            <ul class="space-y-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hasil Stok Awal --}}
    @if(isset($stokAwal))
        <div class="mt-8 text-center">
            <h3 class="mb-4 text-lg font-semibold">Data Stok Awal</h3>
            
            @if(count($stokAwal) > 0)
                <div class="flex justify-center">
                    <div class="w-full max-w-3xl overflow-auto">
                        <table class="w-full border border-collapse border-gray-300 shadow table-auto overflow-hidden rounded-2xl">
                            <thead class="bg-[#083458] text-white">
                                <tr>
                                    <th class="px-4 py-2 border rounded-tl-xl">Tanggal</th>
                                    <th class="px-4 py-2 border">Jumlah</th>
                                    <th class="px-4 py-2 border rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokAwal as $item)
                                    <tr class="text-center {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                        <td class="px-4 py-2 border">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-4 py-2 border">{{ $item->stok_awal }}</td>
                                        <td class="px-4 py-2 border">
                                            <button
                                                data-id="{{ $item->id_stok_opname }}"
                                                data-tanggal="{{ $item->tanggal }}"
                                                data-jumlah="{{ $item->stok_awal }}"
                                                class="open-modal-stok-awal text-[#083458] hover:text-blue-600 transition"
                                                title="Edit"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p class="mt-2 text-sm text-gray-500">Tidak ada data stok awal.</p>
            @endif
        </div>
    @endif

    {{-- Hasil Penyaluran --}}
    @if(isset($penyaluran))
        <div class="mt-8 text-center">
            <h3 class="mb-4 text-lg font-semibold">Data Penyaluran</h3>
            @if($penyaluran)
                <div class="flex justify-center">
                    <div class="w-full max-w-3xl overflow-auto">
                    <table class="w-full border border-collapse border-gray-300 shadow table-auto overflow-hidden rounded-2xl">
                        <thead class="bg-[#083458] text-white">
                            <tr>
                                <th class="px-4 py-2 border rounded-tl-xl">Tanggal</th>
                                <th class="px-4 py-2 border">Jumlah Penyaluran</th>
                                <th class="px-4 py-2 border rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="px-4 py-2 border rounded-bl-xl">
                                    {{ \Carbon\Carbon::parse($penyaluran->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-2 border">{{ $penyaluran->penyaluran }}</td>
                                <td class="px-4 py-2 border rounded-br-xl">
                                    <button
                                        data-id="{{ $penyaluran->id_stok_opname }}"
                                        data-tanggal="{{ $penyaluran->tanggal }}"
                                        data-jumlah="{{ $penyaluran->penyaluran }}"
                                        class="open-modal-penyaluran text-[#083458] hover:text-blue-600 transition"
                                        title="Edit"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            @else
                <p class="mt-2 text-sm text-gray-500">Tidak ada data penyaluran untuk minggu ini.</p>
            @endif
        </div>
    @endif

</div>

<!-- Modal Edit Stok Awal -->
<div id="modalStokAwal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-start justify-start pt-32">
    <div class="p-6 bg-white rounded shadow w-full max-w-md ml-24 mr-6 sm:ml-24 sm:mr-6 md:ml-auto md:mr-auto">
        <h2 class="mb-4 text-lg font-bold text-center">Edit Stok Awal</h2>
        <form id="formEditStokAwal" method="POST" action="{{ route('admin.updateStokAwal') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_stok_opname" id="edit-id">
            <div class="mb-4">
                <label class="block font-medium">Tanggal:</label>
                <input type="text" name="tanggal" id="edit-tanggal" class="w-full p-2 bg-gray-100 border rounded" readonly>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Jumlah:</label>
                <input type="number" name="stok_awal" id="edit-jumlah" class="w-full p-2 border rounded" required>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModalStok" class="px-4 py-2 mr-2 text-white bg-gray-400 rounded-2xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-[#083458] hover:text-black hover:bg-blue-300 rounded-2xl
                ">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Penyaluran -->
<div id="modalEditPenyaluran" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-start justify-start pt-32">
    <div class="p-6 bg-white rounded shadow w-full max-w-md ml-24 mr-6 sm:ml-24 sm:mr-6 md:ml-auto md:mr-auto">
        <h2 class="mb-4 text-lg font-bold text-center">Edit Data Penyaluran</h2>
        <form action="{{ route('admin.updatePenyaluran') }}" method="POST">
            @csrf
            <input type="hidden" name="id_stok_opname" id="penyaluran_id">
            
            <div class="mb-4">
                <label class="block font-medium">Tanggal:</label>
                <input type="text" id="penyaluran_tanggal" class="w-full p-2 bg-gray-100 border rounded" disabled>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Penyaluran:</label>
                <input type="number" name="penyaluran" id="penyaluran_jumlah" class="w-full p-2 border rounded" required>
            </div>

            <div class="flex justify-end">
                <button type="button" class="px-4 py-2 mr-2 text-white bg-gray-400 rounded-2xl close-modal">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-[#083458] hover:text-black hover:bg-blue-300 rounded-2xl">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>

    function formatTanggalIndo(tanggalString) {
        const bulanIndo = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        const tanggalObj = new Date(tanggalString);
        const tanggal = String(tanggalObj.getDate()).padStart(2, '0');
        const bulan = bulanIndo[tanggalObj.getMonth()];
        const tahun = tanggalObj.getFullYear();

        return `${tanggal} ${bulan} ${tahun}`;
    }

    document.querySelectorAll('.open-modal-stok-awal').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const tanggal = button.dataset.tanggal;
            const jumlah = button.dataset.jumlah;

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-tanggal').value = formatTanggalIndo(tanggal);
            document.getElementById('edit-jumlah').value = jumlah;

            document.getElementById('modalStokAwal').classList.remove('hidden');
        });
    });

    document.getElementById('closeModalStok').addEventListener('click', () => {
        document.getElementById('modalStokAwal').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalEditPenyaluran');
        const openButtons = document.querySelectorAll('.open-modal-penyaluran');
        const closeButtons = document.querySelectorAll('.close-modal');

        openButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('penyaluran_id').value = this.dataset.id;
                const tanggalRaw = this.dataset.tanggal;
                document.getElementById('penyaluran_tanggal').value = formatTanggalIndo(tanggalRaw);
                document.getElementById('penyaluran_jumlah').value = this.dataset.jumlah;
                modal.classList.remove('hidden');
            });
        });

        closeButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    });
</script>
@endsection
