@extends('layouts.admin')
@section('title', 'Lihat Pengaduan Distributor')

@section('content')
<div class="w-full h-36">
    <img src="{{ asset('assets/img/background/dagang.jpg') }}"
        alt="Background" class="object-cover w-full h-full">
</div>

<div class="container px-4 mx-auto">

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 rounded-xl">
    {{ session('success') }}
</div>
@endif

<h2 class="mt-6 text-center text-2xl font-bold mb-6 uppercase tracking-wide text-[#083358]">Daftar Pengaduan Distributor</h2>

<div class="overflow-x-auto">
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="max-h-[600px] overflow-y-auto">
            <table class="w-full text-sm text-center">
                <thead class="bg-[#083358] text-white font-semibold sticky top-0">
                    <tr>
                        <th class="px-4 py-3 border">No</th>
                        <th class="px-4 py-3 border">Nama Distributor</th>
                        <th class="px-4 py-3 border">Judul Pengaduan</th>
                        <th class="px-4 py-3 border">Tanggal</th>
                        <th class="px-4 py-3 border">Status</th>
                        <th class="px-4 py-3 border">Lihat</th>
                        <th class="px-4 py-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan->sortByDesc('created_at') as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ ucwords($item->user->nama ?? '-') }}</td>
                        <td class="px-4 py-2 border">{{ $item->judul }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="px-4 py-2 border capitalize text-center">{{ $item->status }}</td>
                        <td class="px-4 py-2 border text-center">
                            <button onclick="openModal({{ $item->id }})"
                                class="px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                Lihat
                            </button>
                        </td>
                        <td class="px-4 py-2 border text-center">
                            @if($item->status !== 'selesai')
                            <form action="{{ route('admin.pengaduan.selesai', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                                    Tandai Selesai
                                </button>
                            </form>
                            @else
                            <span class="text-gray-500 text-xs">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada pengaduan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($pengaduan as $item)
<div id="modalLihat-{{ $item->id }}" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50 p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-md p-4 sm:p-6 rounded-xl relative shadow-lg ml-24">

        <button onclick="closeModal({{ $item->id }})"
            class="absolute top-3 right-3 text-gray-500 text-2xl hover:text-gray-700">&times;
        </button>

        <h3 class="text-lg font-bold text-center mb-3 text-[#083358] break-words">
            {{ $item->judul }}
        </h3>

        <div class="text-sm text-gray-800 whitespace-pre-line border-t pt-3 break-words">
            {{ $item->isi }}
        </div>
    </div>
</div>
@endforeach

<script>
    function openModal(id) {
        document.getElementById('modalLihat-' + id).classList.remove('hidden');
        document.getElementById('modalLihat-' + id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById('modalLihat-' + id).classList.add('hidden');
        document.getElementById('modalLihat-' + id).classList.remove('flex');
    }
</script>

@endsection
