@extends('layouts.home')

@section('title', 'Daftar Distributor')

@section('content')
<div class="relative w-full h-64">
    <img src="{{ asset('assets/img/background/dagang.jpg') }}" alt="Background Perdagangan"
        class="object-cover w-full h-full">
    <a href="{{ route('user.dashboard') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">arrow_back</span>
    </a>
</div>

<div class="flex items-center justify-center min-h-screen px-4 py-10 bg-gray-100">
    <div class="bg-white rounded-[30px] shadow-xl border border-gray-200 w-full max-w-md p-8 text-center">
        <h2 class="mb-6 text-lg font-semibold">FORM PERMOHONAN DISTRIBUTOR</h2>
        @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mt-1 ml-4 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('bidangPerdagangan.submitDistributor') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6 text-left">
                <label for="dokumen_nib" class="block mb-2 font-medium">Tambahkan Dokumen NIB</label>
                <input type="file" name="dokumen_nib" id="dokumen_nib" accept=".pdf"
                    class="block w-full px-4 py-2 text-sm text-gray-700 border border-gray-400 rounded-full file:bg-transparent file:border-0 file:mr-2 file:cursor-pointer" />
            </div>

            <div class="mb-6 text-sm text-left">
                <span class="font-semibold">Note :</span>
                <ul class="list-disc list-inside">
                    <li>Dokumen NIB anda akan diverifikasi oleh Dinas Perdagangan</li>
                </ul>
            </div>

            <div class="flex justify-center space-x-4">
                <button type="submit" name="action" value="ajukan"
                    class="bg-[#083358] hover:bg-blue-300 text-white hover:text-black px-6 py-2 rounded-full shadow-md transition-all">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection