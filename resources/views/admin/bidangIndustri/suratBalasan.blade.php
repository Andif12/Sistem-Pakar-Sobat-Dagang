@extends('layouts.admin') 
@section('title', 'Persuratan')

@section('content')
<main class="flex-1 flex flex-col bg-gray-100 min-h-screen">
  <header class="relative z-10">
    <img src="{{ asset('/assets/img/background/user_industri.png') }}" class="w-full h-[210px] object-cover z-0 relative" alt="Header">

    <!-- Search box -->
    <div class="absolute top-36 left-1/2 transform -translate-x-1/2 w-11/12 md:w-3/4 z-20">
      <div class="flex items-center justify-between bg-[#CAE2F6] rounded-full shadow-lg px-6 py-2">
        <input type="text" placeholder="Cari" class="bg-transparent w-full focus:outline-none text-sm">
      </div>
    </div>
  </header>

  <!-- Summary Cards -->
  <section class="mt-20 px-6 flex flex-wrap justify-center gap-4">
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center w-48">
      <img src="{{ asset('assets/img/icon/surat-masuk.png') }}" class="mx-auto w-8 mb-2">
      <p class="text-sm font-semibold text-gray-600">Jumlah Surat Masuk</p>
      <p class="text-2xl font-bold text-yellow-500">6</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center w-48">
      <img src="{{ asset('assets/img/icon/terverifikasi.png') }}" class="mx-auto w-8 mb-2">
      <p class="text-sm font-semibold text-gray-600">Jumlah Surat Terverifikasi</p>
      <p class="text-2xl font-bold text-green-500">4</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center w-48">
      <img src="{{ asset('assets/img/icon/surat-ditolak.png') }}" class="mx-auto w-8 mb-2">
      <p class="text-sm font-semibold text-gray-600">Jumlah Surat Ditolak</p>
      <p class="text-2xl font-bold text-red-500">2</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center w-48">
      <img src="{{ asset('assets/img/icon/surat-balasan.png') }}" class="mx-auto w-8 mb-2">
      <p class="text-sm font-semibold text-gray-600">Draft Surat Balasan</p>
      <p class="text-2xl font-bold text-blue-500">2</p>
    </div>
  </section>

  <!-- Table -->
  <section class="mt-8 px-6 pb-16">
    <div class="overflow-x-auto rounded-lg">
      <table class="w-full border-collapse text-sm bg-white shadow-md">
        <thead>
          <tr class="text-white bg-[#083458]">
            <th class="p-3 rounded-tl-xl">NO</th>
            <th class="p-3">NO SURAT</th>
            <th class="p-3">NAMA PEMOHON</th>
            <th class="p-3">TANGGAL DIKIRIM</th>
            <th class="p-3">STATUS</th>
            <th class="p-3 rounded-tr-xl">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-b">
            <td class="p-3 text-center">1</td>
            <td class="p-3">PMH1</td>
            <td class="p-3">Nurul Aulia</td>
            <td class="p-3">10 April 2025</td>
            <td class="p-3 text-yellow-500 font-medium">Menunggu</td>
            <td class="p-3 text-center">
              <button class="bg-[#083458] text-white px-3 py-1 text-xs rounded-full">Lihat Permohonan</button>
            </td>
          </tr>
          <tr class="bg-gray-50 border-b">
            <td class="p-3 text-center">2</td>
            <td class="p-3">PMH1</td>
            <td class="p-3">Nurul Aulia</td>
            <td class="p-3">23 Maret 2025</td>
            <td class="p-3 text-green-500 font-medium">Disetujui</td>
            <td class="p-3 text-center">
              <button class="bg-[#083458] text-white px-3 py-1 text-xs rounded-full">Lihat Permohonan</button>
            </td>
          </tr>
          <tr class="bg-white border-b">
            <td class="p-3 text-center">3</td>
            <td class="p-3">PMH1</td>
            <td class="p-3">Nurul Aulia</td>
            <td class="p-3">23 Maret 2025</td>
            <td class="p-3 text-red-500 font-medium">Ditolak</td>
            <td class="p-3 text-center">
              <button class="bg-[#083458] text-white px-3 py-1 text-xs rounded-full">Lihat Permohonan</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</main>
@endsection