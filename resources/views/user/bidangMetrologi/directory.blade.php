@extends('layouts.metrologi.pengguna')
@php use Illuminate\Support\Facades\Auth; use App\Helpers\StatusHelper; @endphp

@section('content')
	<!-- Filter -->
    <div class="w-full px-4 md:px-8 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            <div class="w-full md:w-auto flex flex-col md:flex-row gap-4">
                @if(request()->routeIs('alat.user'))
                    <select id="statusFilter" class="w-full md:w-auto px-4 py-2 rounded-lg border shadow text-sm">
                        <option value="">Semua Status</option>
                        <option value="kadaluarsa">{{ StatusHelper::formatStatus('Kadaluarsa') }}</option>
                        <option value="valid">Valid</option>
                    </select>
                @endif
                <div class="relative w-full">
                    <input type="text" id="searchInput" placeholder="Cari alat ukur..." class="w-full pl-10 pr-4 py-2 rounded-lg border shadow text-sm">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="w-full md:w-auto">
                @if(request()->routeIs('alat.user'))
                    <a href="{{ route('directory-metrologi') }}" class="w-full md:w-auto block text-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                        Alat Ukur Saya
                    </a>
                @else
                    <a href="{{ route('alat.user', Auth::guard('user')->id()) }}" class="w-full md:w-auto block text-center bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition duration-200">
                        Alat Ukur Saya
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Popup Review -->
    <div id="popupDetailAlat" class="fixed inset-0 z-50 hidden justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-xl w-[90%] max-w-[450px] relative shadow-xl mx-4">
            <button onclick="togglePopup(false)" class="absolute top-2 right-3 text-gray-500 hover:text-black text-xl font-bold">&times;</button>

            <h2 class="text-center font-bold text-lg mb-4">
                Detail Alat Ukur - 
                <span id="popupNoReg" class="text-gray-600"></span>
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody id="popupDetailBody"></tbody>
                </table>
            </div>
        </div>
    </div>

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
    </script>

    <!-- Tabel Alat Ukur -->
    <div class="w-full px-4 md:px-8">
        <div class="overflow-x-auto rounded-lg shadow-sm bg-white">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-[#1e3a8a] text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-medium text-center">No</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center">Jenis Alat</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center">Merk/Type</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center">Nomor Registrasi</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center hidden md:table-cell">Nama Usaha</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center hidden md:table-cell">Tanggal Tera</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center hidden md:table-cell">Expired</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center">Status</th>
                        <th scope="col" class="px-4 py-3 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($alatUkur->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center px-6 py-10 text-gray-500">
                                <div class="flex flex-col items-center space-y-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 64 64">
                                        <line x1="32" y1="4" x2="32" y2="50" stroke="black" stroke-width="2"/>
                                        <line x1="16" y1="20" x2="48" y2="20" stroke="black" stroke-width="2"/>
                                        <line x1="32" y1="10" x2="16" y2="20" stroke="black" stroke-width="2"/>
                                        <line x1="32" y1="10" x2="48" y2="20" stroke="black" stroke-width="2"/>
                                        <line x1="16" y1="20" x2="12" y2="30" stroke="black" stroke-width="2"/>
                                        <line x1="16" y1="20" x2="20" y2="30" stroke="black" stroke-width="2"/>
                                        <path d="M12,30 Q16,34 20,30" fill="none" stroke="black" stroke-width="2"/>
                                        <line x1="48" y1="20" x2="44" y2="30" stroke="black" stroke-width="2"/>
                                        <line x1="48" y1="20" x2="52" y2="30" stroke="black" stroke-width="2"/>
                                        <path d="M44,30 Q48,34 52,30" fill="none" stroke="black" stroke-width="2"/>
                                        <rect x="24" y="50" width="16" height="4" fill="black"/>
                                    </svg>
                                    <p class="text-lg font-semibold">Belum ada alat yang telah di tera dalam sistem</p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($alatUkur as $index => $alat)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-4 py-3 text-center border-b">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-center border-b">{{ $alat->uttp->jenis_alat ?? '-' }}</td>
                                <td class="px-4 py-3 text-center border-b">{{ $alat->uttp->merk_type ?? '-' }}</td>
                                <td class="px-4 py-3 text-center border-b">{{ $alat->uttp->no_registrasi ?? '-' }}</td>
                                <td class="px-4 py-3 text-center border-b hidden md:table-cell">{{ $alat->uttp->nama_usaha ?? '-' }}</td>
                                <td class="px-4 py-3 text-center border-b hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($alat->uttp->tanggal_selesai)->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-3 text-center border-b hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($alat->tanggal_exp)->format('d-m-Y') }}
                                </td>
                                <td class="px-4 py-3 text-center border-b">
                                    @php
                                        $status = \Carbon\Carbon::parse($alat->tanggal_exp)->isPast() ? StatusHelper::formatStatus('Kadaluarsa') : 'Valid';
                                        $statusClass = $status === 'Valid' ? 'bg-green-700' : 'bg-red-600';
                                    @endphp
                                    <span class="text-xs font-medium text-white px-4 py-1 {{ $statusClass }} rounded-full">{{ $status }}</span>
                                </td>
                                <td class="px-4 py-3 text-center border-b">
                                    <button class="flex items-center justify-center space-x-2 text-black hover:text-gray-600 transition mx-auto" onclick="loadDetailAlat('{{ $alat->uttp->id_uttp }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="hidden md:inline">Preview</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

<script>

    const statusFilter = document.getElementById("statusFilter");
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("tbody tr");

    function applyFilters() {
        const selectedStatus = statusFilter ? statusFilter.value.toLowerCase() : '';
        const keyword = searchInput.value.toLowerCase();

        rows.forEach(row => {
            if (!row.querySelector('td')) return;

            const statusCell = row.querySelector('td:nth-child(8)');
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

    if (statusFilter) {
        statusFilter.addEventListener("change", applyFilters);
    }
    searchInput.addEventListener("input", applyFilters);
    applyFilters();

    function loadDetailAlat(id) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('alat.detail.user') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (!data) {
                throw new Error('No data received');
            }

            document.getElementById('popupNoReg').textContent = data.no_registrasi ?? '-';

            const body = document.getElementById('popupDetailBody');
            body.innerHTML = `
                <tr><td class="py-1 font-semibold">Nama Usaha</td><td>: ${data.nama_usaha ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Jenis Alat</td><td>: ${data.jenis_alat ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Merk / Tipe</td><td>: ${data.merk_type ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Kapasitas</td><td>: ${data.nama_alat ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Nomor Seri</td><td>: ${data.nomor_seri ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Cap Tanda Tera</td><td>: ${data.ctt ?? '-'}</td></tr>  
                <tr><td class="py-1 font-semibold">Keterangan</td><td>: ${data.keterangan ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Status</td><td>: ${data.status ?? '-'}</td></tr>
                <tr><td class="py-1 font-semibold">Tanggal Selesai</td><td>: ${formatDateDMY(data.tanggal_selesai)}</td></tr>
                <tr><td class="py-1 font-semibold">Tanggal Expired</td><td>: ${formatDateDMY(data.tanggal_exp)}</td></tr>
                <tr><td class="py-1 font-semibold">Sertifikat</td><td>: ${data.sertifikat_path ? `<a href="/storage/${data.sertifikat_path}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat Sertifikat</a>` : '<span class="text-gray-500">Belum di upload oleh admin</span>'}</td></tr>
            `;

            togglePopup(true);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengambil data. Silakan coba lagi.');
        });
    }
    function formatDateDMY(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

</script>
@endsection