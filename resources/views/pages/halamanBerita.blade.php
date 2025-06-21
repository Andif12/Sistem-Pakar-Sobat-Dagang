@extends('layouts.home')

@section('content')

<div class="container px-4 py-12 mx-auto">
    <div class="max-w-4xl p-8 mx-auto bg-white shadow-lg rounded-2xl">
        <a href="{{ url()->previous() }}" class="inline-block mb-6 text-sm text-blue-500 hover:text-blue-700">
            <i class="mr-2 fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <h1 class="mb-2 text-3xl font-bold text-gray-900 md:text-4xl">{{ $berita->judul }}</h1>

        <p class="mb-6 text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($berita->tanggal ?? $berita->created_at)->translatedFormat('l, d M Y') }}
        </p>

        @if ($berita->lampiran)
        <div class="mb-8 overflow-hidden rounded-lg">
            <img src="{{ asset('storage/' . $berita->lampiran) }}" alt="{{ $berita->judul }}" class="w-full h-[400px] object-cover">
        </div>
        @endif

        <div class="text-lg leading-relaxed text-gray-700 whitespace-pre-line">
            {!! $berita->isi !!}
        </div>

    </div>
</div>
@endsection