@extends('layouts.metrologi.admin')
@section('title', "Admin Bidang Metrologi")
@section('content')
<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="p-4 sm:p-6 bg-gray-100 min-h-screen">
	<!-- Header Background -->
	<div class="relative h-[120px] sm:h-[150px] w-full bg-cover bg-[center_87%]" style="background-image: url('/assets/img/background/user_metrologi.png');">
		<!-- Stats Cards - Hidden on mobile and tablet, shown on desktop -->
		<div class="hidden lg:block w-full px-4 sm:px-8 relative lg:absolute lg:bottom-[-30px]">
			<div class="grid grid-cols-4 gap-4 mb-2">
				<!-- Card 1 -->
				<a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-4 flex items-center space-x-3">
					<img src="{{ asset('assets/img/icon/folder-download.png') }}" alt="Surat Masuk" class="w-12 h-12 flex-shrink-0">
					<div class="min-w-0 flex-1">
						<p class="text-base font-medium text-white truncate">Jumlah Surat Masuk</p>
						<p class="text-2xl font-bold text-white">{{ $dataSuratAdmin['totalSuratMasuk'] }}</p>
					</div>
				</a>

				<!-- Card 2 -->
				<a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-4 flex items-center space-x-3">
					<img src="{{ asset('assets/img/icon/Verif.png') }}" alt="Disetujui" class="w-12 h-12 flex-shrink-0">
					<div class="min-w-0 flex-1">
						<p class="text-base font-medium text-white truncate">Jumlah Surat Disetujui</p>
						<p class="text-2xl font-bold text-white">{{ $dataSuratAdmin['totalSuratMasukDisetujui'] }}</p>
					</div>
				</a>

				<!-- Card 3 -->
				<a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-4 flex items-center space-x-3">
					<img src="{{ asset('assets/img/icon/surat_ditolak.png') }}" alt="Ditolak" class="w-12 h-12 flex-shrink-0">
					<div class="min-w-0 flex-1">
						<p class="text-base font-medium text-white truncate">Jumlah Surat Ditolak</p>
						<p class="text-2xl font-bold text-white">{{ $dataSuratAdmin['totalSuratDitolak'] }}</p>
					</div>
				</a>

				<!-- Card 4 -->
				<a href="#" class="bg-[#0c3252] rounded-2xl shadow-md hover:shadow-lg transition p-4 flex items-center space-x-3">
					<img src="{{ asset('assets/img/icon/draf.png') }}" alt="Draft" class="w-12 h-12 flex-shrink-0">
					<div class="min-w-0 flex-1">
						<p class="text-base font-medium text-white truncate">Jumlah Surat Menunggu</p>
						<p class="text-2xl font-bold text-white">{{ $dataSuratAdmin['totalSuratMenunggu'] }}</p>
					</div>
				</a>
			</div>
		</div>
	</div>

	@include('component.popup_surat')
	
	<!-- Filter dan Pencarian -->
	<div class="mt-8 sm:mt-10 px-4">
		<form id="filterForm" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
			<select name="status" id="statusFilter" class="px-4 py-2 rounded-full border shadow text-sm bg-white" onchange="this.form.submit()">
				<option value="">Semua</option>
				<option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
				<option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
				<option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
				<option value="Menunggu Persetujuan" {{ request('status') === 'Menunggu Persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
				<option value="Butuh Revisi" {{ request('status') === 'Butuh Revisi' ? 'selected' : '' }}>Butuh Revisi</option>
				<option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
				<option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
			</select>
			<div class="relative flex-1">
				<input type="text" name="search" placeholder="Cari" value="{{ request('search') }}" class="pl-10 pr-4 py-2 rounded-full border shadow text-sm w-full bg-white">
				<button type="submit" class="absolute right-0 top-0 h-full px-4 text-gray-400 hover:text-gray-600">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
					</svg>
				</button>
			</div>
		</form>
	</div>

	<!-- Tabel Riwayat -->
	<div class="mt-4 px-4">
		<div class="overflow-x-auto rounded-lg shadow-sm">
			<table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
				<thead class="bg-[#0c3252] text-white">
					<tr>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">No</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">No Surat</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">Tanggal</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">NIB</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">Titik Koordinat</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">Pemohon</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center hidden md:table-cell">Jenis</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">Status</th>
						<th scope="col" class="px-3 py-2 sm:px-4 sm:py-3 font-medium border-b border-blue-100 text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($suratList as $index => $surat)
					<tr class="hover:bg-blue-50 transition">
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">{{ $index + 1 }}</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">{{ $surat->id_surat }}</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">
							{{ \Carbon\Carbon::parse($surat->created_at)->format('d-m-Y') }}
						</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">{{ $surat->user->nib ?? '-' }}</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">{{ $surat->alamat_alat ?? '-' }}</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">{{ $surat->user->nama ?? '-' }}</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center hidden md:table-cell">
							{{ $surat->jenis_surat ? ucwords(str_replace('_', ' ', $surat->jenis_surat)) : '-' }}
						</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">
							<span class="text-xs font-medium px-2 py-1 rounded-full 
								{{ $surat->status_admin == 'Menunggu' ? 'text-yellow-700 bg-yellow-100' : '' }}
								{{ $surat->status_admin == 'Diproses' ? 'text-blue-700 bg-blue-100' : '' }}
								{{ $surat->status_admin == 'Ditolak' ? 'text-red-700 bg-red-100' : '' }}
								{{ $surat->status_admin == 'Menunggu Persetujuan' ? 'text-indigo-700 bg-indigo-100' : '' }}
								{{ $surat->status_admin == 'Diterima' ? 'text-cyan-700 bg-cyan-100' : '' }}
								{{ $surat->status_admin == 'Selesai' ? 'text-green-700 bg-green-100' : '' }}
								{{ $surat->status_admin == 'Butuh Revisi' ? 'text-orange-700 bg-orange-100' : '' }}">
								{{ $surat->status_admin }}
							</span>
						</td>
						<td class="px-3 py-2 sm:px-4 sm:py-3 border-b text-center">
							<div class="flex justify-center gap-2 flex-wrap">
								@if ($surat->status_admin === 'Diterima')
									<button onclick="openModalSelesai('{{ route('surat.selesai', str_replace(['/'], '_', $surat->id_surat)) }}')"
										class="text-cyan-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Tandai Selesai">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
										</svg>
									</button>
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->suratBalasan->path_dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-green-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Surat Balasan">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
										</svg>
									</button>
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
										</svg>
									</button>
								@elseif ($surat->status_admin === 'Selesai')
									<a href="{{ route('management-uttp-metrologi', ['auto_open' => 'true', 'user_id' => $surat->user_id, 'jenis_permohonan' => $surat->jenis_surat]) }}"
										class="text-blue-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Tambah UTTP">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
										</svg>
									</a>
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->suratBalasan->path_dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-green-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Surat Balasan">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
										</svg>
									</button>
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
										</svg>
									</button>
								@elseif ($surat->status_admin === 'Diproses' || $surat->status_admin === 'Menunggu Persetujuan')
									@if($surat->suratBalasan)
										@if($surat->suratBalasan->status_surat_keluar === 'Draft')
											<a href="{{ route('create-surat-balasan', str_replace(['/'], '_', $surat->id_surat)) }}"
												class="bg-[#0c3252] hover:bg-[#0a2942] text-white text-sm px-4 py-1 rounded">
												Lanjutkan Draft
											</a>
											<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
												class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
												</svg>
											</button>
										@elseif($surat->suratBalasan->path_dokumen)
											<!-- Tombol untuk lihat surat balasan -->
											<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->suratBalasan->path_dokumen) }}', '{{ $surat->status_admin }}')"
												class="text-green-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Surat Balasan">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
													d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
												</svg>
											</button>
											<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
												class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
												</svg>
											</button>
										@endif
									@else
										<a href="{{ route('create-surat-balasan', str_replace(['/'], '_', $surat->id_surat)) }}"
											class="bg-[#0c3252] hover:bg-[#0a2942] text-white text-sm px-4 py-1 rounded">
											Buat Surat
										</a>
										<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
												class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
												</svg>
											</button>
									@endif

								@elseif ($surat->status_admin === 'Butuh Revisi')
									<!-- Tombol Edit revisi surat balasan -->
									<a href="{{ route('edit-surat-balasan', str_replace(['/'], '_', $surat->id_surat)) }}"
										class="text-yellow-600 hover:scale-110 transition duration-200 inline-flex items-center justify-center" title="Revisi Surat Balasan">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M12 20h9" />
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
										</svg>
									</a>
									@if($surat->suratBalasan && $surat->suratBalasan->path_dokumen)
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->suratBalasan->path_dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-green-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Surat Balasan">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
										</svg>
									</button>
									@endif

									@if($surat->dokumen)
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
										</svg>
									</button>
									@endif
								@elseif ($surat->status_admin === 'Ditolak')
									@if($surat->dokumen)
										<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
											class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Dokumen">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
											</svg>
										</button>
									@endif
									@if($surat->keterangan)
										<button onclick="openKeteranganTolak(`{{ $surat->keterangan }}`)"
											class="text-red-600 hover:scale-105 transition duration-200 inline-flex items-center justify-center" title="Lihat Alasan Penolakan">
											<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
											</svg>
										</button>
									@endif


								@else
									<button onclick="confirmAction('terima', '{{ str_replace(['/'], '_', $surat->id_surat) }}')" 
										class="bg-[#0c3252] hover:bg-[#0a2942] text-white text-sm px-4 py-1 rounded">
										Terima
									</button>
									<button onclick="confirmAction('tolak', '{{ $surat->id_surat }}')" 
										class="bg-white hover:bg-gray-100 text-[#0c3252] border border-[#0c3252] text-sm px-4 py-1 rounded">
										Tolak
									</button>
									@if($surat->dokumen)
									<button onclick="toggleModal(true, '{{ asset('storage/' . $surat->dokumen) }}', '{{ $surat->status_admin }}')"
										class="text-[#0c3252] hover:scale-105 transition duration-200 inline-flex items-center justify-center">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0a10.5 10.5 0 01-21 0 10.5 10.5 0 0121 0z" />
										</svg>
									</button>
									@endif
								@endif
							</div>
						</td>

					</tr>
					@empty
					<tr>
						<td colspan="8" class="px-4 py-3 text-center text-gray-500">Tidak ada data surat</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>

	<!-- Pagination -->
	<div class="mt-4 px-4">
		{{ $suratList->links('pagination::tailwind') }}
	</div>
