@extends('layouts.home')
@section('title', 'Input Data Distribusi')
@section('content')

<div class="relative w-full h-64">
    <img src="{{ asset('assets/img/background/dagang.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <a href="{{ route('pelaporan') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">arrow_back</span>
    </a>
    <div class="absolute bottom-0 transform -translate-x-1/2 translate-y-1/2 left-1/2">
        <p class="px-6 py-3 font-bold text-[#083358] bg-white shadow-md text-md font-istok rounded-3xl shadow-black/40">
            PELAPORAN PENYALURAN PUPUK BERSUBSIDI
        </p>
    </div>
</div>

<div class="flex items-start justify-center w-full bg-gray-100">
    <div class="w-full max-w-md p-8 my-16 bg-white border border-gray-300 shadow-md rounded-2xl">
        <h2 class="mb-6 text-lg font-semibold text-center text-black">INPUT DATA DISTRIBUSI</h2>
        @if ($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('pelaporan.inputDataDistribusi') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-base font-medium text-black">Nama Toko</label>
                <input type="text" value="{{ $toko->nama_toko }}" readonly
                    class="block w-full px-4 py-2 mt-1 bg-gray-200 border border-gray-300 rounded-full cursor-not-allowed">
                <input type="hidden" name="id_toko" value="{{ $toko->id_toko }}">
            </div>

            <div class="mb-4">
                <label for="nama_barang" class="block text-base font-medium text-black">Pilih Jenis Pupuk</label>
                <select name="nama_barang" id="nama_barang" required
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Pilih Jenis Barang</option>
                    <option value="NPK">NPK</option>
                    <option value="UREA">UREA</option>
                    <option value="NPK-FK">NPK FK</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-base font-medium text-black">Stok Awal</label>
                <input type="number" name="stok" id="stok" required
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="penyaluran" class="block text-base font-medium text-black">Penyaluran</label>
                <input type="number" name="penyaluran" id="penyaluran" required
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="tanggal_input" class="block text-base font-medium text-black">Tanggal Input</label>
                <input type="date" name="tanggal_input" id="tanggal_input" required
                    class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="bg-[#083358] text-white px-6 py-2 rounded-full hover:bg-blue-300 hover:text-black transition duration-200">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
