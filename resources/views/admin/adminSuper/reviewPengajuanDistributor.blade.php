@extends('layouts.admin')
@section('title', 'Review Pengajuan')
@section('fullwidth')
@endsection

@section('content')

<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
    </div>
</div>
<div class="max-w-6xl px-4 mx-auto my-6 mb-12">
<h2 class="text-2xl font-bold text-[#083358] mb-4 text-center">Daftar Pengajuan Distributor</h2>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-[#083358] text-white">
            <tr>
                <th class="px-6 py-3 text-center">No</th>
                <th class="px-6 py-3 text-center">Nama Distributor</th>
                <th class="px-6 py-3 text-center">Dokumen NIB</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($distributor as $index => $itemDistributor)
        <tr>
            <td class="px-6 py-3 text-center">{{ $index + 1 }}</td>
            <td class="px-6 py-3 text-center ">{{ $itemDistributor->user->nama ?? 'Tidak diketahui' }}</td>
            <td class="px-6 py-3 text-center">
                <a href="{{ asset('storage/' . $itemDistributor->nib) }}" target="_blank" class="text-blue-500">Lihat Dokumen</a>
            </td>
            <td class="px-6 py-3 text-center">
                <span class="inline-block py-1 px-3 rounded-full 
                    @if($itemDistributor->status == 'menunggu')
                                bg-yellow-500 text-white
                            @elseif($itemDistributor->status == 'diterima')
                                bg-green-600 text-white
                            @else
                                bg-red-600 text-white
                            @endif
                ">
                    {{ ucfirst($itemDistributor->status) }}
                </span>
            </td>
            <td class="px-6 py-3 text-center" x-data="{ openModal: false }">
            @if (strtolower($itemDistributor->status) === 'diterima')
                <!-- Tombol Buka Modal -->
                <button @click="openModal = true" class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                    Hapus Distributor
                </button>

                <!-- Modal Konfirmasi -->
                <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
                    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800">Konfirmasi Penghapusan</h2>
                        <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus distributor ini?</p>
                        <div class="flex justify-center gap-4">
                            <button @click="openModal = false" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">
                                Batal
                            </button>
                            <form action="{{ route('distributor.hapus', ['id_distributor' => $itemDistributor->id_distributor]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            @elseif (strtolower($itemDistributor->status) === 'ditolak')
                <!-- Tombol Tidak Aktif -->
                <button class="px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed" disabled>✓</button>

            @elseif (strtolower($itemDistributor->status) === 'menunggu')
                <!-- Tombol Terima -->
                <form action="{{ route('distributor.setujui', ['id_distributor' => $itemDistributor->id_distributor]) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                        Terima
                    </button>
                </form>

                <!-- Tombol Tolak -->
                <form action="{{ route('distributor.tolak', ['id_distributor' => $itemDistributor->id_distributor]) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                        Tolak
                    </button>
                </form>

            @else
                <!-- Default jika status tidak dikenali -->
                <button class="px-3 py-1 text-white bg-gray-400 rounded cursor-not-allowed" disabled>✓</button>
            @endif
        </td>

        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
@endsection

