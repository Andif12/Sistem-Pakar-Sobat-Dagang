@extends('layouts.admin')
@section('title', 'Data IKM')

@section('content')
<div class="relative">
    <img src="{{ asset('/assets/img/background/user_industri.png') }}" class="w-full h-44 object-cover"
        alt="Header">

    <div class="flex-1 flex flex-col w-full">
        <div class="w-11/12 bg-white rounded-xl shadow-lg px-6 py-4 flex flex-wrap justify-between gap-4 items-center mx-auto -mt-10 z-20">
            <div class="flex items-center bg-[#CAE2F6] rounded-lg px-4 py-2 flex-1 shadow-md">
                <span class="material-symbols-outlined text-gray-500 mr-2">search</span>
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></span>
                <input type="text" id="searchInput" placeholder="Cari"
                    class="bg-transparent w-full focus:outline-none">
            </div>
            <div class="relative w-48">
                <select id="filterKecamatan" onchange="filterTabel()"
                    class="appearance-none bg-[#CAE2F6] rounded-lg px-4 py-2 pr-8 w-full focus:outline-none shadow-md">
                    <option value="">Kecamatan</option>
                    <option value="Soreang">Soreang</option>
                    <option value="Ujung">Ujung</option>
                    <option value="Bacukiki">Bacukiki</option>
                    <option value="Bacukiki">Bacukiki Barat</option>
                </select>
                <i class="fas fa-sliders-h absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none w-4 h-4">
                </i>
            </div>

            <div class="relative w-48">
                <select id="filterInvestasi" onchange="filterTabel()"
                    class="appearance-none bg-[#CAE2F6] rounded-lg px-4 py-2 pr-8 w-full focus:outline-none shadow-md">
                    <span class="material-symbols-outlined text-sm text-gray-700">tune</span>
                    <option value="">Investasi</option>
                    <option value="Kecil">Kecil</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Besar">Besar</option>
                </select>
                <i class="fas fa-sliders-h absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none w-4 h-4">
                </i>
            </div>
        </div>
    </div>
            

    <section class="mt-6 px-4 flex flex-wrap justify-center gap-4">
        @php
            $kategoriList = [
                ['nama' => 'Sandang', 'ikon' => 'sandang.png'],
                ['nama' => 'Pangan', 'ikon' => 'pangan.png'],
                ['nama' => 'Kimia & Bahan Bangunan', 'ikon' => 'kimia.png'],
                ['nama' => 'Logam & Elektronika', 'ikon' => 'logam.png'],
                ['nama' => 'Kerajinan', 'ikon' => 'kerajinan.png'],
            ];

            foreach ($kategoriList as &$kategori) {
                $kategori['jumlah'] = \App\Models\DataIKM::where('jenis_industri', $kategori['nama'])->count();
            }
            unset($kategori); // hindari reference carryover

        @endphp

        @foreach ($kategoriList as $kategori)
            <div onclick="selectKategori(this)"
                class="kategori-card cursor-pointer flex flex-col items-center bg-white p-3 rounded-xl shadow-lg w-44 border-2 border-transparent transition transform hover:scale-105 text-center">
                <img src="{{ asset('assets/img/kategori/' . $kategori['ikon']) }}" alt="{{ $kategori['nama'] }} Icon"
                    class="w-10 h-10 object-contain">
                <span
                    class="font-semibold mt-1 text-[#083458] leading-tight min-h-[2rem] flex items-center justify-center text-center">
                    {{ $kategori['nama'] }}
                </span>
                <span class="text-sm text-gray-500">{{ $kategori['jumlah'] }}</span>
            </div>
        @endforeach
    </section>

    <section class="overflow-hidden mt-6 px-6 pb-16">
        <div class="overflow-x-auto overflow-y-auto max-h-[350px] rounded-lg">
            <table class="w-full border-collapse table-auto text-sm bg-white shadow-md">
                <thead class="text-white bg-[#083458] sticky top-0 z-10">
                    <tr>
                        <th class="p-3 rounded-tl-xl">NO.</th>
                        <th class="p-3">NAMA USAHA</th>
                        <th class="p-3">NAMA PEMILIK</th>
                        <th class="p-3">JENIS KELAMIN</th>
                        <th class="p-3">LUAS USAHA</th>
                        <th class="p-3">ALAMAT</th>
                        <th class="p-3">KELURAHAN</th>
                        <th class="p-3">KECAMATAN</th>
                        <th class="p-3">KOMODITI</th>
                        <th class="p-3">JENIS INDUSTRI</th>
                        <th class="p-3">TELEPON</th>
                        <th class="p-3 rounded-tr-xl">INVESTASI</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($dataIkm as $index => $ikm)
                        <tr class="bg-white border-b row-ikm" data-kecamatan="{{ $ikm->kecamatan }}"
                            data-industri="{{ $ikm->jenis_industri }}">
                            <td class="p-2 text-center">{{ $index + 1 }}</td>
                            <td class="p-2">{{ $ikm->nama_ikm }}</td>
                            <td class="p-2">{{ $ikm->nama_pemilik }}</td>
                            <td class="p-2 text-center">{{ $ikm->jenis_kelamin }}</td>
                            <td class="p-2">{{ $ikm->luas }}</td>
                            <td class="p-2">{{ $ikm->alamat }}</td>
                            <td class="p-2">{{ $ikm->kelurahan }}</td>
                            <td class="p-2">{{ $ikm->kecamatan }}</td>
                            <td class="p-2">{{ $ikm->komoditi }}</td>
                            <td class="p-2">{{ $ikm->jenis_industri }}</td>
                            <td class="p-2">{{ $ikm->no_telp }}</td>
                            <td class="p-3">{{ 'Rp ' . number_format($ikm->level, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p id="noResults" class="text-center mt-4 font-medium text-red-500 hidden">Data tidak ditemukan.</p>
        </div>
    </section>
</div>

    <script>
        let kategoriDipilih = '';

        function selectKategori(el) {
            const allCards = document.querySelectorAll('.kategori-card');
            allCards.forEach(card => {
                card.classList.remove('bg-[#CAE2F6]', 'border-[#003366]', 'border-2');
            });

            el.classList.add('bg-[#CAE2F6]', 'border-[#003366]', 'border-2');
            kategoriDipilih = el.querySelector('.font-semibold').textContent.trim();
            filterTabel();
        }

        function filterTabel() {
            const selectedKecamatan = document.getElementById('filterKecamatan').value.trim().toLowerCase();
            const searchKeyword = document.getElementById('searchInput').value.trim().toLowerCase();
            const rows = document.querySelectorAll('.row-ikm');

            let anyVisible = false;

            rows.forEach(row => {
                const rowKecamatan = row.getAttribute('data-kecamatan')?.trim().toLowerCase() || '';
                const rowIndustri = row.getAttribute('data-industri')?.trim().toLowerCase() || '';
                const rowText = row.textContent.toLowerCase();

                const cocokKecamatan = !selectedKecamatan || rowKecamatan === selectedKecamatan;
                const cocokIndustri = !kategoriDipilih || rowIndustri === kategoriDipilih.toLowerCase();
                const cocokCari = !searchKeyword || rowText.includes(searchKeyword);

                const show = cocokKecamatan && cocokIndustri && cocokCari;
                row.style.display = show ? '' : 'none';

                if (show) anyVisible = true;
            });

            const noResultsEl = document.getElementById('noResults');
            if (noResultsEl) {
                noResultsEl.style.display = anyVisible ? 'none' : 'block';
            }
        }


        document.addEventListener('DOMContentLoaded', () => {
            filterTabel();
            document.getElementById('filterKecamatan').addEventListener('change', filterTabel);
            document.getElementById('filterInvestasi').addEventListener('change', filterTabel);
            document.getElementById('searchInput').addEventListener('input', filterTabel);

        });
    </script>
@endsection
