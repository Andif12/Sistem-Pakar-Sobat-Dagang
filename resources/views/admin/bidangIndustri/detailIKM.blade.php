@extends('layouts.admin')
@section('title', 'Detail Data IKM')

@section('content')
    <main class="relative min-h-screenflex flex-col flex-1 bg-gray-100" x-data="ikmModalEdit()" x-init="init()">

        <header class="relative z-10">
            <div class="relative w-full h-44">
                <img src="{{ asset('/assets/img/background/user_industri.png') }}" alt="Banner"
                    class="object-cover w-full h-44">
                <a href="{{ route('dataIKM') }}"
                    class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-6 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
                    <span class="text-2xl material-symbols-outlined">
                        arrow_back
                    </span>
                </a>
            </div>

            <div class="absolute inset-x-0 bottom-0 flex justify-center transform translate-y-1/2 z-20">
                <div class="bg-white shadow-lg px-6 py-3 rounded-xl">
                    <h1 class="text-2xl font-semibold text-[#083458]">
                        Detail IKM: {{ $ikm->nama_ikm }}
                    </h1>
                </div>
            </div>
        </header>


        <div class="px-4  mt-[100px] md:mt-10">
            {{-- Wrapper dua panel berdampingan --}}
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="lg:w-1/3 flex flex-col gap-5">

                    {{-- Detail Data IKM --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Data IKM</span>
                            @if ($ikm)
                                <button type="button" @click='openIKM(@json($ikm))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-4 overflow-x-auto">
                            @if ($ikm)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nama Pemilik</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->nama_pemilik }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Kelamin</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->jenis_kelamin }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Kecamatan</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->kecamatan }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Kelurahan</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->kelurahan }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Alamat</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->alamat }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Luas Lahan</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->luas }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Komoditi</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->komoditi }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Industri</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->jenis_industri }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">NIB</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->nib }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">No Telepon</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->no_telp }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jumlah Tenaga Kerja</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->tenaga_kerja }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai Investasi</td>
                                            <td class="px-4 py-2 text-right">
                                                Rp {{ number_format($ikm->level, 0, ',', '.') }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Data IKM tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Data IKM --}}
                    <div x-show="openModalIKM" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-3xl max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT DATA IKM</h2>

                            <form :action="'{{ url('data-IKM/update') }}'" method="POST">
                                @csrf
                                <input type="hidden" name="id_ikm" :value="formIKM.id_ikm">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Nama IKM</label>
                                        <input type="text" name="nama_ikm" x-model="formIKM.nama_ikm"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Nama Pemilik</label>
                                        <input type="text" name="nama_pemilik" x-model="formIKM.nama_pemilik"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" x-model="formIKM.jenis_kelamin"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Kecamatan</label>
                                        <input type="text" name="kecamatan" x-model="formIKM.kecamatan"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Kelurahan</label>
                                        <input type="text" name="kelurahan" x-model="formIKM.kelurahan"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Alamat</label>
                                        <input type="text" name="alamat" x-model="formIKM.alamat"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Luas Lahan</label>
                                        <input type="text" name="luas" x-model="formIKM.luas"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Komoditi</label>
                                        <input type="text" name="komoditi" x-model="formIKM.komoditi"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Jenis Industri</label>
                                        <input type="text" name="jenis_industri" x-model="formIKM.jenis_industri"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">NIB</label>
                                        <input type="text" name="nib" x-model="formIKM.nib"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">No Telepon</label>
                                        <input type="text" name="no_telp" x-model="formIKM.no_telp"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Jumlah Tenaga Kerja</label>
                                        <input type="number" name="tenaga_kerja" x-model="formIKM.tenaga_kerja"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>
                                </div>

                                <div class="flex justify-center pt-6">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Pengeluaran --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Pengeluaran</span>
                            @if ($ikm->pengeluaran)
                                <button type="button" @click='openEditPengeluaran(@json($ikm->pengeluaran))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-2 overflow-x-auto">
                            @if ($ikm->pengeluaran)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Upah & Gaji</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->upah_gaji, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Distribusi Industri</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->pengeluaran_industri_distribusi, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Penelitian & Pengembangan
                                                (R&D)
                                            </td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->pengeluaran_rnd, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Tanah</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->pengeluaran_tanah, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Gedung</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->pengeluaran_gedung, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Mesin</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->pengeluaran_mesin, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Lain-lain</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->pengeluaran->lainnya, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data pengeluaran.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Pengeluaran --}}
                    <div x-show="openModalPengeluaran" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-3xl max-h-[90vh] justify-center items-center overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENGELUARAN</h2>

                            <form :action="'{{ url('data-IKM/pengeluaran/update') }}'" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="id" :value="formPengeluaran.id_pengeluaran">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upah & Gaji</label>
                                        <input type="number" name="upah_gaji" x-model="formPengeluaran.upah_gaji"
                                            min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Distribusi
                                            Industri</label>
                                        <input type="number" name="pengeluaran_industri_distribusi"
                                            x-model="formPengeluaran.pengeluaran_industri_distribusi" min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Penelitian &
                                            Pengembangan
                                            (R&D)</label>
                                        <input type="number" name="pengeluaran_rnd"
                                            x-model="formPengeluaran.pengeluaran_rnd" min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanah</label>
                                        <input type="number" name="pengeluaran_tanah"
                                            x-model="formPengeluaran.pengeluaran_tanah" min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gedung</label>
                                        <input type="number" name="pengeluaran_gedung"
                                            x-model="formPengeluaran.pengeluaran_gedung" min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Mesin</label>
                                        <input type="number" name="pengeluaran_mesin"
                                            x-model="formPengeluaran.pengeluaran_mesin" min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Lain-lain</label>
                                        <input type="number" name="lainnya" x-model="formPengeluaran.lainnya"
                                            min="0"
                                            class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                    </div>
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Persediaan --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Persediaan</span>
                            @if ($ikm->persediaan->first())
                                <button type="button" @click='openEditPersediaan(@json($ikm->persediaan->first()))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-1 overflow-x-auto">
                            @php $persediaan = $ikm->persediaan->first(); @endphp

                            @if ($persediaan)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Persediaan</td>
                                            <td class="px-4 py-2 text-right">{{ $persediaan->jenis_persediaan }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai Awal</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($persediaan->awal, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai Akhir</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($persediaan->akhir, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data persediaan.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Persediaan --}}
                    <div x-show="openModalPersediaan" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PERSEDIAAN</h2>

                            <form :action="'{{ url('data-IKM/persediaan/update') }}'" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="id" :value="formPersediaan.id_persediaan">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Persediaan</label>
                                    <input type="text" name="jenis_persediaan"
                                        x-model="formPersediaan.jenis_persediaan" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Awal (Rp)</label>
                                    <input type="number" name="awal" x-model="formPersediaan.awal" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Akhir (Rp)</label>
                                    <input type="number" name="akhir" x-model="formPersediaan.akhir" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 flex flex-col gap-6">
                    {{-- Detail Tenaga Kerja --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Tenaga Kerja</span>
                            @if ($ikm->karyawan)
                                <button type="button" @click='openEditTenagaKerja(@json($ikm->karyawan))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-4 overflow-x-auto">
                            @if ($ikm->karyawan)
                                @php
                                    $pendidikan = [
                                        'SD' => $ikm->karyawan->sd,
                                        'SMP' => $ikm->karyawan->smp,
                                        'SMA/SMK' => $ikm->karyawan->sma_smk,
                                        'D1–D3' => $ikm->karyawan->d1_d3,
                                        'S1/D4' => $ikm->karyawan->s1_d4,
                                        'S2' => $ikm->karyawan->s2,
                                        'S3' => $ikm->karyawan->s3,
                                    ];
                                @endphp

                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <thead class="bg-[#CAE2F6] text-[#083458]">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Kategori</th>
                                            <th class="px-4 py-2 text-left">Keterangan</th>
                                            <th class="px-4 py-2 text-right">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        {{-- Status --}}
                                        <tr>
                                            <td class="px-4 py-2" rowspan="2"><strong>Status</strong></td>
                                            <td class="px-4 py-2">Tetap</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->karyawan->tenaga_kerja_tetap }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2">Tidak Tetap</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ $ikm->karyawan->tenaga_kerja_tidak_tetap }}
                                            </td>
                                        </tr>

                                        {{-- Jenis Kelamin --}}
                                        <tr>
                                            <td class="px-4 py-2" rowspan="2"><strong>Jenis Kelamin</strong></td>
                                            <td class="px-4 py-2">Laki-laki</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->karyawan->tenaga_kerja_laki_laki }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-2">Perempuan</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->karyawan->tenaga_kerja_perempuan }}
                                            </td>
                                        </tr>

                                        {{-- Pendidikan --}}
                                        <tr>
                                            <td class="px-4 py-2" rowspan="{{ count($pendidikan) }}">
                                                <strong>Pendidikan</strong>
                                            </td>
                                            <td class="px-4 py-2">SD</td>
                                            <td class="px-4 py-2 text-right">{{ $pendidikan['SD'] }}</td>
                                        </tr>
                                        @foreach (array_slice($pendidikan, 1) as $label => $jumlah)
                                            <tr>
                                                <td class="px-4 py-2">{{ $label }}</td>
                                                <td class="px-4 py-2 text-right">{{ $jumlah }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data tenaga kerja.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Tenaga Kerja --}}
                    <div x-show="openModalTenagaKerja" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-3xl max-h-[90vh] justify-center items-center overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT TENAGA KERJA</h2>

                            <form :action="'{{ url('data-IKM/karyawan/update') }}'" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="id" :value="formTenagaKerja.id_karyawan">

                                {{-- Status Tenaga Kerja --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Tenaga Kerja</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Tetap</label>
                                            <input type="number" name="tenaga_kerja_tetap"
                                                x-model="formTenagaKerja.tenaga_kerja_tetap"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Tidak Tetap</label>
                                            <input type="number" name="tenaga_kerja_tidak_tetap"
                                                x-model="formTenagaKerja.tenaga_kerja_tidak_tetap"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                        </div>
                                    </div>
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin Tenaga
                                        Kerja</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Laki-laki</label>
                                            <input type="number" name="tenaga_kerja_laki_laki"
                                                x-model="formTenagaKerja.tenaga_kerja_laki_laki"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Perempuan</label>
                                            <input type="number" name="tenaga_kerja_perempuan"
                                                x-model="formTenagaKerja.tenaga_kerja_perempuan"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:outline-2 focus:outline-[#083458]">
                                        </div>
                                    </div>
                                </div>

                                {{-- Pendidikan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Pendidikan Tenaga
                                        Kerja</label>
                                    <div class="flex flex-wrap gap-4 justify-center">
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">SD</label>
                                            <input type="number" name="sd" x-model="formTenagaKerja.sd"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">SMP</label>
                                            <input type="number" name="smp" x-model="formTenagaKerja.smp"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">SMA/SMK</label>
                                            <input type="number" name="sma_smk" x-model="formTenagaKerja.sma_smk"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">D1 sd. D3</label>
                                            <input type="number" name="d1_d3" x-model="formTenagaKerja.d1_d3"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">S1/D4</label>
                                            <input type="number" name="s1_d4" x-model="formTenagaKerja.s1_d4"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">S2</label>
                                            <input type="number" name="s2" x-model="formTenagaKerja.s2"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                        <div class="flex flex-col w-[130px]">
                                            <label class="block mb-1 text-sm">S3</label>
                                            <input type="number" name="s3" x-model="formTenagaKerja.s3"
                                                class="border border-gray-300 outline-[#083458] p-2 rounded-2xl w-full focus:outline-2">
                                        </div>
                                    </div>
                                </div>


                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Pengelolaan Limbah --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Pengelolaan Limbah</span>
                            @if ($ikm->bentukPengelolaanLimbah->first())
                                <button type="button" @click='openEditLimbah(@json($ikm->bentukPengelolaanLimbah->first()))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-4 overflow-x-auto">
                            @php
                                $limbah = $ikm->bentukPengelolaanLimbah->first();
                            @endphp

                            @if ($limbah)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        {{-- Limbah Padat --}}
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Limbah Padat</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->jenis_limbah ?? '-' }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jumlah Limbah Padat (kg)</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->jumlah_limbah }}</td>
                                        </tr>

                                        {{-- Limbah B3 --}}
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Limbah B3</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->jenis_limbah_b3 ?? '-' }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jumlah Limbah B3 (kg)</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->jumlah_limbah_b3 }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">TPS Limbah B3</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->tps_limbah_b3 ?? '-' }}</td>
                                        </tr>

                                        {{-- Pengelolaan --}}
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Pihak Berizin</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->pihak_berizin ?? '-' }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Pengelolaan Internal Industri
                                            </td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->internal_industri ?? '-' }}</td>
                                        </tr>

                                        {{-- Limbah Cair --}}
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Parameter Limbah Cair</td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->parameter_limbah_cair ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jumlah Limbah Cair (liter)
                                            </td>
                                            <td class="px-4 py-2 text-right">{{ $limbah->jumlah_limbah_cair }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data pengelolaan limbah.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Pengelolaan Limbah --}}
                    <div x-show="openModalLimbah" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-3xl max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENGELOLAAN LIMBAH</h2>

                            <form :action="'{{ url('data-IKM/limbah/update') }}'" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="id" :value="formLimbah.id_limbah">

                                {{-- Limbah Padat --}}
                                <div>
                                    <label class="block text-sm font-semibold text-[#083458] mb-2 text-center">Limbah
                                        Padat</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Jenis
                                                Limbah</label>
                                            <input type="text" name="jenis_limbah" x-model="formLimbah.jenis_limbah"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan jenis limbah padat">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Jumlah (kg)</label>
                                            <input type="number" name="jumlah_limbah" x-model="formLimbah.jumlah_limbah"
                                                min="0" step="0.01"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan jumlah limbah padat">
                                        </div>
                                    </div>
                                </div>

                                {{-- Limbah B3 --}}
                                <div>
                                    <label class="block text-sm font-semibold text-[#083458] mb-2 text-center">Limbah
                                        B3</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Jenis
                                                Limbah</label>
                                            <input type="text" name="jenis_limbah_b3"
                                                x-model="formLimbah.jenis_limbah_b3"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan jenis limbah B3">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Jumlah (kg)</label>
                                            <input type="number" name="jumlah_limbah_b3"
                                                x-model="formLimbah.jumlah_limbah_b3" min="0" step="0.01"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan jumlah limbah B3">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">TPS Limbah
                                                B3</label>
                                            <input type="text" name="tps_limbah_b3" x-model="formLimbah.tps_limbah_b3"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan lokasi TPS">
                                        </div>
                                    </div>
                                </div>

                                {{-- Pengelolaan --}}
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-[#083458] mb-2 text-center">Pengelolaan</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Pihak
                                                Berizin</label>
                                            <input type="text" name="pihak_berizin" x-model="formLimbah.pihak_berizin"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan nama mitra">
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Internal
                                                Industri</label>
                                            <input type="text" name="internal_industri"
                                                x-model="formLimbah.internal_industri"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan pemanfaatan internal">
                                        </div>
                                    </div>
                                </div>

                                {{-- Limbah Cair --}}
                                <div>
                                    <label class="block text-sm font-semibold text-[#083458] mb-2 text-center">Limbah
                                        Cair</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Parameter</label>
                                            <select name="parameter_limbah_cair"
                                                x-model="formLimbah.parameter_limbah_cair"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]">
                                                <option value="" disabled>-- Pilih Parameter --</option>
                                                <option value="debit_inlet">Debit Limbah Cair di Inlet (m³)</option>
                                                <option value="debit_outlet">Debit Limbah Cair di Outlet (m³)</option>
                                                <option value="cod_inlet">COD pada Saluran Inlet (mg/L)</option>
                                                <option value="cod_outlet">COD pada Saluran Outlet (mg/L)</option>
                                                <option value="sludge_removed">Sludge Removed (kg)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1 text-center">Jumlah</label>
                                            <input type="number" name="jumlah_limbah_cair"
                                                x-model="formLimbah.jumlah_limbah_cair" min="0" step="0.01"
                                                class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm text-center focus:outline-2 focus:outline-[#083458]"
                                                placeholder="Masukkan jumlah">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Pendapatan --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Pendapatan</span>
                            @if ($ikm->pendapatan->first())
                                <button type="button" @click='openEditPendapatan(@json($ikm->pendapatan->first()))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-4 overflow-x-auto">
                            @php
                                $pendapatan = $ikm->pendapatan->first();
                            @endphp

                            @if ($pendapatan)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Sumber</td>
                                            <td class="px-4 py-2 text-right">{{ $pendapatan->sumber }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai (Rp)</td>
                                            <td class="px-4 py-2 text-right">
                                                Rp {{ number_format($pendapatan->nilai, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data pendapatan.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Modal Edit Pendapatan --}}
                    <div x-show="openModalPendapatan" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENDAPATAN</h2>

                            <form :action="'{{ url('data-IKM/pendapatan/update') }}'" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="id" :value="formPendapatan.id_pendapatan">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber</label>
                                    <input type="text" name="sumber" x-model="formPendapatan.sumber" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai (Rp)</label>
                                    <input type="number" name="nilai" x-model="formPendapatan.nilai" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm
                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 flex flex-col gap-5">
                    {{-- Detail Persentase Kepemilikan --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Persentase Kepemilikan</span>

                            @if ($ikm->persentasePemilik)
                                <button type="button" @click='openEditPersentase(@json($ikm->persentasePemilik))'
                                    class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </button>
                            @endif
                        </div>

                        <div class="p-4 overflow-x-auto">
                            @if ($ikm->persentasePemilik)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <thead class="bg-[#CAE2F6] text-[#083458]">
                                        <tr>
                                            <th class="px-4 py-2 text-left">Jenis Kepemilikan</th>
                                            <th class="px-4 py-2 text-right">Persentase (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">Pemerintah Pusat</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($ikm->persentasePemilik->pemerintah_pusat, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">Pemerintah Daerah</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($ikm->persentasePemilik->pemerintah_daerah, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">Swasta Nasional</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($ikm->persentasePemilik->swasta_nasional, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">Asing</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($ikm->persentasePemilik->asing, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data persentase kepemilikan.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Persentase Kepemilikan --}}
                    <div x-show="openModalPersentase" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PERSENTASE KEPEMILIKAN</h2>

                            <form :action="'{{ url('data-IKM/persentase/update') }}'" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="id" :value="formPersentase.id_persentase">

                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemerintah Pusat
                                            (%)</label>
                                        <input type="number" step="0.01" name="pemerintah_pusat"
                                            x-model="formPersentase.pemerintah_pusat" required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pemerintah Daerah
                                            (%)</label>
                                        <input type="number" step="0.01" name="pemerintah_daerah"
                                            x-model="formPersentase.pemerintah_daerah" required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Swasta Nasional
                                            (%)</label>
                                        <input type="number" step="0.01" name="swasta_nasional"
                                            x-model="formPersentase.swasta_nasional" required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Asing (%)</label>
                                        <input type="number" step="0.01" name="asing"
                                            x-model="formPersentase.asing" required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Produksi --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Produksi</span>
                            <button type="button" @click='openEditProduksi(@json($ikm->produksi->first()))'
                                class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </button>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            @php $produksi = $ikm->produksi->first(); @endphp

                            @if ($produksi)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Jenis Produksi</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->jenis_produksi }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">KBLI</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->kbli }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Kode HS</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->kode_hs }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Spesifikasi</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->spesifikasi }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Banyaknya</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->banyaknya }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai (Rp)</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($produksi->nilai, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Satuan</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->satuan }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">% Produk Ekspor</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->presentase_produk_ekspor }}%
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Negara Tujuan Ekspor</td>
                                            <td class="px-4 py-2 text-right">{{ $produksi->negara_tujuan_ekspor ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Kapasitas Terpasang/Tahun</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ $produksi->kapasitas_terpasang_per_tahun }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data produksi.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Produksi --}}
                    <div x-show="openModalProduksi" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-3xl max-h-[90vh] overflow-y-auto relative ml-24">
                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT DATA PRODUKSI</h2>

                            <form :action="'{{ url('data-IKM/produksi/update') }}'" method="POST"
                                class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @csrf
                                <input type="hidden" name="id" :value="formProduksi.id_produksi">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produksi</label>
                                    <input type="text" name="jenis_produksi" x-model="formProduksi.jenis_produksi"
                                        required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">KBLI</label>
                                    <input type="text" name="kbli" x-model="formProduksi.kbli" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode HS</label>
                                    <input type="text" name="kode_hs" x-model="formProduksi.kode_hs" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Spesifikasi</label>
                                    <input type="text" name="spesifikasi" x-model="formProduksi.spesifikasi" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Banyaknya</label>
                                    <input type="number" name="banyaknya" x-model="formProduksi.banyaknya" required
                                        step="any"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai (Rp)</label>
                                    <input type="number" name="nilai" x-model="formProduksi.nilai" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                                    <input type="text" name="satuan" x-model="formProduksi.satuan" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">% Produk Ekspor</label>
                                    <input type="number" name="presentase_produk_ekspor" step="0.01"
                                        x-model="formProduksi.presentase_produk_ekspor" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Negara Tujuan
                                        Ekspor</label>
                                    <input type="text" name="negara_tujuan_ekspor"
                                        x-model="formProduksi.negara_tujuan_ekspor"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas
                                        Terpasang/Tahun</label>
                                    <input type="number" name="kapasitas_terpasang_per_tahun"
                                        x-model="formProduksi.kapasitas_terpasang_per_tahun" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
                                </div>

                                <div class="md:col-span-2 flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Penggunaan Listrik --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Penggunaan Listrik</span>
                            <button type="button" @click='openEditListrik(@json($ikm->listrik))'
                                class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </button>
                        </div>
                        <div class="p-1 overflow-x-auto">
                            @if ($ikm->listrik)
                                <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Sumber</td>
                                            <td class="px-4 py-2 text-right">{{ ucfirst($ikm->listrik->sumber) }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Banyaknya (kWh)</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->listrik->banyaknya }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Nilai</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->listrik->nilai, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Peruntukkan</td>
                                            <td class="px-4 py-2 text-right">{{ ucfirst($ikm->listrik->peruntukkan) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data penggunaan listrik.</p>
                            @endif
                        </div>
                    </div>
                    {{-- Modal Edit Penggunaan Listrik --}}
                    <div x-show="openModalListrik" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">
                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>
                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENGGUNAAN LISTRIK</h2>
                            <form :action="'{{ url('data-IKM/penggunaan-listrik/update') }}'" method="POST"
                                class="space-y-4">
                                @csrf
                                <input type="hidden" name="id" :value="formListrik.id_listrik">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber</label>
                                    <input type="text" name="sumber" x-model="formListrik.sumber" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Banyaknya (kWh)</label>
                                    <input type="number" name="banyaknya" x-model="formListrik.banyaknya" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nilai</label>
                                    <input type="number" name="nilai" x-model="formListrik.nilai" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Peruntukkan</label>
                                    <input type="text" name="peruntukkan" x-model="formListrik.peruntukkan" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>
                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Detail Penggunaan Air --}}
                    <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                        <div
                            class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold flex items-center justify-between">
                            <span>Detail Penggunaan Air</span>
                            <button type="button" @click='openEditAir({!! json_encode($ikm->penggunaanAir) !!})'
                                class="flex items-center gap-1 bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </button>
                        </div>

                        <div class="overflow-x-auto p-1">
                            @if ($ikm->penggunaanAir)
                                <table class="min-w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Sumber Air</td>
                                            <td class="px-4 py-2 text-right">{{ $ikm->penggunaanAir->sumber_air }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Banyaknya Penggunaan (m³)</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ $ikm->penggunaanAir->banyaknya_penggunaan_m3 }}</td>
                                        </tr>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 font-medium text-[#083458]">Biaya</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ 'Rp ' . number_format($ikm->penggunaanAir->biaya, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="italic text-gray-500">Tidak ada data penggunaan air.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Modal Penggunaan Air --}}
                    <div x-show="openModalAir" x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                        <div @click.away="closeModal" @keydown.escape.window="closeModal"
                            class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">

                            <button @click="closeModal" type="button"
                                class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                                &times;
                            </button>

                            <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENGGUNAAN AIR</h2>

                            <form :action="'{{ url('data-IKM/penggunaan-air/update') }}'" method="POST"
                                class="space-y-4">
                                @csrf
                                <input type="hidden" name="id" :value="formAir.id_air">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Air</label>
                                    <input type="text" name="sumber_air" x-model="formAir.sumber_air" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Banyaknya Penggunaan
                                        (m³)</label>
                                    <input type="number" name="banyaknya_penggunaan_m3" step="0.01"
                                        x-model="formAir.banyaknya_penggunaan_m3" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya</label>
                                    <input type="number" name="biaya" x-model="formAir.biaya" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                </div>

                                <div class="flex justify-center pt-4">
                                    <button type="submit"
                                        class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col pt-6 gap-6 justify-center items-stretch">
                {{-- Detail Pemakaian Bahan --}}
                <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                    <div class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold">Pemakaian Bahan
                    </div>
                    <div class="p-4 overflow-x-auto">
                        @if ($ikm->pemakaianBahan->count())
                            <table class="min-w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                <thead class="bg-[#CAE2F6] text-[#083458]">
                                    <tr>
                                        <th class="px-4 py-2">Nama</th>
                                        <th class="px-4 py-2">Jenis</th>
                                        <th class="px-4 py-2">Spesifikasi</th>
                                        <th class="px-4 py-2">Kode HS</th>
                                        <th class="px-4 py-2">Satuan</th>
                                        <th class="px-4 py-2 text-right">Jumlah DN</th>
                                        <th class="px-4 py-2 text-right">Nilai DN</th>
                                        <th class="px-4 py-2 text-right">Jumlah Impor</th>
                                        <th class="px-4 py-2 text-right">Nilai Impor</th>
                                        <th class="px-4 py-2">Negara Asal</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($ikm->pemakaianBahan as $bahan)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $bahan->nama_bahan }}</td>
                                            <td class="px-4 py-2">{{ $bahan->jenis_bahan }}</td>
                                            <td class="px-4 py-2">{{ $bahan->spesifikasi }}</td>
                                            <td class="px-4 py-2">{{ $bahan->kode_hs }}</td>
                                            <td class="px-4 py-2">{{ $bahan->satuan_standar }}</td>
                                            <td class="px-4 py-2 text-right">{{ $bahan->jumlah_dalam_negeri }}</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($bahan->nilai_dalam_negeri, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">{{ $bahan->jumlah_impor }}</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($bahan->nilai_impor, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2">{{ $bahan->negara_asal_impor }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button"
                                                    @click='openEditBahan(@json($bahan))'
                                                    class="bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="italic text-gray-500">Tidak ada data pemakaian bahan.</p>
                        @endif
                    </div>
                </div>

                <!-- MODAL PEMAKAIAN BAHAN -->
                <div x-show="openModalPemakaianBahan" x-transition.opacity
                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                    <div @click.away="closeModal" @keydown.escape.window="closeModal"
                        class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative ml-24">

                        <button @click="closeModal" type="button"
                            class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                            &times;
                        </button>

                        <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PEMAKAIAN BAHAN</h2>

                        <form :action="'{{ url('data-IKM/pemakaian-bahan/update') }}'" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="id" :value="formPemakaianBahan.id_pemakaian_bahan">

                            <div class="grid md:grid-cols-2 gap-6">
                                <template x-for="(label, name) in fieldMapBahan" :key="name">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                            x-text="label"></label>
                                        <input type="text" :name="name" x-model="formPemakaianBahan[name]"
                                            required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-center">
                                <button type="submit"
                                    class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Detail Penggunaan Bahan Bakar --}}
                <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                    <div class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold">Penggunaan Bahan
                        Bakar
                    </div>
                    <div class="p-4 overflow-x-auto">
                        @if ($ikm->penggunaanBahanBakar && $ikm->penggunaanBahanBakar->count())
                            <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                <thead class="bg-[#CAE2F6] text-[#083458]">
                                    <tr>
                                        <th class="px-4 py-2">Jenis Bahan Bakar</th>
                                        <th class="px-4 py-2">Satuan</th>
                                        <th class="px-4 py-2 text-right">Jumlah Proses Produksi</th>
                                        <th class="px-4 py-2 text-right">Nilai Proses Produksi (Rp)</th>
                                        <th class="px-4 py-2 text-right">Jumlah Pembangkit Tenaga Listrik</th>
                                        <th class="px-4 py-2 text-right">Nilai Pembangkit Tenaga Listrik (Rp)</th>
                                        <th class="px-4 py-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($ikm->penggunaanBahanBakar as $bahanBakar)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">
                                                {{ str_replace(['_', '-'], ' ', $bahanBakar->jenis_bahan_bakar) }}</td>
                                            <td class="px-4 py-2">{{ $bahanBakar->satuan_standar }}</td>
                                            <td class="px-4 py-2 text-right">{{ $bahanBakar->banyaknya_proses_produksi }}
                                            </td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($bahanBakar->nilai_proses_produksi, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-right">
                                                {{ $bahanBakar->banyaknya_pembangkit_tenaga_listrik }}</td>
                                            <td class="px-4 py-2 text-right">
                                                {{ number_format($bahanBakar->nilai_pembangkit_tenaga_listrik, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button"
                                                    @click='openEditBahanBakar(@json($bahanBakar))'
                                                    class="bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                                    Edit
                                                </button>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="italic text-gray-500">Tidak ada data penggunaan bahan bakar.</p>
                        @endif
                    </div>
                </div>
                <!-- OVERLAY MODAL -->
                <div x-show="openModalBahanBakar" x-transition.opacity
                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                    <!-- MODAL -->
                    <div @click.away="closeModal" @keydown.escape.window="closeModal"
                        class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative ml-24">

                        <button @click="closeModal" type="button"
                            class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                            &times;
                        </button>

                        <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT PENGGUNAAN BAHAN BAKAR</h2>

                        <form :action="'{{ url('data-IKM/bahan-bakar/update') }}'" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="id" :value="formBahanBakar.id_bahan_bakar">

                            <div class="grid md:grid-cols-2 gap-6">
                                <template x-for="(label, name) in fieldMapBahanBakar" :key="name">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                            x-text="label"></label>
                                        <input type="text" :name="name" x-model="formBahanBakar[name]"
                                            required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-center">
                                <button type="submit"
                                    class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Detail Mesin Produksi --}}
                <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                    <div class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold">
                        Mesin Produksi
                    </div>
                    <div class="p-4 overflow-x-auto">
                        @if ($ikm->mesinProduksi && $ikm->mesinProduksi->count())
                            <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                <thead class="bg-[#CAE2F6] text-[#083458]">
                                    <tr>
                                        <th class="px-4 py-2">Jenis</th>
                                        <th class="px-4 py-2">Nama Mesin</th>
                                        <th class="px-4 py-2">Merk/Type</th>
                                        <th class="px-4 py-2">Teknologi</th>
                                        <th class="px-4 py-2">Negara</th>
                                        <th class="px-4 py-2">Th. Perolehan</th>
                                        <th class="px-4 py-2">Th. Pembuatan</th>
                                        <th class="px-4 py-2 text-right">Jumlah</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($ikm->mesinProduksi as $mesin)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $mesin->jenis_mesin }}</td>
                                            <td class="px-4 py-2">{{ $mesin->nama_mesin }}</td>
                                            <td class="px-4 py-2">{{ $mesin->merk_type }}</td>
                                            <td class="px-4 py-2">{{ $mesin->teknologi }}</td>
                                            <td class="px-4 py-2">{{ $mesin->negara_pembuat }}</td>
                                            <td class="px-4 py-2">{{ $mesin->tahun_perolehan }}</td>
                                            <td class="px-4 py-2">{{ $mesin->tahun_pembuatan }}</td>
                                            <td class="px-4 py-2 text-right">{{ $mesin->jumlah_unit }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button"
                                                    @click='openEditMesin(@json($mesin))'
                                                    class="bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                                    Edit
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="italic text-gray-500">Tidak ada data mesin produksi.</p>
                        @endif
                    </div>
                </div>
                <!-- OVERLAY MODAL MESIN -->
                <div x-show="openModalMesin" x-transition.opacity
                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                    <div @click.away="closeModal" @keydown.escape.window="closeModal"
                        class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative ml-24">

                        <button @click="closeModal" type="button"
                            class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                            &times;
                        </button>

                        <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT MESIN PRODUKSI</h2>

                        <form :action="'{{ url('data-IKM/mesin-produksi/update') }}'" method="POST"
                            class="space-y-6">
                            @csrf
                            <input type="hidden" name="id" :value="formMesin.id_mesin">

                            <div class="grid md:grid-cols-2 gap-6">
                                <template x-for="(label, name) in fieldMapMesin" :key="name">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"
                                            x-text="label"></label>
                                        <input type="text" :name="name" x-model="formMesin[name]" required
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-sm transition">
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-center">
                                <button type="submit"
                                    class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Detail Modal --}}
                <div class="bg-white rounded-lg shadow border border-[#CAE2F6] md:w-full">
                    <div class="border-b px-4 py-2 bg-[#083458] text-[#CAE2F6] rounded-t font-semibold">Modal</div>
                    <div class="p-4 overflow-x-auto">
                        @if ($ikm->modal->count())
                            <table class="w-full text-sm border border-gray-200 rounded-md overflow-hidden">
                                <thead class="bg-[#CAE2F6] text-[#083458]">
                                    <tr>
                                        <th class="px-4 py-2">Jenis Barang Modal</th>
                                        <th class="px-4 py-2 text-right">Pembelian / Penambahan</th>
                                        <th class="px-4 py-2 text-right">Pengurangan</th>
                                        <th class="px-4 py-2 text-right">Penyusutan</th>
                                        <th class="px-4 py-2 text-right">Nilai Taksiran</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach ($ikm->modal as $modal)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ ucfirst($modal->jenis_barang) }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($modal->pembelian_penambahan_perbaikan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($modal->pengurangan_barang_modal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($modal->penyusutan_barang, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">Rp
                                                {{ number_format($modal->nilai_taksiran, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button"
                                                    @click='openEditModal(@json($modal))'
                                                    class="bg-[#F49F1E] hover:bg-[#e38c0f] text-white text-xs px-3 py-1 rounded-lg">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="italic text-gray-500">Tidak ada data modal.</p>
                        @endif
                    </div>
                </div>
                <!-- MODAL EDIT MODAL -->
                <div x-show="openModalModal" x-transition.opacity
                    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-40 flex justify-center items-center px-4 sm:justify-center">
                    <div @click.away="closeModal" @keydown.escape.window="closeModal"
                        class="bg-white rounded-xl shadow-xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto relative ml-24">

                        <button @click="closeModal" type="button"
                            class="absolute top-4 right-4 text-2xl font-bold leading-none hover:text-gray-700 focus:outline-none z-10">
                            &times;
                        </button>

                        <h2 class="text-xl font-bold text-center text-[#083458] mb-6">EDIT MODAL</h2>

                        <form :action="'{{ url('data-IKM/modal/update') }}'" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="id_modal" :value="formModal.id_modal">

                            {{-- Jenis Barang Modal --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Barang Modal</label>
                                <select name="jenis_barang" x-model="formModal.jenis_barang"
                                    class="w-full rounded-xl border px-4 py-2 text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="tanah">Tanah</option>
                                    <option value="gedung">Gedung</option>
                                    <option value="mesin dan perlengkapan">Mesin dan Perlengkapan</option>
                                    <option value="kendaraan">Kendaraan</option>
                                    <option value="software/database">Software/Database</option>
                                </select>
                            </div>

                            {{-- Pembelian / Penambahan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pembelian / Penambahan</label>
                                <input type="number" name="pembelian_penambahan_perbaikan"
                                    x-model="formModal.pembelian_penambahan_perbaikan"
                                    class="w-full rounded-xl border px-4 py-2 text-sm" required>
                            </div>

                            {{-- Pengurangan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pengurangan</label>
                                <input type="number" name="pengurangan_barang_modal"
                                    x-model="formModal.pengurangan_barang_modal"
                                    class="w-full rounded-xl border px-4 py-2 text-sm" required>
                            </div>

                            {{-- Penyusutan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Penyusutan</label>
                                <input type="number" name="penyusutan_barang" x-model="formModal.penyusutan_barang"
                                    class="w-full rounded-xl border px-4 py-2 text-sm" required>
                            </div>

                            {{-- Nilai Taksiran --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Taksiran</label>
                                <input type="number" name="nilai_taksiran" x-model="formModal.nilai_taksiran"
                                    class="w-full rounded-xl border px-4 py-2 text-sm" required>
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="flex justify-center pt-2">
                                <button type="submit"
                                    class="rounded-2xl bg-blue-500 px-8 py-3 text-white font-semibold shadow-md hover:shadow-lg transition duration-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function ikmModalEdit() {
            return {
                openModalIKM: false,
                openModalPengeluaran: false,
                openModalPersediaan: false,
                openModalTenagaKerja: false,
                openModalLimbah: false,
                openModalPendapatan: false,
                openModalProduksi: false,
                openModalListrik: false,
                openModalPemakaianBahan: false,
                openModalBahanBakar: false,
                openModalMesin: false,
                openModalAir: false,
                openModalPersentase: false,
                openModalModal: false,

                formIKM: {},
                formPengeluaran: {},
                formPersediaan: {},
                formTenagaKerja: {},
                formLimbah: {},
                formPendapatan: {},
                formProduksi: {},
                formListrik: {},
                formPemakaianBahan: {},
                formBahanBakar: {},
                formMesin: {},
                formAir: {},
                formPersentase: {},
                formModal: {},

                fieldMapBahan: {
                    nama_bahan: 'Nama Bahan',
                    jenis_bahan: 'Jenis',
                    spesifikasi: 'Spesifikasi',
                    kode_hs: 'Kode HS',
                    satuan_standar: 'Satuan',
                    jumlah_dalam_negeri: 'Jumlah DN',
                    nilai_dalam_negeri: 'Nilai DN',
                    jumlah_impor: 'Jumlah Impor',
                    nilai_impor: 'Nilai Impor',
                    negara_asal_impor: 'Negara Asal',
                },

                fieldMapBahanBakar: {
                    jenis_bahan_bakar: 'Jenis Bahan Bakar',
                    satuan_standar: 'Satuan',
                    banyaknya_proses_produksi: 'Jumlah Proses Produksi',
                    nilai_proses_produksi: 'Nilai Proses Produksi (Rp)',
                    banyaknya_pembangkit_tenaga_listrik: 'Jumlah Pembangkit Tenaga Listrik',
                    nilai_pembangkit_tenaga_listrik: 'Nilai Pembangkit Tenaga Listrik (Rp)',
                },

                fieldMapMesin: {
                    jenis_mesin: 'Jenis Mesin',
                    nama_mesin: 'Nama Mesin',
                    merk_type: 'Merk / Type',
                    teknologi: 'Teknologi',
                    negara_pembuat: 'Negara',
                    tahun_perolehan: 'Tahun Perolehan',
                    tahun_pembuatan: 'Tahun Pembuatan',
                    jumlah_unit: 'Jumlah',
                },

                fieldMapModal: {
                    jenis_barang: 'Jenis Barang Modal',
                    pembelian_penambahan_perbaikan: 'Pembelian / Penambahan',
                    pengurangan_barang_modal: 'Pengurangan',
                    penyusutan_barang: 'Penyusutan',
                    nilai_taksiran: 'Nilai Taksiran',
                },


                openIKM(data) {
                    this.closeModal();
                    this.formIKM = {
                        ...data
                    };
                    this.openModalIKM = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditPengeluaran(data) {
                    this.closeModal();
                    this.formPengeluaran = {
                        ...data
                    };
                    this.openModalPengeluaran = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditPersediaan(data) {
                    this.closeModal();
                    this.formPersediaan = {
                        ...data
                    };
                    this.openModalPersediaan = true;
                    document.body.style.overflow = 'hidden';
                },


                openEditTenagaKerja(data) {
                    this.closeModal();
                    this.formTenagaKerja = {
                        ...data
                    };
                    this.openModalTenagaKerja = true;
                    document.body.style.overflow = 'hidden';
                },


                openEditLimbah(data) {
                    this.closeModal();
                    this.formLimbah = {
                        ...data
                    };
                    this.openModalLimbah = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditPendapatan(data) {
                    this.closeModal();
                    this.formPendapatan = {
                        ...data
                    };
                    this.openModalPendapatan = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditProduksi(data) {
                    this.closeModal();
                    this.formProduksi = {
                        ...data
                    };
                    this.openModalProduksi = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditListrik(data) {
                    this.closeModal();
                    this.formListrik = {
                        ...data
                    };
                    this.openModalListrik = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditAir(data) {
                    this.closeModal();
                    this.formAir = {
                        ...data
                    };
                    this.openModalAir = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditBahan(data) {
                    this.closeModal();
                    this.formPemakaianBahan = {
                        ...data
                    };
                    this.openModalPemakaianBahan = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditBahanBakar(data) {
                    this.closeModal();
                    this.formBahanBakar = {
                        ...data
                    };
                    this.openModalBahanBakar = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditMesin(data) {
                    this.closeModal();
                    this.formMesin = {
                        ...data
                    };
                    this.openModalMesin = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditPersentase(data) {
                    this.closeModal();
                    this.formPersentase = {
                        ...data
                    };
                    this.openModalPersentase = true;
                    document.body.style.overflow = 'hidden';
                },

                openEditModal(data) {
                    this.closeModal();
                    this.formModal = {
                        ...data
                    };
                    this.openModalModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.openModalModal = false;
                    this.openModalProduksi = false;
                    this.openModalListrik = false;
                    this.openModalPemakaianBahan = false;
                    this.openModalBahanBakar = false;
                    this.openModalMesin = false;
                    this.openModalAir = false;
                    this.openModalPersentase = false;
                    this.openModalPendapatan = false;
                    this.openModalLimbah = false;
                    this.openModalTenagaKerja = false;
                    this.openModalPersediaan = false;
                    this.openModalPengeluaran = false;
                    this.openModalIKM = false;
                    document.body.style.overflow = 'auto';
                },

                init() {
                    document.body.style.overflow = 'auto';
                    this.$el.addEventListener('alpine:destroying', () => {
                        document.body.style.overflow = 'auto';
                    });
                }
            }
        }
    </script>
@endpush
