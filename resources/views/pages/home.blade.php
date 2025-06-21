@extends('layouts.home')

@section('title', 'Dashboard')

@section('content')

<div class="relative w-full pb-12 overflow-visible">
    <div class="absolute top-0 right-0 w-[60%] h-[540px] bg-cover bg-center shadow-lg rounded-tl-3xl rounded-bl-3xl z-0" style="background-image: url('{{ asset('assets/img/dashboard.jpg') }}');"></div>
    <div class="relative z-10 pt-24 pl-8 pr-8">
        <div class="bg-white rounded-xl shadow-md p-6 max-w-md border-l-8 border-b-8 ml-[100px]" style="border-color: #083358;">
            <h2 class="mb-3 text-2xl font-bold text-gray-800">Halo, Sobat Dagang!</h2>
            <p class="leading-relaxed text-gray-600 text-medium">
                Terima kasih telah mengakses
                sistem informasi Dinas Perdagangan Kota Parepare.
                Melalui platform ini, kami hadir untuk
                mendekatkan pelayanan publik kepada masyarakat
                dengan informasi yang mudah diakses dan transparan.
            </p>
        </div>
    </div>

    <div class="bg-[#083358] text-white px-6 md:px-16 py-4 mt-[150px] z-10 shadow-lg">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold md:text-2xl">Berita Terkini</h3>
            <a href="{{ route('berita.utama', ['id' => 1]) }}" class="text-sm underline transition hover:text-gray-300"></a>
        </div>
    </div>
    <div class="relative px-6 py-8 overflow-visible md:px-16">
        <div class="relative flex gap-8 overflow-visible overflow-x-auto scrollbar-hide" style="scroll-snap-type: x mandatory;">
            @foreach ($daftarBerita as $berita)
            <a href="{{ route('berita.utama', urlencode($berita->judul)) }}"
                class="relative z-0 flex-none min-w-0 overflow-hidden transition-all duration-500 ease-in-out transform bg-white shadow-md w-72 rounded-2xl hover:-translate-y-2 hover:shadow-glow snap-start group group-hover:z-10">

                <div class="overflow-hidden rounded-2xl">
                    <img src="{{ asset('storage/' . $berita->lampiran) }}" alt="{{ $berita->judul }}"
                        class="object-cover w-full transition-transform duration-500 ease-in-out h-72 rounded-2xl group-hover:scale-110 ">
                </div>

                <div class="absolute text-xs font-semibold text-white top-3 left-3">
                    {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('l, d M Y') }}
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent rounded-b-2xl">
                    <h4 class="text-base font-extrabold leading-tight text-white transition-all duration-500 ease-in-out group-hover:tracking-wider">
                        {{ $berita->judul }}
                    </h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="bg-[#083358] text-white px-6 md:px-16 py-4 mt-10 z-10 shadow-lg">
        <div class="flex items-center justify-center">
            <h3 class="justify-center text-lg font-bold md:text-2xl">Sobat Harga</h3>
        </div>
    </div>
    <div class="max-w-6xl px-4 py-10 mx-auto">
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-5">
            @php
            $items = [
            ['name' => 'Beras', 'image' => 'beras.png'],
            ['name' => 'Cabe', 'image' => 'cabe.png'],
            ['name' => 'Ayam', 'image' => 'ayam.png'],
            ['name' => 'Bawang', 'image' => 'bawang.png'],
            ['name' => 'Telur', 'image' => 'telur.png'],
            ['name' => 'Daging', 'image' => 'daging.png'],
            ['name' => 'Ikan', 'image' => 'ikan.png'],
            ['name' => 'Tahu', 'image' => 'tahu.png'],
            ['name' => 'Tempe', 'image' => 'tempe.png'],
            ['name' => 'Tomat', 'image' => 'tomat.png'],
            ];
            @endphp

            @foreach ($items as $item)
            <a href="{{ route('harga-pasar.kategori', ['kategori' => strtolower($item['name'])]) }}"
                class="border-2 border-[#083358] rounded-xl p-4 flex flex-col items-center bg-white shadow-sm
                hover:bg-indigo-50 hover:shadow-lg hover:scale-105 transition-all duration-300 ease-in-out transform">
                <img src="{{ asset('assets/img/icon/hargaPasar/' . $item['image']) }}" alt="{{ $item['name'] }}" class="object-contain w-16 h-16">
                <p class="mt-3 text-sm font-semibold">{{ $item['name'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Custom Styling -->
<style>
    /* Hilangkan scrollbar */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Glow Effect */
    .hover\:shadow-glow:hover {
        box-shadow: 0 8px 20px rgba(8, 51, 88, 0.5), 0 0 20px rgba(8, 51, 88, 0.3);
    }
</style>

@endsection