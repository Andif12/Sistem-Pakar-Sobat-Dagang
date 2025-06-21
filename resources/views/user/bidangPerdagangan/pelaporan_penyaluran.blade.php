@extends('layouts.home')
@section('title', 'Belum di Verifikasi')
@section('content')

<div class="relative w-full h-64">
    <img src="{{ asset('assets\img\background\dagang.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <a href="{{ route('user.dashboard') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">arrow_back</span>
    </a>
    <div class="absolute bottom-0 transform -translate-x-1/2 translate-y-1/2 left-1/2">
        <p class="px-6 py-3 font-bold text-[#083358] bg-white shadow-md text-md font-istok rounded-3xl shadow-black/40">
            PELAPORAN PENYALURAN PUPUK BERSUBSIDI
        </p>
    </div>
</div>
<div class="flex flex-col items-center justify-center min-h-[70vh] px-4 text-center">
    <img src="{{ asset('assets/img/icon/tanda_seru_circle.png') }}" class="w-20 h-20 mb-4" alt="Tanda Seru" />
    <h2 class="text-lg md:text-2xl font-bold text-[#083358] mb-3">
        ANDA BELUM TERDAFTAR SEBAGAI DISTRIBUTOR.<br> 
        LAKUKAN PENDAFTARAN UNTUK MENGAKSES PELAPORAN PENYALURAN PUPUK BERSUBSIDI
    </h2>
    <a href="{{ route('bidangPerdagangan.formDistributor') }}"
       class="inline-block bg-[#083358] text-white px-6 py-3 rounded-full font-semibold shadow hover:bg-blue-100 hover:text-black transition-all duration-300">
        Daftar Sekarang
    </a>
</div>
@endsection