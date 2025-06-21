@extends('layouts.admin')

@section('content')
@php
use App\Helpers\StatusHelper;
@endphp
<div class="min-h-screen p-6 bg-gray-100">
    <!-- Header Background -->
    <div class="relative h-[150px] w-full bg-cover bg-[center_87%]" style="background-image: url('/assets/img/background/user_metrologi.png');">
        <!-- Floating Filter + Button -->
        <div class="absolute bottom-[-30px] w-full px-8">
            <div class="flex flex-col items-stretch justify-between gap-4 p-4 shadow-md md:flex-row md:items-center rounded-xl">
                <!-- Filter/Search Input -->
            <div class="flex flex-col flex-1 w-full gap-4 md:flex-row">
                <form id="filterForm" class="flex flex-col items-stretch w-full gap-4 md:flex-row md:items-center" method="GET">
                    <select name="status" id="statusFilter" class="w-full px-4 py-2 text-sm border rounded-full shadow md:w-auto" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="Valid" {{ request('status') === 'Valid' ? 'selected' : '' }}>Valid</option>
                        <option value="Kadaluarsa" {{ request('status') === 'Kadaluarsa' ? 'selected' : '' }}>{{ StatusHelper::formatStatus('Kadaluarsa') }}</option>
                    </select>
                    <div class="relative flex-1">
                        <input type="text" name="search" placeholder="Cari" value="{{ request('search') }}" class="w-full py-2 pl-10 pr-4 text-sm border rounded-full shadow">
                        <button type="submit" class="absolute top-0 right-0 h-full px-4 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Download Button -->
            <div class="w-full md:w-auto">
                <a href="{{ route('uttp.download') }}" class="w-full md:w-auto block text-center text-white flex items-center justify-center gap-2 bg-[#0c3252] transition-colors duration-300 hover:bg-[#F49F1E] hover:text-black rounded-full px-6 py-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup Review -->
    <div id="popupDetailAlat" class="fixed inset-0 z-50 items-center justify-center hidden bg-opacity-50">
        <div class="bg-white p-6 rounded-xl w-[450px] max-w-full relative shadow-xl">
            <button onclick="togglePopup(false)" class="absolute text-xl font-bold text-gray-500 top-2 right-3 hover:text-black">&times;</button>
            <h2 class="mb-4 text-lg font-bold text-center">
                Detail Alat Ukur - 
                <span id="popupNoReg" class="text-gray-600"></span>
            </h2>
            <table class="w-full text-sm">
                <tbody id="popupDetailBody"></tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Alat Ukur Sah -->
    <div class="mt-6 overflow-x-auto rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
            <thead class="bg-[#0c3252] text-white">
                <tr>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">No</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Jenis Alat</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Nomor Registrasi</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Nama Usaha</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Tanggal Tera</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Tanggal Exp</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Status</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alatUkur as $index => $data)
                <tr class="transition hover:bg-blue-50">
                    <td class="px-5 py-3 text-center border-b">{{ $index + 1 }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->jenis_alat }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->no_registrasi }}</td>
                    <td class="px-5 py-3 text-center border-b">{{ $data->uttp->nama_usaha }}</td>
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
                        <div class="flex justify-center">
                            <button class="flex space-x-2 text-black transition hover:text-gray-600" onclick="loadDetailAlat('{{ $data->uttp->id_uttp }}')">
                                        <!-- Icon Preview -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Preview</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $alatUkur->links('pagination::tailwind') }}
    </div>
</div>

<script>
    const statusFilter = document.getElementById("statusFilter");
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("tbody tr");

    function applyFilters() {
        const selectedStatus = statusFilter.value.toLowerCase();
        const keyword = searchInput.value.toLowerCase();

        rows.forEach(row => {
            if (!row.querySelector('td')) return;

            const statusCell = row.querySelector('td:nth-child(7)');
            const status = statusCell ? statusCell.textContent.trim().toLowerCase() : '';
            const rowText = row.textContent.toLowerCase();

            // Handle Kadaluarsa, Kadaluwarsa, and Kedaluwarsa in the filter
            const matchStatus = !selectedStatus || 
                (selectedStatus === 'kadaluarsa' && (status === 'kadaluarsa' || status === 'kadaluwarsa' || status === 'kedaluwarsa')) ||
                (selectedStatus === 'valid' && status === 'valid');
            const matchSearch = !keyword || rowText.includes(keyword);

            row.style.display = (matchStatus && matchSearch) ? '' : 'none';
        });
    }

    statusFilter.addEventListener("change", applyFilters);
    searchInput.addEventListener("input", applyFilters);
    applyFilters();

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

        fetch("{{ route('kabid.detail') }}", {
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
                <tr><td class="py-1 font-semibold">Nama Usaha</td><td>: ${data.nama_usaha ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Jenis Alat</td><td>: ${data.jenis_alat ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Merk / Tipe</td><td>: ${data.merk_type ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Kapasitas</td><td>: ${data.nama_alat ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Nomor Seri</td><td>: ${data.nomor_seri ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Alat Penguji</td><td>: ${data.alat_penguji ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Cap Tanda Tera</td><td>: ${data.ctt ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">No Surat Perintah Tugas</td><td>: ${data.spt_keperluan ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Tanggal Mulai</td><td>: ${data.tanggal_penginputan ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Tanggal Selesai</td><td>: ${data.tanggal_selesai ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Keterangan</td><td>: ${data.keterangan ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Sertifikat</td><td>: ${data.sertifikat_path ? `<a href="/storage/${data.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Sertifikat</a>` : '<span class="text-gray-500">Belum di upload oleh admin</span>'}</td></tr>
            `;

            togglePopup(true);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail alat');
        });
    }
</script>
@endsection 