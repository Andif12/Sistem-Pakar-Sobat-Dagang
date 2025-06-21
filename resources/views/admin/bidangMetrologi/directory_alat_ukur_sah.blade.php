@extends('layouts.metrologi.admin')
@section('title', "Admin Bidang Metrologi")
@section('content')

@php
use App\Helpers\StatusHelper;
@endphp

<div class="w-full bg-cover bg-[center_87%]" style="background-image: url('/assets/img/background/user_metrologi.png');">
    <div class="h-[150px]"></div>
</div>
<div class="min-h-screen p-6 bg-gray-100">
    <!-- Floating Filter Section (sekarang relatif, bukan absolute) -->
    <div class="w-full px-4 sm:px-6 md:px-8 mt-[-60px]">
        <div class="flex flex-col justify-between gap-4 p-4 shadow-md lg:flex-row lg:items-center rounded-xl bg-[#0c3252]">
            <!-- Filter Form -->
            <form action="{{ route('management-uttp-metrologi') }}" method="GET"
                class="flex flex-col flex-1 w-full gap-3 md:flex-row md:items-center md:gap-4">
                <select name="status" id="statusFilter"
                    class="w-full px-4 py-2 text-sm border rounded-full shadow md:w-auto bg-white text-gray-700"
                    onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="Valid" {{ request('status') === 'Valid' ? 'selected' : '' }}>Valid</option>
                    <option value="Kadaluarsa" {{ request('status') === 'Kadaluarsa' ? 'selected' : '' }}>{{ StatusHelper::formatStatus('Kadaluarsa') }}</option>
                </select>

                <div class="relative flex-1">
                    <input type="text" name="search" placeholder="Cari" value="{{ request('search') }}"
                        class="w-full py-2 pl-10 pr-4 text-sm border rounded-full shadow bg-white text-gray-700" />
                    <button type="submit"
                        class="absolute top-0 right-0 h-full px-4 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Button Group -->
            <div class="flex flex-col justify-end w-full gap-3 sm:flex-row sm:w-auto">
                <a href="{{ route('uttp.download') }}"
                    class="text-[#0c3252] flex items-center justify-center gap-2 bg-white border border-[#0c3252] hover:bg-[#0c3252] hover:text-white rounded-full px-6 py-2 text-sm transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </a>
                <button onclick="openModal()"
                    class="text-[#0c3252] flex items-center justify-center gap-2 bg-white border border-[#0c3252] hover:bg-[#0c3252] hover:text-white rounded-full px-8 py-2 text-sm transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah UTTP
                </button>
            </div>
        </div>
    </div>



    <!-- Modal Popup Review -->
    <div id="popupDetailAlat" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-26 bg-black bg-opacity-50 sm:justify-center">
        <div class="bg-white p-4 sm:p-6 rounded-xl w-[90%] sm:w-[85%] md:w-[70%] lg:w-[50%] max-w-[600px] relative shadow-xl mx-auto ml-[calc(16.666667%+1rem)] sm:ml-[calc(16.666667%+2rem)] mr-[calc(1%+1rem)] sm:mr-[calc(1%+2rem)]">
            <button onclick="togglePopup(false)" class="absolute text-xl font-bold text-gray-500 top-2 right-3 hover:text-black">&times;</button>
            <h2 class="mb-4 text-base font-bold text-center sm:text-lg">
                Detail Alat Ukur - 
                <span id="popupNoReg" class="text-gray-600"></span>
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <tbody id="popupDetailBody" class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Alat Ukur -->
    <div id="modalTambahAlat" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-26 bg-black bg-opacity-50 sm:justify-center">
        <div class="fixed inset-0 bg-black bg-opacity-30"></div>
        <div class="relative bg-white w-[90%] sm:w-[90%] md:w-[80%] lg:w-[70%] xl:w-[60%] rounded-lg shadow-lg p-4 sm:p-6 my-4 sm:my-8 max-h-[90vh] overflow-y-auto mx-auto ml-[calc(16.666667%+1rem)] sm:ml-[calc(16.666667%+2rem)] mr-[calc(1%+1rem)] sm:mr-[calc(1%+2rem)]">
            <div class="flex items-center justify-between pb-3 mb-4 border-b">
                <h2 class="text-base font-semibold sm:text-lg">Tambah UTTP</h2>
                <button onclick="tutupModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>

            <form id="form-alat" method="POST" action="{{ route('store-uttp') }}" onsubmit="handleSubmit(event)">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 sm:gap-4">
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_penginputan" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">NIB User</label>
                        <select name="id_user" id="userSelect" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" style="height: 38px;">
                            <option value="">Pilih User</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Kosongkan bila pemilik uttp tidak terdaftar pada sistem</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">No Registrasi <span class="text-red-500">*</span></label>
                        <input type="text" name="no_registrasi" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Nama Usaha <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_usaha" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Jenis Alat <span class="text-red-500">*</span></label>
                        <select id="jenis_alat" name="jenis_alat" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                            <option value="" class="text-gray-400" selected>Pilih Jenis Alat</option>
                            <option value="UP-MK">UP-MK</option>
                            <option value="VOL-TK">VOLUME - TK</option>
                            <option value="VOL-TUTSIT">VOLUME - TUTSIT</option>
                            <option value="VOL-TUM">VOLUME - TUM</option>
                            <option value="VOL-PUBBM">VOLUME - PUBBM</option>
                            <option value="VOL-MA">VOLUME - MA</option>
                            <option value="VOL-DLL">VOLUME - Lainnya</option>
                            <option value="MAS-DL">MASSA - DL</option>
                            <option value="MAS-TP">MASSA - TP</option>
                            <option value="MAS-TM">MASSA - TM</option>
                            <option value="MAS-TS">MASSA - TS</option>
                            <option value="MAS-NE">MASSA - NE</option>
                            <option value="MAS-ATB">MASSA - ATB</option>
                            <option value="MAS-ATH">MASSA - ATH</option>
                            <option value="MAS-TE">MASSA - TE</option>
                            <option value="MAS-TJE">MASSA - TJE</option>
                            <option value="MAS-DLL">MASSA - Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Merk / Type</label>
                        <input type="text" name="merk_type" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Kapasitas</label>
                        <input type="text" name="nama_alat" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Nomor Seri</label>
                        <input type="text" name="nomor_seri" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Alat Penguji <span class="text-red-500">*</span></label>
                        <select id="alat_penguji" name="alat_penguji" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                            <option value="" class="text-gray-400" selected>Pilih Alat Penguji</option>
                            <option value="BUS">BUS</option>
                            <option value="AT">AT</option>
                            <option value="ATB">ATB</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Cap Tanda Tera <span class="text-red-500">*</span></label>
                        <select id="ctt" name="ctt" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                            <option value="" class="text-gray-400" selected>Pilih Cap Tanda Tera</option>
                            <option value="SL6">SL6</option>
                            <option value="SL4">SL4</option>
                            <option value="SL2">SL2</option>
                            <option value="SK6">SK6</option>
                            <option value="SP6">SP6</option>
                            <option value="B4">B4</option>
                            <option value="J8">J8</option>
                            <option value="J5">J5</option>
                            <option value="J4">J4</option>
                            <option value="JP8">JP8</option>
                            <option value="D4">D4</option>
                            <option value="H">H</option>
                            <option value="HP">HP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">No Surat Perintah Tugas</label>
                        <input type="text" name="spt_keperluan" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Keterangan <span class="text-red-500">*</span></label>
                        <select id="keterangan" name="keterangan" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm" required>
                            <option value="" class="text-gray-400" selected>Pilih Keterangan</option>
                            <option value="Tera">Tera</option>
                            <option value="Tera Ulang">Tera Ulang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium sm:text-sm">Sertifikat (PDF)</label>
                        <input type="file" name="sertifikat" accept=".pdf" class="w-full border rounded px-2 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm">
                    </div>
                    <div class="flex items-center mt-2 space-x-2">
                        <input type="checkbox" name="terapan" id="terapan" class="border-gray-300 rounded">
                        <label for="terapan" class="text-xs font-medium sm:text-sm">Cerapan</label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="tutupModal()" class="bg-gray-200 px-3 sm:px-4 py-1.5 sm:py-2 rounded hover:bg-gray-300 text-xs sm:text-sm">Batal</button>
                    <button type="submit" class="bg-[#0c3252] text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded hover:bg-[#0a2942] text-xs sm:text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tabel Alat Ukur Sah -->
    <div class="mt-6 overflow-x-auto rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
            <thead class="bg-[#0c3252] text-white">
                <tr>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">No</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Nomor Registrasi</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Nama Usaha</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Jenis Alat</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Tanggal Tera</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Tanggal Exp</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Status</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alatUkur as $index => $data)
                <tr class="transition hover:bg-blue-50">
                    <td class="px-5 py-3 text-center border-b">{{ $alatUkur->firstItem() + $index }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->no_registrasi }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->nama_usaha }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->jenis_alat }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ \Carbon\Carbon::parse($data->uttp->tanggal_penginputan)->format('d F Y') }}</td>
                    <td class="px-5 py-3 text-center border-b">
                        {{ optional($data)->tanggal_exp ? \Carbon\Carbon::parse($data->tanggal_exp)->format('d F Y') : '-' }}
                    </td>
                    <td class="px-5 py-3 text-center border-b">
                        <span class="
                            font-semibold
                            {{ $data->status === 'Valid' ? 'text-green-600' : ($data->status === 'Kadaluarsa' ? 'text-red-600' : 'text-gray-500') }}">
                            {{ $data->status === 'Valid' ? 'Valid' : StatusHelper::formatStatus($data->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center border-b">
                        <div class="flex justify-center space-x-2">
                            <!-- Tombol Preview -->
                            <button class="flex items-center p-2 space-x-1 text-black transition duration-200 rounded hover:text-gray-600 hover:bg-blue-100" onclick="loadDetailAlat('{{ $data->uttp->id_uttp }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>

                            <!-- Tombol Edit -->
                            <button
                                onclick="openEditModal({{ $data->uttp }}, '{{ route('update-uttp', $data->uttp->id_uttp) }}')"
                                class="p-2 transition duration-200 rounded hover:bg-blue-100"
                                title="Edit">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6">
        {{ $alatUkur->links('pagination::tailwind') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function togglePopup(show) {
        const modal = document.getElementById('popupDetailAlat');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function loadDetailAlat(id) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('uttp.detail.post') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('popupNoReg').textContent = data.no_registrasi ?? '-';

            const body = document.getElementById('popupDetailBody');
            body.innerHTML = `
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Nama Usaha</td><td class="px-2 py-2 sm:px-4">: ${data.nama_usaha ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Jenis Alat</td><td class="px-2 py-2 sm:px-4">: ${data.jenis_alat ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Merk / Tipe</td><td class="px-2 py-2 sm:px-4">: ${data.merk_type ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Kapasitas</td><td class="px-2 py-2 sm:px-4">: ${data.nama_alat ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Nomor Seri</td><td class="px-2 py-2 sm:px-4">: ${data.nomor_seri ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Alat Penguji</td><td class="px-2 py-2 sm:px-4">: ${data.alat_penguji ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Cap Tanda Tera</td><td class="px-2 py-2 sm:px-4">: ${data.ctt ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">No Surat Perintah Tugas</td><td class="px-2 py-2 sm:px-4">: ${data.spt_keperluan ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Tanggal Mulai</td><td class="px-2 py-2 sm:px-4">: ${data.tanggal_penginputan ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Tanggal Selesai</td><td class="px-2 py-2 sm:px-4">: ${data.tanggal_selesai ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Keterangan</td><td class="px-2 py-2 sm:px-4">: ${data.keterangan ?? '-'}</td></tr>
                <tr class="hover:bg-gray-50"><td class="px-2 py-2 font-semibold sm:px-4">Sertifikat</td><td class="px-2 py-2 sm:px-4">: ${data.sertifikat_path ? `<a href="/storage/${data.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Sertifikat</a>` : '<span class="text-gray-500">Belum di upload oleh admin</span>'}</td></tr>
            `;

            togglePopup(true);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail alat');
        });
    }

    function handleSubmit(event) {
        event.preventDefault();
        const form = event.target;
        
        // Validasi ukuran file sertifikat
        const sertifikatInput = form.querySelector('[name="sertifikat"]');
        if (sertifikatInput.files.length > 0) {
            const maxSize = 10 * 1024 * 1024; // 10MB in bytes
            if (sertifikatInput.files[0].size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Ukuran file maksimal adalah 10MB. Silakan pilih file yang lebih kecil.',
                    confirmButtonText: 'OK'
                });
                return;
            }
        }

        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyimpan data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0c3252',
            cancelButtonColor: '#6B7280'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus pesan error yang ada
                const errorMessages = form.querySelectorAll('.error-message');
                errorMessages.forEach(el => el.remove());
                
                // Submit form menggunakan fetch
                fetch(form.action, {
                    method: form.method,
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('management-uttp-metrologi') }}";
                        });
                    } else {
                        // Tampilkan pesan error untuk setiap field
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const input = form.querySelector(`[name="${field}"]`);
                                if (input) {
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                                    errorDiv.textContent = data.errors[field][0];
                                    input.parentNode.appendChild(errorDiv);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Terjadi kesalahan saat menyimpan data',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    }

    function openModal(){
        document.getElementById('modalTambahAlat').classList.remove('hidden');

        // Reset Form
        const form = document.getElementById('form-alat');
        form.reset();
        form.action = "{{ route('store-uttp') }}";
        document.getElementById('formMethod').value = "POST";
        
        // Enable user select when opening manually
        $('#userSelect').prop('disabled', false);
    }

    function tutupModal() {
        // Konfirmasi sebelum menutup modal jika ada perubahan
        const form = document.getElementById('form-alat');
        const formData = new FormData(form);
        let hasChanges = false;

        // Cek apakah ada perubahan pada form
        for (let [key, value] of formData.entries()) {
            if (key !== 'sertifikat' && value !== '') {
                hasChanges = true;
                break;
            }
        }

        if (hasChanges) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menutup form? Perubahan yang belum disimpan akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tutup',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0c3252',
                cancelButtonColor: '#6B7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    closeModalAndReset();
                }
            });
        } else {
            closeModalAndReset();
        }
    }

    function closeModalAndReset() {
        document.getElementById('modalTambahAlat').classList.add('hidden');
        
        // Reset form
        const form = document.getElementById('form-alat');
        form.reset();
        
        // Hapus semua pesan error
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());
        
        // Hapus tampilan sertifikat yang ada
        const sertifikatContainer = form.querySelector('[name="sertifikat"]').parentElement;
        const existingFile = sertifikatContainer.querySelector('.mt-2');
        if (existingFile) {
            existingFile.remove();
        }
    }

    function openEditModal(data, updateRoute) {
        document.getElementById('modalTambahAlat').classList.remove('hidden');
        const form = document.getElementById('form-alat');

        // Ganti action dan method
        form.action = updateRoute;
        document.getElementById('formMethod').value = "PATCH";

        // Hapus pesan error yang ada
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(el => el.remove());

        // Hapus tampilan sertifikat yang ada sebelum menambahkan yang baru
        const sertifikatContainer = form.querySelector('[name="sertifikat"]').parentElement;
        const existingFile = sertifikatContainer.querySelector('.mt-2');
        if (existingFile) {
            existingFile.remove();
        }

        // Assign field manual
        form.elements['tanggal_penginputan'].value = data.tanggal_penginputan || '';
        form.elements['no_registrasi'].value = data.no_registrasi || '';
        form.elements['nama_usaha'].value = data.nama_usaha || '';
        form.elements['jenis_alat'].value = data.jenis_alat || '';
        form.elements['nama_alat'].value = data.nama_alat || '';
        form.elements['merk_type'].value = data.merk_type || '';
        form.elements['nomor_seri'].value = data.nomor_seri || '';
        form.elements['alat_penguji'].value = data.alat_penguji || '';
        form.elements['ctt'].value = data.ctt || '';
        form.elements['spt_keperluan'].value = data.spt_keperluan || '';
        form.elements['tanggal_selesai'].value = data.tanggal_selesai || '';
        form.elements['terapan'].checked = data.terapan || false;
        form.elements['keterangan'].value = data.keterangan || '';

        // Handle user selection
        if (data.id_user) {
            // Fetch user data and set it in Select2
            fetch(`/admin/users/search?search=${data.id_user}`)
                .then(response => response.json())
                .then(users => {
                    if (users.length > 0) {
                        const user = users[0];
                        const option = new Option(user.text, user.id, true, true);
                        $('#userSelect').append(option).trigger('change');
                    }
                })
                .catch(error => console.error('Error loading user:', error));
        } else {
            $('#userSelect').val(null).trigger('change');
        }

        // Tampilkan file sertifikat yang sudah ada
        if (data.sertifikat_path) {
            const existingFile = document.createElement('div');
            existingFile.className = 'mt-2 text-sm text-gray-600';
            existingFile.innerHTML = `
                <p>File saat ini: <a href="/storage/${data.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Sertifikat</a></p>
                <p class="mt-1 text-xs text-gray-500">Upload file baru untuk mengganti sertifikat</p>
            `;
            sertifikatContainer.appendChild(existingFile);
        }
    }

    // Script untuk membuka modal otomatis dan mengisi field
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const autoOpen = urlParams.get('auto_open');
        const userId = urlParams.get('user_id');
        const jenisPermohonan = urlParams.get('jenis_permohonan');
        const fromPersuratan = urlParams.get('from_persuratan');

        if (autoOpen === 'true') {
            const modal = document.getElementById('modalTambahAlat');
            modal.classList.remove('hidden');
            
            const form = document.getElementById('form-alat');
            form.reset();
            document.getElementById('formMethod').value = "POST";
            
            if (userId) {
                // Jika dari persuratan, set user dan disable select
                if (fromPersuratan === 'true') {
                    fetch(`/admin/users/search?search=${userId}`)
                        .then(response => response.json())
                        .then(users => {
                            if (users.length > 0) {
                                const user = users[0];
                                const option = new Option(user.text, user.id, true, true);
                                $('#userSelect').append(option).trigger('change');
                                $('#userSelect').prop('disabled', true);
                            }
                        })
                        .catch(error => console.error('Error loading user:', error));
                } else {
                    // Jika bukan dari persuratan, set user tapi tetap bisa diubah
                    fetch(`/admin/users/search?search=${userId}`)
                        .then(response => response.json())
                        .then(users => {
                            if (users.length > 0) {
                                const user = users[0];
                                const option = new Option(user.text, user.id, true, true);
                                $('#userSelect').append(option).trigger('change');
                            }
                        })
                        .catch(error => console.error('Error loading user:', error));
                }
            }

            if (jenisPermohonan) {
                // Jika jenis permohonan mengandung kata "tera_ulang", set ke "Tera Ulang"
                if (jenisPermohonan.toLowerCase().includes('tera_ulang')) {
                    form.elements['keterangan'].value = 'Tera Ulang';
                } else {
                    form.elements['keterangan'].value = 'Tera';
                }
            }
        }
    });

    $(document).ready(function() {
        $('#userSelect').select2({
            placeholder: 'Cari user...',
            allowClear: true,
            dropdownParent: $('#modalTambahAlat'),
            width: '100%',
            minimumResultsForSearch: 0,
            language: {
                inputTooShort: function() {
                    return 'Ketik NIB atau Nama User untuk mencari...';
                },
                searching: function() {
                    return 'Mencari User...';
                },
                noResults: function() {
                    return 'User tidak ditemukan';
                }
            },
            ajax: {
                url: '{{ route("search-users") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        }).on('select2:open', function() {
            // Adjust dropdown position
            setTimeout(function() {
                $('.select2-container--open').css('z-index', 9999);
            }, 0);
        });
    });
</script>

<style>
    /* Select2 Styling */
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6b7280;
    }
</style>

@endsection