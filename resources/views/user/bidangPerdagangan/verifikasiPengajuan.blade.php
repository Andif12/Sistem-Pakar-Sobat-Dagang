@extends('layouts.home')
@section('title', 'Verifikasi Pengajuan')
@section('content')

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

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

<div class="flex items-center justify-center min-h-screen px-4 bg-white">
    <div class="w-full max-w-md p-10 text-center bg-white border border-gray-300 shadow-lg rounded-xl md:max-w-lg">
        @if ($status === 'menunggu')
            <img src="{{ asset('assets/img/icon/tanda_seru_circle.png') }}" alt="Tanda Seru" class="w-24 h-24 mx-auto mb-6" />
            <p class="text-xl md:text-2xl font-semibold text-[#083358] leading-snug">
                DOKUMEN ANDA SEDANG<br />DIVERIFIKASI
            </p>
        @elseif ($status === 'diterima')
            <img src="{{ asset('assets\img\icon\Checklist.png') }}" alt="Diterima" class="w-24 h-24 mx-auto mb-6" />
            <p class="text-xl font-semibold leading-snug text-green-600 md:text-2xl">
                DOKUMEN ANDA TELAH<br />DITERIMA
            </p>
        @elseif ($status === 'ditolak')
            <img src="{{ asset('assets/img/icon/tolak.png') }}" alt="Ditolak" class="w-24 h-24 mx-auto mb-6" />
            <p class="text-xl font-semibold leading-snug text-red-600 md:text-2xl">
                DOKUMEN ANDA DITOLAK<br />SILAKAN PERIKSA ULANG
            </p>
            <a href="{{ route('bidangPerdagangan.formDistributor') }}"
                class="inline-block px-6 py-2 mt-6 font-medium text-white transition-all bg-red-600 rounded-full hover:bg-red-700">
                Perbaiki dan Ajukan Ulang
            </a>
        @endif
    </div>
</div>
@endsection
