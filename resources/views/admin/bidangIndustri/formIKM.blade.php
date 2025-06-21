@extends('layouts.admin')
@section('title', 'Form Data IKM')

@section('content')
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <main class="flex-1 flex flex-col bg-gray-100 min-h-screen overflow-y-auto" x-data>
            <!-- ALERT AREA -->
            <div x-show="false" x-transition
                class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-red-100 text-red-800 p-4 rounded-lg shadow-lg z-50 w-fit max-w-md text-center"
                style="display: none;">
                <p class="font-semibold"></p>

            </div>

            <div class="relative w-full h-44">
                <img src="{{ asset('/assets/img/background/user_industri.png') }}" alt="Banner"
                    class="object-cover w-full h-44">
                <a href="{{ route('dataIKM') }}"
                    class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
                    <span class="text-2xl material-symbols-outlined">
                        arrow_back
                    </span>
                </a>
            </div>

            <section class="bg-[#f0f4f9] flex justify-center items-start">
                <div class="w-full max-w-[1200px] m-4 px-6 bg-white rounded-2xl shadow-md">

                    @php
                        $tabs = [
                            ['id' => 'btn-data-ikm', 'label' => 'DATA IKM'],
                            ['id' => 'btn-persentase-pemilik', 'label' => 'PERSENTASE PEMILIK'],
                            ['id' => 'btn-karyawan', 'label' => 'TENAGA KERJA'],
                            ['id' => 'btn-pemakaian-bahan', 'label' => 'PEMAKAIAN BAHAN'],
                            ['id' => 'btn-penggunaan-air', 'label' => 'PENGGUNAAN AIR'],
                            ['id' => 'btn-pengeluaran', 'label' => 'PENGELUARAN'],
                            ['id' => 'btn-bahan-bakar', 'label' => 'BAHAN BAKAR'],
                            ['id' => 'btn-listrik', 'label' => 'LISTRIK'],
                            ['id' => 'btn-mesin-produksi', 'label' => 'MESIN PRODUKSI'],
                            ['id' => 'btn-produksi', 'label' => 'PRODUKSI'],
                            ['id' => 'btn-persediaan', 'label' => 'PERSEDIAAN'],
                            ['id' => 'btn-pendapatan', 'label' => 'PENDAPATAN'],
                            ['id' => 'btn-modal', 'label' => 'MODAL'],
                            ['id' => 'btn-bentuk-pengelolaan', 'label' => 'BENTUK PENGELOLAAN'],
                        ];
                        $activeTab = 'btn-data-ikm';
                    @endphp

                    <div class="flex flex-wrap justify-center gap-2 border-b border-blue-300 bg-[#f9fbfe] px-4 pt-4">
                        @foreach ($tabs as $tab)
                            @php
                                $isActive = $tab['id'] === $activeTab;
                            @endphp
                            <button id="{{ $tab['id'] }}"
                                class="tab-button relative px-4 py-2 text-sm font-medium rounded-t-xl transition duration-200 border
        {{ $isActive
            ? 'bg-white text-[#083458] font-bold border-b-4 border-[#083458] cursor-default'
            : 'bg-[#083458] text-white hover:bg-blue-200 hover:text-[#083458] hover:border-[#083458]' }}">
                                {{ $tab['label'] }}
                            </button>
                        @endforeach
                    </div>


                    <div class="p-10 w-3/4 mx-auto flex justify-center">
                        <section id="tab-content"
                            class="inline-block bg-[#d0e6ff] rounded-2xl p-10 min-h-[200px] text-center text-blue-900 text-xl font-normal shadow-inner">
                            @if ($errors->has('konsistensi'))
                                <div id="backend-error-konsistensi"
                                    data-error-konsistensi="{{ $errors->first('konsistensi') }}"></div>
                            @endif

                            <form id="form-ikm" method="POST" action="{{ route('dataIKM.store') }}">
                                @csrf
                                {{-- DATA IKM --}}

                                <section id="form-data-ikm"
                                    class="hidden relative z-0 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                                    <div>
                                        <label class="block mb-1 font-medium">Nama Usaha</label>
                                        <input name="nama_ikm" type="text" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Nama Usaha">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Luas Usaha</label>
                                        <input name="luas" type="text" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Luas Usaha">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Nama Pemilik</label>
                                        <input name="nama_pemilik" type="text" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Nama Pemilik">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Jenis Kelamin Pemilik Usaha</label>
                                        <select name="jenis_kelamin" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option disabled selected value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Kelurahan</label>
                                        <select id="kelurahan" name="kelurahan" required disabled
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>Pilih Kelurahan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Komoditi</label>
                                        <select name="komoditi" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option disabled selected value="">Pilih Komoditi</option>
                                            <option value="Komoditi 1">Komoditi 1</option>
                                            <option value="Komoditi 2">Komoditi 2</option>
                                            <option value="Komoditi 3">Komoditi 3</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Jenis Industri</label>
                                        <select name="jenis_industri" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option disabled selected value="">Pilih Jenis Industri</option>
                                            <option value="Sandang">Sandang</option>
                                            <option value="Pangan">Pangan</option>
                                            <option value="Kimia & Bahan Bangunan">Kimia & Bahan Bangunan</option>
                                            <option value="Logam & Elektronika">Logam & Elektronika</option>
                                            <option value="Kerajinan">Kerajinan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Alamat</label>
                                        <input name="alamat" type="text" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Alamat">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">NIB (Nomor Induk Berusaha)</label>
                                        <input name="nib" type="text" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan NIB (Nomor Induk Berusaha)">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Nomor HP/Telepon</label>
                                        <input name="no_telp" type="tel" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Nomor Hp/Telepon">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Jumlah Tenaga Kerja</label>
                                        <input name="tenaga_kerja" type="number" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Jumlah Tenaga Kerja">
                                    </div>

                                    <div class="col-span-1 md:col-span-2 flex justify-center gap-4 mt-6">
                                        <button type="button" id="next-data-ikm"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                <script>
                                    const dataWilayah = @json($wilayah['kabupaten'] ?? []);
                                    const parepareKabupaten = dataWilayah.find(kab => kab.name === "Kota Parepare");

                                    const kecamatanSelect = document.getElementById('kecamatan');
                                    const kelurahanSelect = document.getElementById('kelurahan');

                                    if (parepareKabupaten) {
                                        parepareKabupaten.kecamatan.forEach(kec => {
                                            const opt = document.createElement('option');
                                            opt.value = kec.name;
                                            opt.textContent = kec.name;
                                            kecamatanSelect.appendChild(opt);
                                        });
                                    }

                                    kecamatanSelect.addEventListener('change', function() {
                                        const selectedKec = parepareKabupaten.kecamatan.find(kec => kec.name === this.value);

                                        kelurahanSelect.innerHTML = '<option value="" disabled selected>Pilih Kelurahan</option>';

                                        if (selectedKec) {
                                            selectedKec.kelurahan.forEach(kel => {
                                                const opt = document.createElement('option');
                                                opt.value = kel;
                                                opt.textContent = kel;
                                                kelurahanSelect.appendChild(opt);
                                            });
                                            kelurahanSelect.disabled = false;
                                        } else {
                                            kelurahanSelect.disabled = true;
                                        }
                                    });
                                </script>

                                {{-- PERSENTASE PEMILIK --}}
                                <section id="form-persentase-pemilik"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pemerintah Pusat (%)</label>
                                        <input name="pemerintah_pusat" type="number" min="0" max="100"
                                            step="0.01" placeholder="Masukan Angka (contoh: 20)" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pemerintah Daerah (%)</label>
                                        <input name="pemerintah_daerah" type="number" min="0" max="100"
                                            step="0.01" placeholder="Masukan Angka (contoh: 20)" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Swasta Nasional (%)</label>
                                        <input name="swasta_nasional" type="number" min="0" max="100"
                                            step="0.01" placeholder="Masukan Angka (contoh: 20)" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Asing (%)</label>
                                        <input name="asing" type="number" min="0" max="100"
                                            step="0.01" placeholder="Masukan Angka (contoh: 20)" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>
                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-persentase-pemilik"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>


                                {{-- KARYAWAN --}}
                                <section id="form-karyawan" class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="flex flex-col gap-6">
                                        <div class="flex flex-col">
                                            <label class="mb-2 font-medium text-gray-700">Status Tenaga Kerja</label>
                                            <div class="flex gap-4">
                                                <label class="mb-2 font-normal flex flex-col flex-1">
                                                    Tetap
                                                    <input name="tenaga_kerja_tetap" type="number" min="0"
                                                        max="100" step="1"
                                                        placeholder="Jumlah Tenaga Kerja Tetap" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2 mt-1">
                                                </label>
                                                <label class="mb-2 font-normal flex flex-col flex-1">
                                                    Tidak Tetap
                                                    <input name="tenaga_kerja_tidak_tetap" type="number" min="0"
                                                        max="100" step="1"
                                                        placeholder="Jumlah Tenaga Kerja Tidak Tetap" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2 mt-1">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="mb-2 font-medium text-gray-700">Jenis Kelamin Tenaga
                                                Kerja</label>
                                            <div class="flex gap-4">
                                                <label class="mb-2 font-normal flex flex-col flex-1">
                                                    Laki-laki
                                                    <input name="tenaga_kerja_laki_laki" type="number" min="0"
                                                        max="100" step="1"
                                                        placeholder="Jumlah Tenaga Kerja Laki-laki" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2 mt-1">
                                                </label>
                                                <label class="mb-2 font-normal flex flex-col flex-1">
                                                    Perempuan
                                                    <input name="tenaga_kerja_perempuan" type="number" min="0"
                                                        max="100" step="1"
                                                        placeholder="Jumlah Tenaga Kerja Perempuan" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2 mt-1">
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="flex flex-col">
                                        <label class="mb-2 font-medium text-gray-700">Tingkat Pendidikan Tenaga
                                            kerja</label>

                                        <div class="flex flex-wrap gap-4">
                                            <div class="flex flex-col w-full md:w-[130px]">
                                                <label class="block mb-1 text-sm">SD</label>
                                                <input name="sd" type="number" min="0" placeholder="SD"
                                                    required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="flex flex-col w-full md:w-[130px]">
                                                <label class="block mb-1 text-sm">SMP</label>
                                                <input name="smp" type="number" min="0" placeholder="SMP"
                                                    required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="flex flex-col w-full md:w-[130px]">
                                                <label class="block mb-1 text-sm">SMA/SMK</label>
                                                <input name="sma_smk" type="number" min="0"
                                                    placeholder="SMA/SMK" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="flex flex-col w-full md:w-[130px]">
                                                <label class="block mb-1 text-sm">D1 sd. D3</label>
                                                <input name="d1_d3" type="number" min="0"
                                                    placeholder="D1 sd. D3" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>

                                        <div class="flex justify-center flex-wrap gap-4 mt-2">
                                            <div class="flex flex-col w-[130px]">
                                                <label class="block mb-1 text-sm">S1/D4</label>
                                                <input name="s1_d4" type="number" min="0" placeholder="S1/D4"
                                                    required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="flex flex-col w-[130px]">
                                                <label class="block mb-1 text-sm">S2</label>
                                                <input name="s2" type="number" min="0" placeholder="S2"
                                                    required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="flex flex-col w-[130px]">
                                                <label class="block mb-1 text-sm">S3</label>
                                                <input name="s3" type="number" min="0" placeholder="S3"
                                                    required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-karyawan"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>


                                {{-- PEMAKAIAN BAHAN --}}
                                <section id="form-pemakaian-bahan"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="mb-4 flex justify-end">
                                        <button type="button" onclick="tambahFormBahan()"
                                            class="bg-[#083458] text-white px-4 py-2 rounded-2xl hover:opacity-90">
                                            + Tambah Data
                                        </button>
                                    </div>

                                    <div id="form-bahan-container" class="flex flex-col gap-4">
                                        <div class="bahan-item border p-4 rounded-xl shadow" id="bahan-template">
                                            <div class="flex flex-col font-semibold text-gray-700 mb-2">Bahan 1</div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Nama Bahan</label>
                                                <input type="text" name="nama_bahan[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full"
                                                    placeholder="Masukkan Nama Bahan">
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Jenis Bahan</label>
                                                <select name="jenis_bahan[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full">
                                                    <option value="" disabled selected>-- Pilih Jenis Bahan --
                                                    </option>
                                                    <option value="Bahan Baku">Bahan Baku</option>
                                                    <option value="Bahan Penolong">Bahan Penolong</option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Spesifikasi</label>
                                                <input type="text" name="spesifikasi[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full"
                                                    placeholder="Masukkan Spesifikasi Bahan">
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Kode HS</label>
                                                <input type="text" name="kode_hs[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full"
                                                    placeholder="Masukkan Kode HS Bahan">
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Satuan Standar</label>
                                                <select name="satuan_standar_bahan[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                    <option value="" disabled selected>Pilih Satuan</option>
                                                    <option value="kg">Kilogram (kg)</option>
                                                    <option value="ton">Ton (t)</option>
                                                    <option value="liter">Liter (L)</option>
                                                    <option value="ml">Milliliter (mL)</option>
                                                    <option value="m">Meter (m)</option>
                                                    <option value="m2">Meter Persegi (m²)</option>
                                                    <option value="m3">Meter Kubik (m³)</option>
                                                    <option value="pcs">Unit / Pcs</option>
                                                    <option value="drum">Drum</option>
                                                    <option value="nm3">Normal Meter Kubik (Nm³)</option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Bahan Dalam Negeri</label>
                                                <div class="flex flex-col md:flex-row gap-2">
                                                    <div class="w-full md:w-1/2">
                                                        <label class="block mb-1 text-sm">Jumlah (Unit)</label>
                                                        <input type="number" name="jumlah_dalam_negeri[]" min="0"
                                                            required
                                                            class="border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Jumlah (Unit)">
                                                    </div>
                                                    <div class="w-full md:w-1/2">
                                                        <label class="block mb-1 text-sm">Nilai (Rp)</label>
                                                        <input type="number" name="nilai_dalam_negeri[]" min="0"
                                                            required
                                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Nilai (Rp)">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Bahan Impor</label>
                                                <div class="flex flex-col md:flex-row gap-2">
                                                    <div class="w-full md:w-1/3">
                                                        <label class="block text-sm mb-1">Jumlah (Unit)</label>
                                                        <input type="number" name="jumlah_impor[]" min="0"
                                                            required
                                                            class="border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Jumlah (Unit)">
                                                    </div>
                                                    <div class="w-full md:w-1/3">
                                                        <label class="block text-sm mb-1">Nilai (Rp)</label>
                                                        <input type="number" name="nilai_impor[]" min="0"
                                                            required
                                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Nilai (Rp)">
                                                    </div>
                                                    <div class="w-full md:w-1/3">
                                                        <label class="block text-sm mb-1">Negara Asal</label>
                                                        <input type="text" name="negara_asal_impor[]" required
                                                            class="border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Negara Asal">
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button"
                                                class="hapus-item mt-4 mx-auto flex items-center gap-1 text-red-600 hover:text-red-800 font-medium text-sm hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-pemakaian-bahan"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- PENGGUNAAN AIR --}}
                                <section id="form-penggunaan-air"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="flex flex-col">
                                        <label for="sumber_air" class="mb-2 font-medium text-gray-700">Sumber
                                            Air</label>
                                        <select id="sumber_air" name="sumber_air" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>-- Pilih Sumber Air --</option>
                                            <option value="air_permukaan">Air Permukaan (sungai, danau, mata air, laut)
                                            </option>
                                            <option value="air_tanah">Air Tanah</option>
                                            <option value="perusahaan_penyedia_air">Perusahaan Penyedia Air</option>
                                            <option value="air_daur_ulang">Air Daur Ulang dari Proses di Industri
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="banyaknya_penggunaan_m3"
                                            class="mb-2 font-medium text-gray-700">Banyaknya Penggunaan (m³)</label>
                                        <input type="number" id="banyaknya_penggunaan_m3" name="banyaknya_penggunaan_m3"
                                            min="0.01" step="0.01" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Jumlah Penggunaan">
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="biaya" class="mb-2 font-medium text-gray-700">Biaya
                                            (Rp)</label>
                                        <input type="number" id="biaya" name="biaya" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Biaya (contoh: 200000)">
                                    </div>

                                    {{-- Tombol Navigasi --}}
                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-penggunaan-air"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- PENGELUARAN --}}
                                <section id="form-pengeluaran" class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Upah Gaji Pekerja Produksi (Rp)</label>
                                        <input name="upah_gaji" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 60000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran untuk Industri atau
                                            Distribusi
                                            (Rp)</label>
                                        <input name="pengeluaran_industri_distribusi" type="number" min="0"
                                            required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 100000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran untuk Kegiatan Research dan
                                            Development (Rp)</label>
                                        <input name="pengeluaran_rnd" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 75000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran Tanah (Rp)</label>
                                        <input name="pengeluaran_tanah" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 120000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran Gedung (Rp)</label>
                                        <input name="pengeluaran_gedung" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 250000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran Mesin dan Peralatan
                                            (Rp)</label>
                                        <input name="pengeluaran_mesin" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 300000)">
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block mb-1 font-medium">Pengeluaran Lainnya (Rp)</label>
                                        <input name="lainnya" type="number" min="0" required
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukan Angka (contoh: 60000)">
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-pengeluaran"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- BAHAN BAKAR --}}
                                <section id="form-bahan-bakar" class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="mb-4 flex justify-end">
                                        <button type="button" onclick="tambahBahanBakar()"
                                            class="bg-[#083458] text-white px-4 py-2 rounded-2xl hover:opacity-90">
                                            + Tambah Data
                                        </button>
                                    </div>

                                    <div id="bahan-bakar-container" class="flex flex-col gap-4">
                                        <div class="bahan-bakar-item border p-4 rounded-xl shadow"
                                            id="bahan-bakar-template">
                                            <div class="flex flex-col font-semibold text-gray-700 mb-2">
                                                <span class="judul-bahan-bakar">Bahan Bakar 1</span>
                                            </div>

                                            <div class="flex flex-col mb-4">
                                                <label for="jenis_bahan_bakar" class="block mb-1 font-medium">Jenis
                                                    Bahan
                                                    Bakar</label>
                                                <select name="jenis_bahan_bakar[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                    <option value="" disabled selected>-- Pilih Jenis Bahan Bakar
                                                        --
                                                    </option>
                                                    <option value="bensin">Bensin</option>
                                                    <option value="solar_hsd_ado">Solar / HSD / ADO</option>
                                                    <option value="batubara">Batubara</option>
                                                    <option value="briket_batubara">Briket Batubara</option>
                                                    <option value="gas_dari_pgn">Gas dari PGN</option>
                                                    <option value="gas_bukan_dari_pgn">Gas bukan dari PGN</option>
                                                    <option value="cng">CNG</option>
                                                    <option value="lpg">LPG</option>
                                                    <option value="pelumas">Pelumas</option>
                                                </select>
                                            </div>

                                            <div class="flex flex-col mb-4">
                                                <label class="block mb-1 font-medium">Satuan Standar</label>
                                                <select name="satuan_standar[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                    <option value="" disabled selected>-- Pilih Satuan Standar --
                                                    </option>
                                                    <option value="liter">Liter</option>
                                                    <option value="ton">Ton</option>
                                                    <option value="mmbtu">MMBTU</option>
                                                    <option value="kg">Kg</option>
                                                </select>
                                            </div>


                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Proses Produksi</label>
                                                <div class="flex flex-col md:flex-row gap-2">
                                                    <div class="w-full md:w-1/2">
                                                        <label for="banyaknya_proses_produksi"
                                                            class="block text-sm mb-1">Banyaknya Proses
                                                            Produksi</label>
                                                        <input type="number" name="banyaknya_proses_produksi[]"
                                                            min="0" required
                                                            class="border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Contoh: 30">
                                                    </div>
                                                    <div class="w-full md:w-1/2">
                                                        <label for="nilai_proses_produksi"
                                                            class="block text-sm mb-1">Nilai Proses Produksi
                                                            (Rp)</label>
                                                        <input type="number" name="nilai_proses_produksi[]"
                                                            min="0" required
                                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Contoh: 30000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="block mb-1 font-medium">Pembangkit Tenaga Listrik</label>
                                                <div class="flex flex-col md:flex-row gap-2">
                                                    <div class="w-full md:w-1/2">
                                                        <label for="banyaknya_ptl" class="block text-sm mb-1">Banyaknya
                                                            Pembangkit</label>
                                                        <input type="number" name="banyaknya_ptl[]" min="0"
                                                            required
                                                            class="border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Contoh: 30">
                                                    </div>
                                                    <div class="w-full md:w-1/2">
                                                        <label for="nilai_ptl" class="block text-sm mb-1">Nilai
                                                            Pembangkit
                                                            (Rp)</label>
                                                        <input type="number" name="nilai_ptl[]" min="0" required
                                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full"
                                                            placeholder="Contoh: 30000">
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button"
                                                class="hapus-item mt-4 mx-auto flex items-center gap-1 text-red-600 hover:text-red-800 font-medium text-sm hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-bahan-bakar"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- LISTRIK --}}
                                <section id="form-listrik" class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div>
                                        <label for="sumber_listrik" class="block mb-1 font-medium">Sumber
                                            Listrik</label>
                                        <select id="sumber_listrik" name="sumber_listrik" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>-- Pilih Sumber Listrik --
                                            </option>
                                            <option value="pln">PLN</option>
                                            <option value="non_pln">Non-PLN</option>
                                            <option value="pembangkit_sendiri">Pembangkit Sendiri</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Banyaknya Penggunaan (kWh)</label>
                                        <input type="number" name="banyaknya_penggunaan_listrik" min="0" required
                                            placeholder="Masukkan penggunaan listrik (kWh)"
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2" />
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Nilai Penggunaan (Rp)</label>
                                        <input type="number" name="nilai_penggunaan_listrik" min="0" required
                                            placeholder="Masukkan Nilai (Contoh: 250000)"
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2" />
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Peruntukkan Listrik</label>
                                        <input type="text" id="peruntukkan_listrik" name="peruntukkan_listrik"
                                            required placeholder="Masukkan peruntukkan listrik"
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2" />
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-listrik"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- MESIN PRODUKSI --}}
                                <section id="form-mesin-produksi"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div class="mb-4 flex justify-end">
                                        <button type="button" onclick="tambahFormMesin()"
                                            class="bg-[#083458] text-white px-4 py-2 rounded-2xl hover:opacity-90">
                                            + Tambah Data Mesin/Peralatan
                                        </button>
                                    </div>

                                    <div id="form-mesin-container" class="flex flex-col gap-4">
                                        <div class="mesin-item border p-4 rounded-xl shadow" id="mesin-template">
                                            <div class="flex flex-col font-semibold text-gray-700 mb-2">Mesin/Peralatan
                                                1
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block mb-1 font-medium">Jenis Mesin atau
                                                        Peralatan</label>
                                                    <select name="jenis_mesin[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                        <option value="" disabled selected>Pilih Jenis</option>
                                                        <option value="Mesin">Mesin</option>
                                                        <option value="Peralatan">Peralatan</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block mb-1 font-medium">Nama Mesin atau
                                                        Peralatan</label>
                                                    <input type="text" name="nama_mesin[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full"
                                                        placeholder="Masukkan Nama Mesin">
                                                </div>

                                                <div>
                                                    <label class="block mb-1 font-medium">Merk atau Type</label>
                                                    <input type="text" name="merk_type[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full"
                                                        placeholder="Masukkan Merk">
                                                </div>

                                                <div>
                                                    <label class="block mb-1 font-medium">Teknologi</label>
                                                    <input type="text" name="teknologi[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full"
                                                        placeholder="Masukkan Teknologi">
                                                </div>

                                                <div>
                                                    <label class="block mb-1 font-medium">Negara Pembuat</label>
                                                    <input type="text" name="negara_pembuat[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full"
                                                        placeholder="Masukkan Negara">
                                                </div>

                                                @php
                                                    $tahunSekarang = date('Y');
                                                @endphp

                                                <div>
                                                    <label class="block mb-1 font-medium">Tahun Perolehan</label>
                                                    <select name="tahun_perolehan[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full">
                                                        <option value="">Pilih Tahun</option>
                                                        @for ($tahun = 2000; $tahun <= $tahunSekarang; $tahun++)
                                                            <option value="{{ $tahun }}">{{ $tahun }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block mb-1 font-medium">Tahun Pembuatan</label>
                                                    <select name="tahun_pembuatan[]" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full">
                                                        <option value="">Pilih Tahun</option>
                                                        @for ($tahun = 2000; $tahun <= $tahunSekarang; $tahun++)
                                                            <option value="{{ $tahun }}">{{ $tahun }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>


                                                <div>
                                                    <label class="block mb-1 font-medium">Jumlah Unit</label>
                                                    <input type="number" name="jumlah_unit[]" min="0" required
                                                        class="border border-black outline-black p-2 rounded-2xl w-full"
                                                        placeholder="Masukkan Jumlah Unit">
                                                </div>
                                            </div>

                                            <button type="button"
                                                class="hapus-item mt-4 mx-auto flex items-center gap-1 text-red-600 hover:text-red-800 font-medium text-sm hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-mesin-produksi"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>
                                <script>
                                    function tambahFormMesin() {
                                        const container = document.getElementById("form-mesin-container");
                                        const template = document.getElementById("mesin-template");

                                        const clone = template.cloneNode(true);
                                        clone.removeAttribute("id");

                                        // Reset input & select
                                        clone.querySelectorAll("input, select").forEach(el => {
                                            if (el.tagName === "SELECT") el.selectedIndex = 0;
                                            else el.value = "";
                                        });

                                        container.appendChild(clone);

                                        updateIndexMesin();
                                        updateTombolHapusMesin();
                                    }

                                    function updateIndexMesin() {
                                        const items = document.querySelectorAll("#form-mesin-container .mesin-item");
                                        items.forEach((item, idx) => {
                                            const judul = item.querySelector("div.font-semibold");
                                            if (judul) judul.textContent = "Mesin/Peralatan " + (idx + 1);
                                        });
                                    }

                                    function updateTombolHapusMesin() {
                                        const items = document.querySelectorAll("#form-mesin-container .mesin-item");

                                        items.forEach((item, idx) => {
                                            const hapusBtn = item.querySelector(".hapus-item");

                                            if (!hapusBtn) return;

                                            if (items.length === 1) {
                                                hapusBtn.classList.add("hidden");
                                                hapusBtn.onclick = null;
                                            } else {
                                                hapusBtn.classList.remove("hidden");
                                                hapusBtn.onclick = function() {
                                                    item.remove();
                                                    updateIndexMesin();
                                                    updateTombolHapusMesin();
                                                };
                                            }
                                        });
                                    }

                                    document.addEventListener("DOMContentLoaded", () => {
                                        updateTombolHapusMesin();
                                    });
                                </script>

                                {{-- PRODUKSI --}}
                                <section id="form-produksi"
                                    class="hidden relative z-0 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                                    <div>
                                        <label class="block mb-1 font-medium">Jenis Produksi</label>
                                        <input type="text" id="jenis_produksi" name="jenis_produksi" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Jenis Produksi">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">KBLI (Kode Bisnis dan Layanan
                                            Indonesia)</label>
                                        <input type="text" id="kbli" name="kbli" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan KBLI">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Kode HS (Harmonized System)</label>
                                        <input type="text" id="produksi_kode_hs" name="produksi_kode_hs" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Kode HS">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Spesifikasi</label>
                                        <input type="text" id="produksi_spesifikasi" name="produksi_spesifikasi"
                                            required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Spesifikasi Produksi">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Jumlah Produksi</label>
                                        <input type="number" id="jumlah_produksi" name="jumlah_produksi" min="0"
                                            step="any" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Jumlah Produksi">
                                    </div>


                                    <div>
                                        <label class="block mb-1 font-medium">Nilai</label>
                                        <input type="number" id="nilai_produksi" name="nilai_produksi" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Nilai Produksi">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Satuan</label>
                                        <select id="satuan" name="satuan" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>Pilih Satuan</option>
                                            <option value="kg">Kilogram (kg)</option>
                                            <option value="bungkus">Bungkus</option>
                                            <option value="biji">Biji</option>
                                            <option value="ton">Ton (t)</option>
                                            <option value="buah">Buah</option>
                                            <option value="liter">Liter (L)</option>
                                            <option value="galon">Galon</option>
                                            <option value="dos">Dos</option>
                                            <option value="balok">Balok</option>
                                            <option value="meter">Meter (m)</option>
                                            <option value="set">Set</option>
                                            <option value="lusin">Lusin</option>
                                            <option value="potong">Potong</option>
                                            <option value="lembar">Lembar</option>
                                            <option value="m3">Meter Kubik (m³)</option>
                                            <option value="tabung">Tabung</option>
                                            <option value="unit">Unit</option>
                                        </select>
                                    </div>


                                    <div>
                                        <label class="block mb-1 font-medium">Persentase Produk yang Diekspor
                                            (%)</label>
                                        <input type="number" id="persentase_ekspor" name="persentase_ekspor"
                                            min="0" max="100" step="0.01" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Persentase Produk yang Diekspor">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Negara Tujuan Ekspor</label>
                                        <input type="text" id="negara_ekspor" name="negara_ekspor"
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan Negara Tujuan Ekspor (boleh kosong)">
                                    </div>

                                    <div>
                                        <label for="kapasitas_tahun" class="block mb-1 font-medium">Kapasitas Terpasang
                                            per Tahun</label>
                                        <input type="number" id="kapasitas_tahun" name="kapasitas_tahun" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2"
                                            placeholder="Masukkan kapasitas per tahun">
                                    </div>


                                    <div class="col-span-1 md:col-span-2 flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-produksi"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- PERSEDIAAN --}}
                                <section id="form-persediaan" class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">
                                    <div>
                                        <label for="jenis_persediaan" class="block mb-1 font-medium">Jenis
                                            Persediaan</label>
                                        <select id="jenis_persediaan" name="jenis_persediaan" required
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            <option value="" disabled selected>-- Pilih Jenis Persediaan --
                                            </option>
                                            <option value="persediaan_bahan">Nilai Persediaan Bahan Baku, Bahan
                                                Penolong,
                                                Bahan Bakar, Bahan Pembungkus</option>
                                            <option value="setengah_jadi">Nilai Persediaan Barang Produksi Setengah
                                                Jadi
                                            </option>
                                            <option value="barang_jadi">Nilai Persediaan Barang Jadi yang Dihasilkan
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Awal (Rp)</label>
                                        <input type="number" id="awal" name="awal" min="0" required
                                            placeholder="Masukkan Nilai Awal (Contoh: 50000)"
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Akhir (Rp)</label>
                                        <input type="number" id="akhir" name="akhir" min="0" required
                                            placeholder="Masukkan Nilai Akhir (Contoh: 50000)"
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-persediaan"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- PENDAPATAN --}}
                                <section id="form-pendapatan"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm w-[300px]">
                                    <div>
                                        <label class="block mb-1 font-medium">Sumber</label>
                                        <input type="text" name="sumber" required
                                            placeholder="Masukkan Sumber Pendapatan"
                                            class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>

                                    <div>
                                        <label class="block mb-1 font-medium">Nilai (Rp)</label>
                                        <input type="number" name="nilai" min="0" required
                                            placeholder="Masukkan Nilai (Contoh:100000)"
                                            class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-pendapatan"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>

                                {{-- MODAL --}}
                                <section id="form-modal"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm w-full max-w-md">
                                    <div class="mb-4 flex justify-end">
                                        <button type="button" onclick="tambahFormModal()"
                                            class="bg-[#083458] text-white px-4 py-2 rounded-2xl hover:opacity-90">
                                            + Tambah Data Modal
                                        </button>
                                    </div>

                                    <div id="form-modal-container" class="flex flex-col gap-4">
                                        <div class="modal-item border p-4 rounded-xl shadow" id="modal-template">
                                            <div class="font-semibold text-gray-700 mb-2">Modal 1</div>

                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Jenis Barang Modal</label>
                                                <select name="jenis_barang[]" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                    <option value="" disabled selected>Pilih Jenis Barang Modal
                                                    </option>
                                                    <option value="tanah">Tanah</option>
                                                    <option value="gedung">Gedung</option>
                                                    <option value="mesin dan perlengkapan">Mesin dan Perlengkapan
                                                    </option>
                                                    <option value="kendaraan">Kendaraan</option>
                                                    <option value="software/database">Software/Database</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Pembelian/Penambahan dan
                                                    Pembuatan/Perbaikan Besar (Rp)</label>
                                                <input type="number" name="pembelian_penambahan_perbaikan[]"
                                                    min="0" required placeholder="Masukkan Nilai (Contoh: 100000)"
                                                    class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Penjualan/Pengurangan Barang
                                                    Modal
                                                    (Rp)</label>
                                                <input type="number" name="pengurangan_barang_modal[]" min="0"
                                                    required placeholder="Masukkan Nilai (Contoh: 100000)"
                                                    class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Penyusutan Barang (Rp)</label>
                                                <input type="number" name="penyusutan_barang[]" min="0" required
                                                    placeholder="Masukkan Nilai (Contoh: 100000)"
                                                    class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="mb-4">
                                                <label class="block mb-1 font-medium">Nilai Taksiran seluruh barang
                                                    modal
                                                    tetap menurut harga berlaku (Rp)</label>
                                                <input type="number" name="nilai_taksiran[]" min="0" required
                                                    placeholder="Masukkan Nilai (Contoh: 100000)"
                                                    class="no-spinner border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <button type="button"
                                                class="hapus-item mt-4 mx-auto flex items-center gap-1 text-red-600 hover:text-red-800 font-medium text-sm hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="next-modal"
                                            class="bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Selanjutnya</button>
                                    </div>
                                </section>
                                <script>
                                    function tambahFormModal() {
                                        const container = document.getElementById("form-modal-container");
                                        const template = document.getElementById("modal-template");

                                        const clone = template.cloneNode(true);
                                        clone.removeAttribute("id");

                                        // Reset input & select
                                        clone.querySelectorAll("input, select").forEach(el => {
                                            if (el.tagName === "SELECT") el.selectedIndex = 0;
                                            else el.value = "";
                                        });

                                        container.appendChild(clone);

                                        updateIndexModal();
                                        updateTombolHapusModal();
                                    }

                                    function updateIndexModal() {
                                        const items = document.querySelectorAll("#form-modal-container .modal-item");
                                        items.forEach((item, idx) => {
                                            const judul = item.querySelector("div.font-semibold");
                                            if (judul) judul.textContent = "Modal " + (idx + 1);
                                        });
                                    }

                                    function updateTombolHapusModal() {
                                        const items = document.querySelectorAll("#form-modal-container .modal-item");

                                        items.forEach((item, idx) => {
                                            const hapusBtn = item.querySelector(".hapus-item");

                                            if (!hapusBtn) return;

                                            if (items.length === 1) {
                                                hapusBtn.classList.add("hidden");
                                                hapusBtn.onclick = null;
                                            } else {
                                                hapusBtn.classList.remove("hidden");
                                                hapusBtn.onclick = function() {
                                                    item.remove();
                                                    updateIndexModal();
                                                    updateTombolHapusModal();
                                                };
                                            }
                                        });
                                    }

                                    document.addEventListener("DOMContentLoaded", () => {
                                        updateTombolHapusModal();
                                    });
                                </script>

                                {{-- BENTUK PENGELOLAAN --}}
                                <section id="form-bentuk-pengelolaan"
                                    class="hidden relative z-0 grid grid-cols-1 gap-4 text-sm">

                                    <!-- Limbah Padat -->
                                    <div class="mb-4">
                                        <label class="block mb-1 font-medium">Limbah Padat</label>
                                        <div class="flex flex-col md:flex-row gap-2">
                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1">Jenis Limbah</label>
                                                <input type="text" name="jenis_limbah" required
                                                    placeholder="Masukkan jenis limbah"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1">Jumlah (Ton)</label>
                                                <input type="number" name="jumlah_limbah" min="0" step="0.01"
                                                    placeholder="Masukkan jumlah (ton)"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Limbah B3 -->
                                    <div class="mb-4">
                                        <label class="block mb-1 font-medium">Limbah B3</label>
                                        <div class="flex flex-col md:flex-row gap-2">
                                            <div class="w-full md:w-1/3">
                                                <label class="block text-sm mb-1">Jenis Limbah</label>
                                                <input type="text" name="jenis_limbah_b3" required
                                                    placeholder="Masukkan jenis limbah"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="w-full md:w-1/3">
                                                <label class="block text-sm mb-1">Jumlah (Ton)</label>
                                                <input type="number" name="jumlah_limbah_b3" min="0"
                                                    step="0.01" placeholder="Masukkan jumlah (ton)"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="w-full md:w-1/3">
                                                <label class="block text-sm mb-1">Dikumpulkan di TPS</label>
                                                <input type="text" name="tps_limbah_b3"
                                                    placeholder="Masukkan lokasi TPS"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mitra & Pemanfaatan Internal -->
                                    <div class="mb-4">
                                        <div class="flex flex-col md:flex-row gap-2">
                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1 min-h-[48px]">Dikerjasamakan dengan
                                                    Pihak
                                                    Lain yang Telah Berizin</label>
                                                <input type="text" name="pihak_berizin"
                                                    placeholder="Masukkan nama mitra"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>

                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1 min-h-[48px]">Dimanfaatkan untuk
                                                    Internal
                                                    Industri</label>
                                                <input type="text" name="internal_industri"
                                                    placeholder="Masukkan pemanfaatan internal"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Limbah Cair -->
                                    <div class="mb-4">
                                        <label class="block mb-1 font-medium">Limbah Cair</label>
                                        <div class="flex flex-col md:flex-row gap-2">
                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1">Parameter</label>
                                                <select name="parameter_limbah_cair" required
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                                    <option value="" disabled selected>-- Pilih Parameter --
                                                    </option>
                                                    <option value="debit_inlet">Debit Limbah Cair di Inlet (m³)
                                                    </option>
                                                    <option value="debit_outlet">Debit Limbah Cair di Outlet (m³)
                                                    </option>
                                                    <option value="cod_inlet">COD pada Saluran Inlet (mg/L)</option>
                                                    <option value="cod_outlet">COD pada Saluran Outlet (mg/L)</option>
                                                    <option value="sludge_removed">Sludge Removed (kg)</option>
                                                </select>
                                            </div>

                                            <div class="w-full md:w-1/2">
                                                <label class="block text-sm mb-1">Banyaknya</label>
                                                <input type="number" name="jumlah_limbah_cair" min="0"
                                                    step="0.01" placeholder="Masukkan jumlah sesuai satuan"
                                                    class="border border-black outline-black p-2 rounded-2xl w-full focus:outline-2">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navigasi -->
                                    <div class="flex justify-center gap-4 mt-6">
                                        <button type="button"
                                            class="prev bg-[#083458] text-white px-6 py-2 rounded-3xl hover:opacity-90">Sebelumnya</button>
                                        <button type="button" id="submit-semua"
                                            class="bg-[#F49F1E] text-white px-6 py-2 rounded-3xl hover:opacity-90">
                                            Simpan
                                        </button>
                                    </div>
                                </section>
                            </form>
                        </section>
                    </div>
                </div>
            </section>
        </main>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ================================
            // KONFIGURASI DAN KONSTANTA
            // ================================
            const tabs = document.querySelectorAll('.tab-button');
            const contents = {
                'btn-data-ikm': document.getElementById('form-data-ikm'),
                'btn-persentase-pemilik': document.getElementById('form-persentase-pemilik'),
                'btn-karyawan': document.getElementById('form-karyawan'),
                'btn-pemakaian-bahan': document.getElementById('form-pemakaian-bahan'),
                'btn-penggunaan-air': document.getElementById('form-penggunaan-air'),
                'btn-pengeluaran': document.getElementById('form-pengeluaran'),
                'btn-bahan-bakar': document.getElementById('form-bahan-bakar'),
                'btn-listrik': document.getElementById('form-listrik'),
                'btn-mesin-produksi': document.getElementById('form-mesin-produksi'),
                'btn-produksi': document.getElementById('form-produksi'),
                'btn-persediaan': document.getElementById('form-persediaan'),
                'btn-pendapatan': document.getElementById('form-pendapatan'),
                'btn-modal': document.getElementById('form-modal'),
                'btn-bentuk-pengelolaan': document.getElementById('form-bentuk-pengelolaan'),
            };

            const formIds = Object.values(contents).map(el => el?.id).filter(Boolean);

            // ================================
            // TAB SWITCHING FUNCTIONALITY
            // ================================
            function showForm(idToShow) {
                Object.entries(contents).forEach(([key, section]) => {
                    const tab = document.getElementById(key);
                    if (!section || !tab) return;

                    const isActive = key === idToShow;

                    if (isActive) {
                        section.classList.remove('hidden');
                        section.classList.add('grid');
                    } else {
                        section.classList.add('hidden');
                        section.classList.remove('grid');
                    }

                    tab.classList.remove(
                        'bg-white', 'text-[#083458]', 'font-bold', 'border-b-4', 'border-[#083458]',
                        'bg-[#083458]', 'text-white', 'hover:bg-blue-200', 'hover:text-[#083458]',
                        'hover:border-[#083458]'
                    );

                    if (isActive) {
                        tab.classList.add('bg-white', 'text-[#083458]', 'font-bold', 'border-b-4',
                            'border-[#083458]');
                    } else {
                        tab.classList.add('bg-[#083458]', 'text-white', 'hover:bg-blue-200',
                            'hover:text-[#083458]', 'hover:border-[#083458]');
                    }
                });
            }


            function initTabSwitching() {
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        showForm(tab.id);
                    });
                });
            }

            // ================================
            // WILAYAH (KECAMATAN & KELURAHAN)
            // ================================
            function initWilayahDropdown() {
                const dataWilayah = @json($wilayah['kabupaten'] ?? []);
                const parepareKabupaten = dataWilayah.find(kab => kab.name === "Kota Parepare");
                const kecamatanSelect = document.getElementById('kecamatan');
                const kelurahanSelect = document.getElementById('kelurahan');

                if (parepareKabupaten && kecamatanSelect) {
                    // Bersihkan isi dropdown kecamatan sebelum diisi ulang
                    kecamatanSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';

                    // Populate kecamatan options tanpa duplikat
                    const added = new Set();
                    parepareKabupaten.kecamatan.forEach(kec => {
                        if (!added.has(kec.name)) {
                            const opt = document.createElement('option');
                            opt.value = kec.name;
                            opt.textContent = kec.name;
                            kecamatanSelect.appendChild(opt);
                            added.add(kec.name);
                        }
                    });

                    // Handle kecamatan change
                    kecamatanSelect.addEventListener('change', function() {
                        const selectedKec = parepareKabupaten.kecamatan.find(kec => kec.name === this
                            .value);
                        kelurahanSelect.innerHTML =
                            '<option value="" disabled selected>Pilih Kelurahan</option>';

                        if (selectedKec) {
                            selectedKec.kelurahan.forEach(kel => {
                                const opt = document.createElement('option');
                                opt.value = kel;
                                opt.textContent = kel;
                                kelurahanSelect.appendChild(opt);
                            });
                            kelurahanSelect.disabled = false;
                        } else {
                            kelurahanSelect.disabled = true;
                        }
                    });
                }
            }


            // ================================
            // FORM NAVIGATION (NEXT/PREV)
            // ================================
            function initFormNavigation() {
                document.querySelectorAll('button[id^="next-"]').forEach(button => {
                    button.addEventListener('click', e => {
                        e.preventDefault();
                        const currentBtnId = button.id.replace('next-',
                            'btn-'); // ubah ke id tombol
                        const btnIds = Object.keys(contents);
                        const currentIndex = btnIds.indexOf(currentBtnId);
                        if (currentIndex !== -1 && currentIndex + 1 < btnIds.length) {
                            showForm(btnIds[currentIndex + 1]);
                        }
                    });
                });

                Object.keys(contents).forEach(btnId => {
                    const section = contents[btnId];
                    const prevBtn = section?.querySelector('button.prev');
                    if (prevBtn) {
                        prevBtn.addEventListener('click', e => {
                            e.preventDefault();
                            const btnIds = Object.keys(contents);
                            const currentIndex = btnIds.indexOf(btnId);
                            if (currentIndex > 0) {
                                showForm(btnIds[currentIndex - 1]);
                            }
                        });
                    }
                });
            }

            // ================================
            // DYNAMIC FORM MANAGEMENT
            // ================================
            function initDynamicForms() {
                // Bahan Management
                function tambahFormBahan() {
                    const container = document.getElementById("form-bahan-container");
                    const template = document.getElementById("bahan-template");
                    const clone = template.cloneNode(true);
                    clone.removeAttribute("id");
                    clone.querySelectorAll("input, select").forEach(el => {
                        el.tagName === "SELECT" ? el.selectedIndex = 0 : el.value = "";
                    });
                    container.appendChild(clone);
                    updateIndexBahan();
                    updateTombolHapusBahan();
                }

                function updateIndexBahan() {
                    const items = document.querySelectorAll("#form-bahan-container .bahan-item");
                    items.forEach((item, idx) => {
                        const judul = item.querySelector("div.font-semibold");
                        if (judul) judul.textContent = "Bahan " + (idx + 1);
                    });
                }

                function updateTombolHapusBahan() {
                    const items = document.querySelectorAll("#form-bahan-container .bahan-item");
                    items.forEach(item => {
                        const hapusBtn = item.querySelector(".hapus-item");
                        if (!hapusBtn) return;
                        hapusBtn.classList.toggle("hidden", items.length === 1);
                        hapusBtn.onclick = function() {
                            item.remove();
                            updateIndexBahan();
                            updateTombolHapusBahan();
                        };
                    });
                }

                // Bahan Bakar Management
                function tambahBahanBakar() {
                    const container = document.getElementById("bahan-bakar-container");
                    const template = document.getElementById("bahan-bakar-template");
                    const clone = template.cloneNode(true);
                    clone.removeAttribute("id");
                    clone.querySelectorAll("input, select").forEach(el => {
                        el.tagName === "SELECT" ? el.selectedIndex = 0 : el.value = "";
                    });
                    container.appendChild(clone);
                    updateIndexBahanBakar();
                    updateTombolHapusBahanBakar();
                }

                function updateIndexBahanBakar() {
                    const items = document.querySelectorAll("#bahan-bakar-container .bahan-bakar-item");
                    items.forEach((item, idx) => {
                        const judul = item.querySelector(".judul-bahan-bakar");
                        if (judul) judul.textContent = "Bahan Bakar " + (idx + 1);
                    });
                }

                function updateTombolHapusBahanBakar() {
                    const items = document.querySelectorAll("#bahan-bakar-container .bahan-bakar-item");
                    items.forEach(item => {
                        const hapusBtn = item.querySelector(".hapus-item");
                        if (!hapusBtn) return;
                        hapusBtn.classList.toggle("hidden", items.length === 1);
                        hapusBtn.onclick = function() {
                            item.remove();
                            updateIndexBahanBakar();
                            updateTombolHapusBahanBakar();
                        };
                    });
                }

                // Initialize dynamic forms
                updateTombolHapusBahan();
                updateTombolHapusBahanBakar();

                // Make functions globally accessible if needed
                window.tambahFormBahan = tambahFormBahan;
                window.tambahBahanBakar = tambahBahanBakar;
            }

            // ================================
            // FORM PREFILL (DUMMY DATA)
            // ================================
            function prefillDummyData() {
                const form = document.getElementById('form-ikm');
                if (!form) return;

                const inputs = form.querySelectorAll('input');
                const selects = form.querySelectorAll('select');

                // Isi input
                inputs.forEach(el => {
                    if (el.name !== '_token' && el.type !== 'hidden') {
                        if (el.type === 'number') {
                            el.value = el.id && el.id.includes('tahun') ? Math.max(el.value || 0, 1900) :
                                98;
                        } else if (el.type === 'tel') {
                            el.value = '081234567890';
                        } else {
                            el.value = 'Contoh';
                        }
                    }
                });

                // Isi select
                selects.forEach(select => {
                    if (select.name === 'kecamatan') {
                        // Pilih kecamatan dan trigger change agar kelurahan aktif
                        const option = Array.from(select.options).find(opt => opt.value && !opt.disabled);
                        if (option) {
                            select.value = option.value;
                            select.dispatchEvent(new Event('change'));
                        }
                    } else if (select.name === 'kelurahan') {
                        // Tunggu kelurahan terisi dulu baru isi
                        const observer = new MutationObserver(() => {
                            const validOption = Array.from(select.options).find(opt => opt.value &&
                                !opt.disabled);
                            if (validOption) {
                                select.value = validOption.value;
                                observer.disconnect();
                            }
                        });
                        observer.observe(select, {
                            childList: true
                        });
                    } else {
                        // Select biasa → langsung pilih opsi pertama valid
                        const defaultOption = Array.from(select.options).find(opt => opt.value && !opt
                            .disabled);
                        if (defaultOption) {
                            select.value = defaultOption.value;
                        }
                    }
                });
            }

            // ================================
            // FORM VALIDATION INIT
            // ================================
            let sedangSubmit = false;

            function initFormValidation() {
                const submitButton = document.getElementById('submit-semua');
                if (!submitButton) return;

                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    // PENTING: Cek dulu apakah sedang submit
                    if (sedangSubmit) {
                        console.log('Form sedang diproses, menunggu...');
                        return;
                    }

                    let adaInputKosong = false;
                    let inputPertamaKosong = null;

                    for (let formId of formIds) {
                        const bagian = document.getElementById(formId);
                        if (!bagian) continue;

                        const inputs = bagian.querySelectorAll('input, select, textarea');
                        for (let input of inputs) {
                            if (input.hasAttribute('required') && !input.disabled && !input.value.trim()) {
                                adaInputKosong = true;
                                if (!inputPertamaKosong) {
                                    inputPertamaKosong = {
                                        input: input,
                                        formId: formId,
                                        label: input.closest('div')?.querySelector('label')?.textContent
                                            ?.trim() || input.name
                                    };
                                }
                                break;
                            }
                        }
                        if (adaInputKosong) break;
                    }

                    if (adaInputKosong && inputPertamaKosong) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Isian belum lengkap',
                            text: `Bagian "${inputPertamaKosong.label}" wajib diisi.`,
                            confirmButtonText: 'Oke, isi dulu',
                            confirmButtonColor: '#F49F1E'
                        }).then(() => {
                            const tabBtn = document.querySelector(
                                `.tab-button[id="btn-${inputPertamaKosong.formId.replace('form-', '')}"]`
                            );
                            if (tabBtn) tabBtn.click();
                            setTimeout(() => {
                                inputPertamaKosong.input.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                                inputPertamaKosong.input.focus();
                            }, 300);
                        });
                        return; // VALIDASI GAGAL - TIDAK LANJUT KE SUBMIT
                    }

                    // Jika validasi lolos, baru panggil submit
                    submitFormData();
                });
            }

            // ================================
            // SUBMIT FORM DATA TO BACKEND
            // ================================
            function submitFormData() {
                // PENTING: Double check untuk mencegah multiple submit
                if (sedangSubmit) {
                    console.log('Submit sedang berjalan, dibatalkan');
                    return;
                }

                // SET FLAG SUBMIT = TRUE
                sedangSubmit = true;

                const form = document.getElementById('form-ikm');
                const submitButton = document.getElementById('submit-semua');
                const formData = new FormData(form);

                // DISABLE BUTTON
                if (submitButton) submitButton.disabled = true;

                Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || formData.get('_token')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json().catch(() => ({
                            success: false,
                            errors: {
                                msg: ['Response JSON tidak valid']
                            }
                        }));
                    })
                    .then(data => {
                        Swal.close();

                        // SUKSES - Data berhasil disimpan
                        if (data.success === true && (!data.errors || Object.keys(data.errors).length === 0)) {
                            // TIDAK RESET FLAG DI SINI - BIARKAN TETAP TRUE UNTUK PREVENT DOUBLE SUBMIT

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan!',
                                confirmButtonText: 'Oke',
                                confirmButtonColor: '#22c55e'
                            }).then(() => {
                                window.location.href = "/data-IKM";
                            });

                            // FLAG AKAN DIRESET OTOMATIS SAAT PAGE REDIRECT
                            return;
                        }

                        // GAGAL - Ada error dari server
                        handleFormErrors(data, form, submitButton);
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Kesalahan AJAX:', error);

                        // RESET FLAG DAN BUTTON PADA NETWORK/SERVER ERROR
                        resetSubmitState(submitButton);

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Server error saat menyimpan data. Cek konsol/log.',
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#e74c3c'
                        });
                    });
            }

            // ================================
            // HELPER FUNCTIONS
            // ================================
            function resetSubmitState(submitButton) {
                sedangSubmit = false;
                if (submitButton) submitButton.disabled = false;
            }

            function handleFormErrors(data, form, submitButton) {
                // RESET FLAG DAN BUTTON KARENA ADA ERROR VALIDASI
                resetSubmitState(submitButton);

                const errors = data.errors || {};
                const tabMapping = {};

                const fieldToTabIdMap = {
                    konsistensi_pemilik: 'persentase-pemilik',
                    konsistensi_karyawan: 'karyawan',
                    konsistensi_bahan: 'pemakaian-bahan',
                    konsistensi_bahan_bakar: 'bahan-bakar',
                    konsistensi_listrik: 'listrik',
                    konsistensi_mesin: 'mesin-produksi',
                    konsistensi_produksi: 'produksi',
                    msg: 'data-ikm'
                };

                if (Object.keys(errors).length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan yang tidak diketahui.',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#e74c3c'
                    });
                    return;
                }

                // MAPPING ERRORS KE TAB
                Object.keys(errors).forEach(field => {
                    const messages = Array.isArray(errors[field]) ? errors[field] : [errors[field]];
                    const baseField = field.split('.')[0];
                    const formField = form.querySelector(`[name="${baseField}"]`) || form.querySelector(
                        `[name^="${baseField}"]`);
                    const formSection = formField?.closest('[id^="form-"]');
                    const tabId = formSection?.id.replace('form-', '') || fieldToTabIdMap[field] ||
                        'unknown';

                    if (!tabMapping[tabId]) tabMapping[tabId] = [];
                    messages.forEach(msg => tabMapping[tabId].push(msg));
                });

                // BUILD ERROR HTML
                let html = '<div style="text-align:left;font-size:14px">';
                Object.entries(tabMapping).forEach(([tabId, messages]) => {
                    html += `<div style="margin-bottom:10px"><b>${getTabDisplayName(tabId)}</b><ul>`;
                    messages.forEach(msg => {
                        html += `<li>${msg}</li>`;
                    });
                    html += '</ul></div>';
                });
                html += '</div>';

                // SHOW ERROR DIALOG
                const tabToFocus = Object.keys(tabMapping)[0];
                const firstErrorField = Object.keys(errors)[0];
                const elementToFocus = form.querySelector(`[name^="${firstErrorField.split('.')[0]}"]`);

                Swal.fire({
                    icon: 'error',
                    title: 'Data yang diinput tidak sesuai',
                    html: html,
                    confirmButtonText: 'Periksa Lagi',
                    confirmButtonColor: '#e74c3c'
                }).then(() => {
                    const tabBtn = document.querySelector(`.tab-button[id="btn-${tabToFocus}"]`) ||
                        document.querySelector(`#btn-${tabToFocus}`);
                    if (tabBtn) tabBtn.click();
                    setTimeout(() => {
                        if (elementToFocus && typeof elementToFocus.scrollIntoView === 'function') {
                            elementToFocus.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            elementToFocus.focus();
                        }
                    }, 400);
                });
            }

            function getTabDisplayName(tabId) {
                const tabNames = {
                    'data-ikm': 'Data IKM',
                    'persentase-pemilik': 'Persentase Pemilik',
                    'karyawan': 'Data Karyawan',
                    'pemakaian-bahan': 'Pemakaian Bahan',
                    'penggunaan-air': 'Penggunaan Air',
                    'pengeluaran': 'Pengeluaran',
                    'bahan-bakar': 'Bahan Bakar',
                    'listrik': 'Listrik',
                    'mesin-produksi': 'Mesin Produksi',
                    'produksi': 'Produksi',
                    'persediaan': 'Persediaan',
                    'pendapatan': 'Pendapatan Lain',
                    'modal': 'Modal',
                    'bentuk-pengelolaan': 'Pengelolaan Limbah'
                };
                return tabNames[tabId] || (tabId.charAt(0).toUpperCase() + tabId.slice(1));
            }


            // ================================
            // INISIALISASI SEMUA FUNGSI
            // ================================
            function init() {
                console.log("Inisialisasi dijalankan");
                initTabSwitching();
                initWilayahDropdown();
                initFormNavigation();
                initDynamicForms();
                prefillDummyData();
                initFormValidation();

                showForm('btn-data-ikm');
            }

            init();

            const closeBtn = document.getElementById('closeModal');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    const modal = document.getElementById('modal');
                    if (modal) modal.classList.add('hidden');
                });
            }



            // ================================
            // HANDLE ERROR KONSISTENSI DARI SERVER (jika ada reload halaman dengan error)
            // ================================
            @if ($errors->has('konsistensi'))
                // Jika halaman di-reload dengan error konsistensi, tampilkan pesan
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak konsisten',
                    text: @json($errors->first('konsistensi')),
                    confirmButtonText: 'Periksa Lagi',
                    confirmButtonColor: '#e74c3c'
                }).then(() => {
                    const tabBtn = document.getElementById('btn-karyawan');
                    if (tabBtn) tabBtn.click();
                });
            @endif

        });
    </script>
@endpush
