@extends('layouts.admin')

@section('content')
<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen p-6 bg-gray-100">
    <div class="h-[150px] md:h-[200px] w-full bg-cover bg-[center_87%]" style="background-image: url('/assets/img/background/user_metrologi.png');">
    </div>

    <!-- Kartu Statistik -->
    <div class="relative z-10 grid grid-cols-1 gap-4 px-4 mb-6 -mt-10 md:-mt-16 md:px-8 sm:grid-cols-2 md:grid-cols-4">
        <a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-5 flex items-center space-x-4">
            <img src="{{ asset('assets/img/icon/folder-download.png') }}" alt="Surat Masuk" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-white">Jumlah Surat Masuk</p>
                <p class="text-2xl font-bold text-white">{{ $totalSuratMasuk }}</p>
            </div>
        </a>

        <a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-5 flex items-center space-x-4">
            <img src="{{ asset('assets/img/icon/Verif.png') }}" alt="Terverifikasi" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-white">Jumlah Surat Disetujui</p>
                <p class="text-2xl font-bold text-white">{{ $totalSuratDiterima }}</p>
            </div>
        </a>

        <a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-5 flex items-center space-x-4">
            <img src="{{ asset('assets/img/icon/surat_ditolak.png') }}" alt="Ditolak" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-white">Jumlah Surat Ditolak</p>
                <p class="text-2xl font-bold text-white">{{ $totalSuratDitolak }}</p>
            </div>
        </a>

        <a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-5 flex items-center space-x-4">
            <img src="{{ asset('assets/img/icon/draf.png') }}" alt="Draft" class="w-12 h-12">
            <div>
                <p class="text-base font-medium text-white">Surat Menunggu</p>
                <p class="text-2xl font-bold text-white">{{ $totalSuratMenungguKabid }}</p>
            </div>
        </a>
    </div>

    
    @include('component.popup_surat')


    <div class="flex flex-wrap items-center justify-between px-4 mt-10">
        <div class="w-full">
            <form id="filterForm" method="GET" class="flex items-center space-x-4">
                <select name="status" id="statusFilter" class="px-4 py-2 text-sm border rounded-full shadow" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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
    </div>

    <!-- Tabel Riwayat -->
    <div class="mt-5 overflow-x-auto rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
            <thead class="bg-[#0c3252] text-white">
                <tr>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">No</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">No Surat</th>
                    <th scope="col" class="px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5">Tanggal Surat</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Nama Pemohon</th>
                    <th scope="col" class="hidden px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5 md:table-cell">Jenis Permohonan</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Status</th>
                    <th scope="col" class="px-5 py-3 font-medium text-center border-b border-blue-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratList->filter(fn($s) => $s->suratBalasan) as $index => $surat)
				<tr class="hover:bg-blue-50 transition data-status='{{ $surat->suratBalasan->status_kepalaBidang }}'">
					<td class="px-5 py-3 text-center border-b">{{ $index + 1 }}</td>
					<td class="px-5 py-3 text-center border-b">{{ $surat->id_surat }}</td>
                    <td class="px-3 py-3 text-center border-b sm:px-5">
						{{ \Carbon\Carbon::parse($surat->created_at)->format('d-m-Y') }}
					</td>
					<td class="px-5 py-3 text-center border-b">{{ $surat->user->nama ?? '-' }}</td>
                    <td class="hidden px-3 py-3 text-center border-b sm:px-5 md:table-cell">
						{{ $surat->jenis_surat ? ucwords(str_replace('_', ' ', $surat->jenis_surat)) : '-' }}
					</td>
					<td class="px-5 py-3 text-center border-b">
						<span class="text-xs font-medium px-2 py-1 rounded-full 
							{{ $surat->suratBalasan->status_kepalaBidang == 'Menunggu' ? 'text-yellow-700 bg-yellow-100' : '' }}
							{{ $surat->suratBalasan->status_kepalaBidang == 'Disetujui' ? 'text-green-700 bg-green-100' : '' }}
							{{ $surat->suratBalasan->status_kepalaBidang == 'Ditolak' ? 'text-red-700 bg-red-100' : '' }}">
							{{ $surat->suratBalasan->status_kepalaBidang }}
						</span>
					</td>
					<td class="px-5 py-3 text-center border-b">
                        <div class="flex flex-wrap justify-center gap-2">
                            @if ($surat->suratBalasan->status_kepalaBidang === 'Menunggu')
                                <button onclick="confirmAction('terima', '{{ base64_encode($surat->suratBalasan->id_surat_balasan) }}')" 
                                    class="bg-[#0c3252] hover:bg-[#0a2942] text-white text-sm px-4 py-1 rounded">
                                    Terima
                                </button>
                                <button onclick="confirmAction('tolak', '{{ base64_encode($surat->suratBalasan->id_surat_balasan) }}')" 
                                    class="bg-white hover:bg-gray-100 text-[#0c3252] border border-[#0c3252] text-sm px-4 py-1 rounded">
                                    Tolak
                                </button>
                            @endif

                            <!-- TOMBOL PREVIEW -->
                            <button onclick="toggleModal(true, '{{ asset('storage/' . $surat->suratBalasan->path_dokumen) }}', '{{ $surat->status }}')"
                                class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Surat Keluar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                </svg>
                            </button>
                        </div>
                    </td>


				</tr>
				@empty
				<tr>
					<td colspan="5" class="py-4 text-center text-gray-500">
						Tidak ada data surat metrologi yang tersedia.
					</td>
				</tr>
				@endforelse

            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $suratList->links('pagination::tailwind') }}
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("tbody tr");

    function applySearch() {
        const keyword = searchInput.value.toLowerCase();

        rows.forEach(row => {
            if (!row.querySelector('td')) return;
            const rowText = row.textContent.toLowerCase();
            const matchSearch = !keyword || rowText.includes(keyword);
            row.style.display = matchSearch ? '' : 'none';
        });
    }

    searchInput.addEventListener("input", applySearch);
    applySearch();
});

function confirmAction(action, id) {
    let message = '';
    let confirmButtonText = '';
    let confirmButtonClass = '';
    let routeUrl = '';

    switch(action) {
        case 'terima':
            message = 'Apakah Anda yakin ingin menerima surat ini?';
            confirmButtonText = 'Ya, Terima';
            confirmButtonClass = '#0c3252';
            routeUrl = '{{ route("terimaKabid", "") }}';
            break;
        case 'tolak':
            message = 'Apakah Anda yakin ingin menolak surat ini?';
            confirmButtonText = 'Ya, Tolak';
            confirmButtonClass = '#0c3252';
            routeUrl = '{{ route("tolakKabid", "") }}';
            break;
        default:
            return;
    }

    Swal.fire({
        title: 'Konfirmasi',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0c3252',
        cancelButtonColor: '#6B7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Untuk aksi terima dan tolak
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `${routeUrl}/${id}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@endsection
