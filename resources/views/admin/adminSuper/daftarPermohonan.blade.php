@extends('layouts.admin')

@section('title', 'Daftar Permohonan')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Daftar Permohonan</h1>
    </div>
</div>

<div class="container relative px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6 space-x-4">
        <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">
                search
            </span>
            <input type="text" id="searchInput" placeholder="Cari"
                class="w-full p-3 pl-10 bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
    </div>
</div>

<div class="container px-4 pb-12 mx-auto">
    @if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <div class="max-h-[550px] overflow-y-auto">
            <table class="w-full text-sm text-left bg-white shadow-md rounded-xl min-w-max">
                <thead class="bg-[#083358] text-white font-semibold sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-center border-b rounded-tl-xl">No</th>
                        <th class="px-4 py-3 text-center border-b">Tanggal</th>
                        <th class="px-4 py-3 text-center border-b">Nama Pengirim</th>
                        <th class="px-4 py-3 text-center border-b">Jenis Surat</th>
                        <th class="px-4 py-3 text-center border-b">Bidang Terkait</th>
                        <th class="px-4 py-3 text-center border-b">Status</th>
                        <th class="px-4 py-3 text-center border-b rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1; @endphp
                    @foreach($permohonan as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-center">{{ $counter++ }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->tanggal }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->nama_pengirim }}</td>
                        @php
                            $jenisSuratMap = [
                                'surat_rekomendasi_perdagangan' => 'Surat Rekomendasi',
                                'surat_keterangan_perdagangan' => 'Surat Keterangan',
                                'surat_rekomendasi_industri' => 'Surat Rekomendasi',
                                'surat_keterangan_industri' => 'Surat Keterangan',
                                'dan_lainnya_perdagangan' => 'Surat Lainnya',
                            ];
                        @endphp
                        <td class="px-4 py-2 text-center">
                            {{ $jenisSuratMap[$p->jenis_surat] ?? $p->jenis_surat }}
                        </td>
                        <td class="px-4 py-2 text-center">{{ $p->bidang_terkait }}</td>
                        <td class="px-4 py-2 text-center">
                            @php
                                $status = $p->status;
                                $color = match($status) {
                                    'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                    'Disetujui' => 'bg-green-100 text-green-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Diproses' => 'bg-blue-100 text-blue-800',
                                    'Butuh Revisi' => 'bg-orange-100 text-orange-800',
                                    'Selesai' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $color }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.detailPermohonan', ['id' => base64_encode($p->id), 'bidang' => strtolower($p->bidang_terkait)]) }}" 
                                    class="text-[#083358] hover:text-black">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection 