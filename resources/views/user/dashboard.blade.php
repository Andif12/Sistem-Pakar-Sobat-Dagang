@extends('layouts.home')

@section('title', 'Dashboard')

@section('content')
<section class="px-4 py-12 bg-white">
    <div class="grid items-center gap-8 mx-auto max-w-7xl md:grid-cols-2">
        <div>
            <h1 class="text-3xl font-bold text-[#2E3C51] mb-4">
                Selamat datang di Sobat Dagang Kota Parepare
            </h1>
            <p class="text-base text-[#6B7280] leading-relaxed max-w-md">
                Kami siap melayani Anda dalam Pengurusan Perizinan, Pelaporan, dan fasilitas perdagangan lainnya secara mudah dan cepat
            </p>
        </div>
        <div class="flex justify-center md:justify-end">
            <img src="{{ asset('assets/img/icon/ilustrasi-checklist.png') }}" alt="Ilustrasi Formulir" class="w-72 md:w-80">
        </div>
    </div>
</section>

@php
    $menus = [
        'PERDAGANGAN' => [
            ['label' => 'Permohonan perizinan/non perizinan', 'route' => route('bidangPerdagangan.formPermohonan')],
        ],
        'INDUSTRI' => [
            ['label' => 'Permohonan IKM Binaan', 'route' => route('bidangIndustri.formPermohonan')],
            ['label' => 'Data Sertifikat Halal', 'route' => route('halal.user')],
        ],
        'METROLOGI' => [
            ['label' => 'Permohonan Tera/Tera ulang', 'route' => route('administrasi-metrologi')],
            ['label' => 'Alat Ukur Valid', 'route' => route('directory-metrologi')],
        ],
    ];
@endphp

<div class="flex flex-col items-center justify-center mt-10 space-y-6 md:flex-row md:space-x-8 md:space-y-0">
    @foreach($menus as $title => $items)
        <div class="relative group w-[250px]">
            <button class="bg-[#ABBED1] w-full px-6 py-3 rounded shadow font-bold text-center">
                {{ $title }}
            </button>
            <div class="absolute left-0 w-full hidden group-hover:block bg-[#CAE2F6] shadow-lg rounded overflow-hidden z-10">
                @foreach($items as $index => $item)
                    <a href="{{ $item['route'] }}"
                       class="block px-4 py-2 font-semibold text-[#083458] text-left hover:bg-[#98c4e9]
                            {{ $index === 0 ? 'rounded-t' : '' }}
                            {{ $index === count($items)-1 ? 'rounded-b' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<section class="px-4 py-12 bg-white">
    <div class="grid grid-cols-1 gap-8 mx-auto md:grid-cols-3 max-w-7xl">
        @php
            $cards = [
                [
                    'title' => 'IZIN USAHA TOKO',
                    'desc' => 'Fitur untuk pelaku usaha melaporkan kegiatan usahanya secara rutin',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />',
                ],
                [
                    'title' => 'LAPORAN',
                    'desc' => 'Fitur untuk pelaku usaha melaporkan kegiatan usahanya secara rutin',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />',
                ],
                [
                    'title' => 'LAPAK DIGITAL',
                    'desc' => 'Fitur promosi produk pelaku usaha binaan secara online',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72" />',
                ],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-[#F1F5F9] p-6 rounded-xl shadow hover:shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-10 h-10 mb-4 text-[#083458]">
                {!! $card['icon'] !!}
            </svg>
            <h3 class="text-xl font-bold text-[#2E3C51] mb-2">{{ $card['title'] }}</h3>
            <p class="text-[#6B7280] text-sm">{{ $card['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>
<a href="{{ route('forum.chat') }}" class="fixed bottom-5 right-5 bg-[#083458] rounded-full p-3 shadow-lg hover:scale-110 transition">
    <img src="{{ asset('assets/img/icon/pengaduan.png') }}" alt="Chat" class="w-8 h-8">
</a>
@endsection