</div>

<!-- Modal Tolak -->
<div id="tolakModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center">
	<div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
		<h2 class="text-xl font-semibold mb-4">Masukkan Alasan Penolakan</h2>
		<form id="formTolak" method="POST">
			@csrf
			@method('PUT')
			<input type="hidden" name="id_surat" id="tolak_id_surat">
			<textarea name="keterangan" id="tolak_keterangan" rows="4" required
				class="w-full border border-gray-300 rounded-lg p-2 mb-4"></textarea>
			<div class="flex justify-end gap-2">
				<button type="button" onclick="closeTolakModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
				<button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Tolak</button>
			</div>
		</form>
	</div>
</div>

<script>
	function openTolakModal(id) {
		const modal = document.getElementById('tolakModal');
		modal.classList.remove('hidden');
		modal.style.display = 'flex';
		document.getElementById('tolak_id_surat').value = id;
		const encodedId = btoa(id);
		document.getElementById('formTolak').action = `/admin/surat/${encodedId}/tolak`;
	}

	function closeTolakModal() {
		const modal = document.getElementById('tolakModal');
		modal.classList.add('hidden');
		modal.style.display = 'none';
	}
</script>

<!-- Modal Lihat Keterangan Penolakan -->
<div id="modalKeteranganTolak" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center">
	<div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
		<h2 class="text-xl font-semibold mb-4">Alasan Penolakan</h2>
		<p id="isiKeteranganTolak" class="text-gray-700 mb-6"></p>
		<div class="text-right">
			<button onclick="closeKeteranganTolak()" class="px-4 py-2 bg-gray-300 rounded">Tutup</button>
		</div>
	</div>
