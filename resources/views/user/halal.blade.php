@extends('layouts.home')

@section('title', 'Data Sertifikat Halal')

@section('content')


<div class="flex flex-col bg-white">

  <!-- Banner -->
  <div class="relative">
    <img src="{{ asset('assets\img\background\user_industri.png') }}" alt="Banner" class="object-cover w-full h-44">
    <a href="{{ route('user.dashboard') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">
            arrow_back
        </span>
    </a>
   <!-- Search Bar di tengah -->
    <div class="absolute w-11/12 transform -translate-x-1/2 top-40 left-1/2 md:w-3/4">
      <form action="{{ route('halal.user') }}" method="GET" class="relative">
        <input
          type="text"
          name="keyword"
          value="{{ request('keyword') }}"
          placeholder="Cari"
          class="w-full px-6 py-2 pl-10 bg-white rounded-full shadow-md focus:outline-none">

        <!-- Ikon pencarian -->
        <svg class="absolute w-5 h-5 text-gray-500 transform -translate-y-1/2 left-3 top-1/2" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
        </svg>
      </form>
    </div>
  </div>



  <div class="flex-1 px-6 py-10 m-4">
    <h2 class="mb-5 text-5xl font-bold text-center">Data Sertifikat Halal</h2>
    <div class="overflow-auto border border-gray-200 shadow rounded-xl">
      <table class="min-w-full text-sm rounded-lg">
        <thead class="bg-[#0d3b66] text-white text-center">
          <tr>
            <th class="px-4 py-3">NOMOR</th>
            <th class="px-4 py-3">NAMA USAHA</th>
            <th class="px-4 py-3">TANGGAL TERBIT</th>
            <th class="px-4 py-3">ALAMAT</th>
            <th class="px-4 py-3">NO. SERTIFIKAT HALAL</th>
            <th class="px-4 py-3">HYPERLINK</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $index => $item)
            <tr class="{{ $index % 2 === 0 ? 'bg-gray-100' : 'bg-white' }} ">
              <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
              <td class="px-4 py-2 text-left">{{ $item->nama_usaha }}</td>
              <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal_sah)->format('d M Y') }}</td>
              <td class="px-4 py-2 text-left">{{ $item->alamat }}</td>
              <td class="px-4 py-2 text-center">{{ $item->no_sertifikasi_halal }}</td>
              <td class="px-4 py-2 text-center">
                @if ($item->sertifikat)
                  <a href="{{ asset('storage/' . $item->sertifikat) }}" target="_blank" class="text-blue-600 underline">Sertifikat Halal</a>
                @else
                  <span class="text-gray-400">Tidak tersedia</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-4 text-center text-gray-500">Tidak ada data sertifikat halal.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection