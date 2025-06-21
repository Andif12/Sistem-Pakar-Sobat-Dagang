    @extends('layouts.admin')
    @section('title', 'Data IKM')

    @section('content')
        <main class="flex flex-col flex-1 min-h-screen bg-gray-100" x-data="ikmEdit()" x-init="init()">
            <header class="relative z-10">
                <div class="relative w-full h-44">
                    <img src="{{ asset('/assets/img/background/user_industri.png') }}" alt="Banner"
                        class="object-cover w-full h-44">
                    <a href="{{ route('dashboard.industri') }}"
                        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
                        <span class="text-2xl material-symbols-outlined">
                            arrow_back
                        </span>
                    </a>
                </div>

                <div
                    class="absolute bottom-0 z-20 flex flex-wrap items-stretch justify-between w-11/12 gap-4 px-4 py-4 transform -translate-x-1/2 translate-y-1/2 bg-white shadow-lg left-1/2 rounded-xl md:flex-nowrap">

                    {{-- Search Bar --}}
                    <div class="flex items-center bg-[#CAE2F6] rounded-lg px-4 py-2 w-full md:flex-1 min-w-0 shadow-md">
                        <i class="ml-2 text-gray-500 fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari"
                            class="w-full ml-2 text-sm bg-transparent focus:outline-none">
                    </div>

                    {{-- Filter Kecamatan --}}
                    <div class="relative w-full md:w-48">
                        <select id="filterKecamatan" onchange="filterTabel()"
                            class="appearance-none bg-[#CAE2F6] rounded-lg px-4 py-2 pr-8 w-full focus:outline-none shadow-md text-sm">
                            <option value="">Kecamatan</option>
                            <option value="Soreang">Soreang</option>
                            <option value="Ujung">Ujung</option>
                            <option value="Bacukiki">Bacukiki</option>
                            <option value="BacukikiBarat">Bacukiki Barat</option>
                        </select>
                        <i
                            class="absolute w-4 h-4 -translate-y-1/2 pointer-events-none fas fa-sliders-h right-3 top-1/2"></i>
                    </div>

                    {{-- Filter Investasi --}}
                    <div class="relative w-full md:w-48">
                        <select id="filterInvestasi" onchange="filterTabel()"
                            class="appearance-none bg-[#CAE2F6] rounded-lg px-4 py-2 pr-8 w-full focus:outline-none shadow-md text-sm">
                            <option value="">Investasi</option>
                            <option value="Kecil">Kecil</option>
                            <option value="Menengah">Menengah</option>
                        </select>
                        <i
                            class="absolute w-4 h-4 -translate-y-1/2 pointer-events-none fas fa-sliders-h right-3 top-1/2"></i>
                    </div>

                    {{-- Tambah Data --}}
                    <a href="{{ route('formIKM') }}"
                        class="bg-white text-[#003366] font-semibold rounded-lg px-4 py-2 shadow-md border border-[#003366]
           hover:bg-[#CAE2F6] hover:text-[#003366] hover:border-[#003366] transition duration-300">
                        TAMBAH DATA
                    </a>
                    


                    <form method="GET" action="{{ route('exportIKM') }}" id="exportForm">
                        <input type="hidden" name="kecamatan" id="inputKecamatan">
                        <input type="hidden" name="search" id="inputSearch">
                        <div id="inputJenisContainer"></div>
                        <input type="hidden" name="investasi[]" id="inputInvestasi">
                        <button type="submit"
                            class="bg-[#003366] text-white font-semibold rounded-lg px-4 py-2 shadow-md hover:bg-[#CAE2F6] hover:text-[#003366] border border-transparent hover:border-[#003366] transition duration-300">
                            UNDUH DATA
                        </button>
                    </form>
                </div>
            </header>
            <section class="flex flex-wrap justify-center gap-4 px-4 mt-[200px] md:mt-20">
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
                    unset($kategori);

                @endphp

                @foreach ($kategoriList as $kategori)
                    <div onclick="selectKategori(this)"
                        class="flex flex-col items-center p-3 text-center transition transform bg-white border-2 border-transparent shadow-lg cursor-pointer kategori-card rounded-xl w-44 hover:scale-105">
                        <img src="{{ asset('assets/img/kategori/' . $kategori['ikon']) }}"
                            alt="{{ $kategori['nama'] }} Icon" class="object-contain w-10 h-10">
                        <span
                            class="font-semibold mt-1 text-[#083458] leading-tight min-h-[2rem] flex items-center justify-center text-center">
                            {{ $kategori['nama'] }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $kategori['jumlah'] }}</span>
                    </div>
                @endforeach
            </section>
            <section class="mt-12 px-6 pb-16">
                <div class="overflow-x-auto rounded-lg">
                    <div class="max-h-[580px] overflow-y-auto">
                        <table class="w-full border-collapse text-sm bg-white shadow-md">
                            <thead class="sticky top-0 z-10 text-white bg-[#083458]">
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
                                    <th class="p-3">TENAGA KERJA</th>
                                    <th class="p-3">INVESTASI</th>
                                    <th class="p-3 rounded-tr-xl">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataIkm as $index => $ikm)
                                    <tr class="bg-white border-b row-ikm" data-kecamatan="{{ $ikm->kecamatan }}"
                                        data-industri="{{ $ikm->jenis_industri }}"
                                        data-investasi-nilai="{{ $ikm->level }}">
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
                                        <td class="p-2 text-center">{{ $ikm->tenaga_kerja }}</td>
                                        <td class="p-3">{{ 'Rp ' . number_format($ikm->level, 0, ',', '.') }}</td>
                                        <td class="p-2 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('detailIKM', $ikm->id_ikm) }}"
                                                    class="flex items-center gap-1 text-blue-700 bg-blue-100 hover:bg-blue-200 text-xs px-3 py-1 rounded-lg border border-blue-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                <form action="{{ route('destroyIKM', $ikm->id_ikm) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded-lg">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    @endsection

    @push('scripts')
        <script>
            let kategoriDipilih = [];


            function selectKategori(el) {
                const selectedText = el.querySelector('.font-semibold').textContent.trim();

                const index = kategoriDipilih.indexOf(selectedText);
                if (index > -1) {
                    // Sudah dipilih → hapus dari array
                    kategoriDipilih.splice(index, 1);
                    el.classList.remove('bg-blue-100', 'border-blue-900', 'border-2');
                    el.classList.add('bg-white', 'border-transparent');
                } else {
                    // Belum dipilih → tambahkan ke array
                    kategoriDipilih.push(selectedText);
                    el.classList.remove('bg-white', 'border-transparent');
                    el.classList.add('bg-blue-100', 'border-blue-900', 'border-2');
                }

                filterTabel();
            }

            function filterTabel() {
                const selectedKecamatan = document.getElementById('filterKecamatan').value.trim().toLowerCase();
                const searchKeyword = document.getElementById('searchInput').value.trim().toLowerCase();
                const selectedInvestasi = document.getElementById('filterInvestasi').value.trim().toLowerCase();
                const rows = document.querySelectorAll('.row-ikm');

                let anyVisible = false;

                rows.forEach(row => {
                    const rowKecamatan = row.getAttribute('data-kecamatan')?.trim().toLowerCase() || '';
                    const rowIndustri = row.getAttribute('data-industri')?.trim().toLowerCase() || '';

                    const investasiNilaiStr = row.getAttribute('data-investasi-nilai') || '0';

                    // Bersihkan string supaya hanya angka
                    const angkaBersih = investasiNilaiStr.replace(/[^0-9]/g, '');
                    const investasiNilai = parseFloat(angkaBersih) || 0;

                    let kategoriInvestasi = '';
                    if (investasiNilai < 100000000) {
                        kategoriInvestasi = 'kecil';
                    } else if (investasiNilai >= 100000000 && investasiNilai < 1000000000) {
                        kategoriInvestasi = 'menengah';
                    } else {
                        kategoriInvestasi = 'besar';
                    }
                    const rowText = row.textContent.toLowerCase();

                    const cocokKecamatan = !selectedKecamatan || rowKecamatan === selectedKecamatan;
                    const cocokIndustri = kategoriDipilih.length === 0 || kategoriDipilih.map(k => k.toLowerCase())
                        .includes(rowIndustri);
                    const cocokInvestasi = !selectedInvestasi || kategoriInvestasi === selectedInvestasi;
                    const cocokCari = !searchKeyword || rowText.includes(searchKeyword);

                    const show = cocokKecamatan && cocokIndustri && cocokInvestasi && cocokCari;
                    row.style.display = show ? '' : 'none';

                    if (show) anyVisible = true;
                });

                const noResultsEl = document.getElementById('noResults');
                if (noResultsEl) {
                    noResultsEl.style.display = anyVisible ? 'none' : 'block';
                }
            }

            function syncExportFilter() {
                document.getElementById('inputKecamatan').value = document.getElementById('filterKecamatan').value;
                document.getElementById('inputSearch').value = document.getElementById('searchInput').value;

                const container = document.getElementById('inputJenisContainer');
                container.innerHTML = '';

                kategoriDipilih.forEach(jenis => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'jenis[]';
                    input.value = jenis;
                    container.appendChild(input);
                });

                const filterInvestasiSelect = document.getElementById('filterInvestasi');
                const investasiDipilih = [];

                if (filterInvestasiSelect && filterInvestasiSelect.value.trim() !== '') {
                    investasiDipilih.push(filterInvestasiSelect.value.trim().toLowerCase());
                }

                const oldInvestasiInputs = document.querySelectorAll('input[name="investasi[]"]');
                oldInvestasiInputs.forEach(el => el.remove());

                investasiDipilih.forEach(inv => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'investasi[]';
                    input.value = inv;
                    container.appendChild(input);
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                filterTabel();

                document.getElementById('filterKecamatan').addEventListener('change', filterTabel);
                document.getElementById('filterInvestasi').addEventListener('change', filterTabel);
                document.getElementById('searchInput').addEventListener('input', filterTabel);

                const exportForm = document.querySelector('form[action$="export"]');
                if (exportForm) {
                    exportForm.addEventListener('submit', syncExportFilter);
                }
            });
        </script>

        <script>
            function ikmEdit() {
                return {
                    openModal: false,
                    formData: {},
                    fieldMap: {
                        nama_ikm: 'Nama Usaha',
                        luas: 'Luas Usaha',
                        nama_pemilik: 'Nama Pemilik',
                        jenis_kelamin: 'Jenis Kelamin',
                        kecamatan: 'Kecamatan',
                        kelurahan: 'Kelurahan',
                        komoditi: 'Komoditi',
                        jenis_industri: 'Jenis Industri',
                        alamat: 'Alamat',
                        nib: 'NIB',
                        no_telp: 'Nomor Telepon',
                        tenaga_kerja: 'Jumlah Tenaga Kerja',
                    },
                    openEdit(data) {
                        this.formData = {
                            ...data
                        };
                        this.openModal = true;
                    },
                    init() {}
                }
            }
        </script>
    @endpush