</div>

<script>
	function openKeteranganTolak(keterangan) {
		document.getElementById('isiKeteranganTolak').innerText = keterangan || 'Tidak ada keterangan tersedia.';
		document.getElementById('modalKeteranganTolak').classList.remove('hidden');
		document.getElementById('modalKeteranganTolak').style.display = 'flex';
	}

	function closeKeteranganTolak() {
		document.getElementById('modalKeteranganTolak').classList.add('hidden');
		document.getElementById('modalKeteranganTolak').style.display = 'none';
	}
</script>

<script>
	function confirmAction(action, id) {
		let message = '';
		let confirmButtonText = '';
		let confirmButtonClass = '';

		switch(action) {
			case 'terima':
				message = 'Apakah Anda yakin ingin menerima surat ini?';
				confirmButtonText = 'Ya, Terima';
				confirmButtonClass = '#0c3252';
				break;
			case 'tolak':
				message = 'Apakah Anda yakin ingin menolak surat ini?';
				confirmButtonText = 'Ya, Tolak';
				confirmButtonClass = '#0c3252';
				break;
			case 'selesai':
				message = 'Apakah Anda yakin ingin menandai surat ini sebagai selesai?';
				confirmButtonText = 'Ya, Tandai Selesai';
				confirmButtonClass = '#0c3252';
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
			confirmButtonColor: confirmButtonClass,
			cancelButtonColor: '#6B7280',
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				if (action === 'tolak') {
					// Tampilkan modal untuk input keterangan
					Swal.fire({
						title: 'Alasan Penolakan',
						input: 'textarea',
						inputPlaceholder: 'Masukkan alasan penolakan...',
						inputAttributes: {
							'aria-label': 'Masukkan alasan penolakan'
						},
						showCancelButton: true,
						confirmButtonText: 'Kirim',
						cancelButtonText: 'Batal',
						confirmButtonColor: '#0c3252',
						cancelButtonColor: '#6B7280',
						inputValidator: (value) => {
							if (!value) {
								return 'Alasan penolakan harus diisi!';
							}
						}
					}).then((result) => {
						if (result.isConfirmed) {
							// Submit form dengan keterangan
							const form = document.createElement('form');
							form.method = 'POST';
							form.action = `/admin/surat/${btoa(id)}/tolak`;
							
							const csrfToken = document.createElement('input');
							csrfToken.type = 'hidden';
							csrfToken.name = '_token';
							csrfToken.value = '{{ csrf_token() }}';
							
							const methodInput = document.createElement('input');
							methodInput.type = 'hidden';
							methodInput.name = '_method';
							methodInput.value = 'PUT';
							
							const keteranganInput = document.createElement('input');
							keteranganInput.type = 'hidden';
							keteranganInput.name = 'keterangan';
							keteranganInput.value = result.value;
							
							form.appendChild(csrfToken);
							form.appendChild(methodInput);
							form.appendChild(keteranganInput);
							document.body.appendChild(form);
							form.submit();
						}
					});
				} else {
					// Untuk aksi terima dan selesai
					const form = document.createElement('form');
					form.method = 'POST';
					let routeUrl = '';
					if (action === 'terima') {
						routeUrl = '{{ route("surat.terima", "") }}';
					} else if (action === 'selesai') {
						routeUrl = '{{ route("surat.selesai", "") }}';
					}
					form.action = `${routeUrl}/${id}`;
					
					const csrfToken = document.createElement('input');
					csrfToken.type = 'hidden';
					csrfToken.name = '_token';
					csrfToken.value = '{{ csrf_token() }}';
					
					const methodInput = document.createElement('input');
					methodInput.type = 'hidden';
					methodInput.name = '_method';
					methodInput.value = 'PUT';
					
					form.appendChild(csrfToken);
					form.appendChild(methodInput);
					document.body.appendChild(form);
					form.submit();
				}
			}
		});
	}
</script>

<script>
	function openModalSelesai(url) {
		Swal.fire({
			title: 'Konfirmasi',
			text: 'Apakah Anda yakin ingin menandai surat ini sebagai selesai?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, Tandai Selesai',
			cancelButtonText: 'Batal',
			confirmButtonColor: '#0c3252',
			cancelButtonColor: '#6B7280',
			reverseButtons: true
		}).then((result) => {
			if (result.isConfirmed) {
				const form = document.createElement('form');
				form.method = 'POST';
				form.action = url;
				
				const csrfToken = document.createElement('input');
				csrfToken.type = 'hidden';
				csrfToken.name = '_token';
				csrfToken.value = '{{ csrf_token() }}';
				
				const methodInput = document.createElement('input');
				methodInput.type = 'hidden';
				methodInput.name = '_method';
				methodInput.value = 'PUT';
				
				form.appendChild(csrfToken);
				form.appendChild(methodInput);
				document.body.appendChild(form);
				form.submit();
			}
		});
	}
</script>
@endsection