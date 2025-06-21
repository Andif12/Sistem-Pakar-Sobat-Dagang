@extends('layouts.home')

@section('title', 'Riwayat Surat Permohonan')

@section('content')

<div class="relative w-full h-64">
    <img src="{{ asset('assets\img\background\user_industri.png') }}" alt="Background" class="object-cover w-full h-full" />
    <a href="{{ route('user.dashboard') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">arrow_back</span>
    </a>
</div>
<div class="container px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6">
        <form action="{{ route('bidangIndustri.riwayatSurat') }}" method="GET" class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari"
                class="w-full p-3 pl-10 bg-transparent border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </form>
    </div>
    <div class="flex justify-center mb-6">

        <div class="flex gap-1 p-1 bg-blue-100 rounded-full">
            <button onclick="window.location.href='{{ route('bidangIndustri.formPermohonan') }}'"
                class="px-6 py-2 font-semibold text-black transition-all rounded-full hover:bg-gray-100">
                AJUKAN SURAT PERMOHONAN
            </button>
            <button onclick="window.location.href='{{ route('bidangIndustri.riwayatSurat') }}'"
                class="bg-[#083358] text-white font-semibold py-2 px-6 rounded-full shadow transition-all">
                RIWAYAT SURAT
            </button>
        </div>
    </div>
    <div class="container px-4 pb-4 mx-auto">
        <table class="min-w-full overflow-hidden bg-white border border-gray-300 shadow-md rounded-xl">
            <thead>
                <tr class="bg-[#083358] text-white font-semibold">
                    <th class="px-4 py-3 border-b rounded-tl-xl">No</th>
                    <th class="px-4 py-3 border-b">Tanggal Dikirim</th>
                    <th class="px-4 py-3 border-b">Jenis Surat</th>
                    <th class="px-4 py-3 border-b">Status</th>
                    <th class="px-4 py-3 border-b rounded-tr-xl">Balasan</th>
                </tr>
            </thead>
            <tbody>
                @php $nomor = 1; @endphp
                @foreach ($riwayatSurat as $index => $item)
                <tr class="border-b">
                    <td class="px-4 py-3 text-center">{{ $nomor++ }}</td>
                    <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($item->jenis_surat == 'surat_rekomendasi_industri')
                        Surat Rekomendasi
                        @elseif($item->jenis_surat == 'surat_keterangan_industri')
                        Surat Keterangan
                        @elseif($item->jenis_surat == 'dan_lainnya_industri')
                        Lainnya
                        @else
                        {{ $item->jenis_surat }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if ($item->status == 'diterima')
                        <span class="font-medium text-green-600">Disetujui</span>
                        @elseif ($item->status == 'ditolak')
                        <span class="font-medium text-red-600">Ditolak</span>
                        @else
                        <span class="font-medium text-yellow-400">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="openBalasanModal('{{ asset('storage/' . $item->file_balasan) }}', '{{ $item->status }}')" class="px-4 py-2 bg-[#8CC5F3] text-black font-bold rounded-full hover:bg-[#7bb6e0] transition-all">
                            Lihat
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-center my-8">
        <div class="flex items-center p-4 space-x-4 bg-white border border-gray-300 rounded-md shadow-sm">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-6 h-6 text-sm font-bold text-black border border-black rounded-full">
                    i
                </div>
            </div>
            <div class="text-sm text-black">
                <div class="space-y-1 text-sm">
                    <div class="flex">
                        <span class="w-24 font-bold">Menunggu</span>
                        <span>: Surat sedang dalam tahap pemeriksaan atau validasi.</span>
                    </div>
                    <div class="flex">
                        <span class="w-24 font-bold">Selesai</span>
                        <span>: Surat telah disetujui dan dapat diunduh.</span>
                    </div>
                    <div class="flex">
                        <span class="w-24 font-bold">Ditolak</span>
                        <span>: Permohonan tidak disetujui, silahkan lihat detail alasan.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Modal Balasan -->
<div id="modal-balasan" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div>
        <div id="balasanContent">
            <!-- Konten balasan akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

@endsection

<script>
    function openBalasanModal(fileUrl, status) {
        const modal = document.getElementById("modal-balasan");
        const content = document.getElementById("balasanContent");

        // Periksa apakah status adalah 'ditolak' atau 'diterima'
        if ((status === 'ditolak' || status === 'diterima') && fileUrl) {
            content.innerHTML = `
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="relative w-full max-w-sm p-6 text-center bg-white shadow-xl rounded-xl">
                        <button class="absolute text-gray-500 top-2 right-2 hover:text-gray-700" onclick="closeBalasanModal()">
                            &times;
                        </button>

                        <div class="flex justify-center mb-4">
                            <div class="flex items-center justify-center w-24 h-24 bg-yellow-400 rounded-full">
                                <img src="/assets/img/icon/pdf.png" alt="PDF" class="w-auto h-16">
                            </div>
                        </div>

                        <h2 class="mb-4 text-lg font-semibold">Balasan Surat Anda</h2>

                        <div class="flex justify-center space-x-4">
                            <a href="${fileUrl}" target="_blank"
                            class="bg-[#083358] hover:bg-[#8CC5F3] text-white font-medium py-2 px-6 rounded-full">
                            Lihat
                            </a>
                            <a href="${fileUrl}" download
                            class="bg-[#083358] hover:bg-[#8CC5F3] text-white font-medium py-2 px-6 rounded-full">
                            Unduh
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            content.innerHTML = `
                <div class="relative w-full max-w-sm p-6 text-center bg-white shadow-xl rounded-xl">
                    <button class="absolute text-gray-500 top-4 right-2 hover:text-gray-700" onclick="closeBalasanModal()">
                            &times;
                    </button>
                    <span class="text-red-600 material-symbols-outlined" style="font-size: 6rem;">cancel</span>
                    <h2 class="mb-4 text-lg font-semibold text-red-600">Belum ada balasan untuk surat ini.</h2>
                </div>
            `;
        }

        modal.classList.remove("hidden");
    }

    function closeBalasanModal() {
        const modal = document.getElementById("modal-balasan");
        modal.classList.add("hidden");
    }
</script>