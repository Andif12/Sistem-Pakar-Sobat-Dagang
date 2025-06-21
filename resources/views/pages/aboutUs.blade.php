@extends('layouts.home')

@section('title', 'Tentang Kami')

@section('content')
<section class="bg-white">
    <div class="relative">
        <img src="{{ asset('assets\img\background\header.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
        <div class="absolute inset-0 flex flex-col justify-center px-6 text-white bg-black lg:px-16 bg-opacity-40">
            <h1 class="text-3xl font-bold">Tentang Kami</h1>
            <h1 class="text-3xl font-bold">Dinas Perdagangan</h1>
            <h1 class="font-bold text-3x1">Kota Parepare</h1>
            <p class="mt-1 text-sm">Beranda / Tentang Kami</p>
        </div>
    </div>

    <div class="p-6 lg:px-16 lg:py-12">
        <div class="flex items-start justify-between">
            <h3 class="mb-10 text-2xl font-bold text-center text-gray-800 tracking-wide">Ringkasan Profil</h3>
            <a href="#kontak" class="px-4 py-2 text-sm text-blue-700 bg-blue-100 rounded hover:bg-blue-200">HUBUNGI KAMI</a>
        </div>
        <p class="text-justify text-gray-700">
            Dinas Perdagangan Kota Parepare merupakan instansi pemerintah daerah yang berfokus pada pengembangan sektor perdagangan di wilayah Parepare. Kami memiliki peran penting dalam menciptakan iklim usaha yang sehat, meningkatkan daya saing pelaku usaha, serta menjaga stabilitas harga dan ketersediaan barang kebutuhan masyarakat. Dengan mengedepankan pelayanan publik yang transparan, cepat, dan akuntabel.
        </p>
        <p class="mt-4 text-justify text-gray-700">
            Dinas Perdagangan berkomitmen untuk mendukung pertumbuhan ekonomi daerah melalui berbagai program seperti pengembangan pasar rakyat, perlindungan konsumen, pengawasan barang beredar, serta fasilitasi promosi perdagangan. Melalui inovasi dan kolaborasi, kami bertekad untuk menjadi mitra strategis bagi pelaku usaha lokal dan nasional, menciptakan Parepare sebagai kota perdagangan yang maju, dinamis, dan berdaya saing tinggi di tingkat regional maupun nasional.
        </p>
    </div>

    <div class="py-10 bg-white">
        <div class="mb-6 text-center">
            <h4 class="mb-10 text-2xl font-bold text-center text-gray-800 tracking-wide">APA YANG KAMI LAKUKAN?</h4>
        </div>
        <div class="flex flex-wrap justify-center gap-6 px-4">
            @php
            $fitur = [
            ['icon' => '🧾', 'label' => 'Pelayanan Publik'],
            ['icon' => '🏬', 'label' => 'Revitalisasi Pasar'],
            ['icon' => '📈', 'label' => 'Pemberdayaan UMKM'],
            ['icon' => '🛡️', 'label' => 'Perlindungan Konsumen'],
            ['icon' => '💻', 'label' => 'Digitalisasi Perdagangan'],
            ];
            @endphp
            @foreach ($fitur as $item)
            <div class="flex flex-col items-center w-32 p-4 bg-white rounded shadow">
                <div class="mb-2 text-3xl">{{ $item['icon'] }}</div>
                <span class="text-sm text-center text-gray-700">{{ $item['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
    <div. class="px-4 py-10">
        <h4 class="mb-10 text-2xl font-bold text-center text-gray-800 tracking-wide">PRESTASI</h4>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/writing.png') }}" alt="Digitalisasi Arsip" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Digitalisasi Arsip dan Surat-Menyurat
                    </p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/presentation.png') }}" alt="Pelatihan ASN" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Pelatihan Peningkatan Kompetensi ASN
                    </p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/supervision.png') }}" alt="SOP Pengawasan Pasar" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Penyusunan SOP Baru untuk Pengawasan Pasar
                    </p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/licensing.png') }}" alt="Reformasi Birokrasi" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Reformasi Birokrasi Berbasis Kinerja
                    </p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/growth-graph.png') }}" alt="Sistem Informasi" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Integrasi Sistem Informasi Perdagangan
                    </p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl shadow-md overflow-hidden transform transition hover:scale-105 duration-300">
                <img src="{{ asset('assets/img/icon/aboutUs/customer-review.png') }}" alt="Kepuasan Pegawai" class="w-full h-40 object-contain p-6">
                <div class="p-4">
                    <p class="text-center text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition">
                        Peningkatan Kepuasan Layanan Internal
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
</section>
@endsection