@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Manajemen Pengguna</h1>
    </div>
</div>

<div class="container relative px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6 space-x-4">
        <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">
                search
            </span>
            <input type="text" id="searchInput" placeholder="Cari"
                class="w-full p-3 pl-10 bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <a href="{{ route('manajemen.pengguna.create') }}" 
            class="px-6 py-3 text-[#083358] font-semibold bg-white rounded-full shadow-xl shadow-gray-400/40 hover:text-white hover:bg-[#083358] transition-all duration-300">
            + Tambah Pengguna
        </a>
    </div>
</div>

<div class="container px-4 pb-12 mx-auto">
    @if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded-xl">
            <thead>
                <tr class="bg-[#083358] text-white font-semibold">
                    <th class="px-4 py-3 border-b rounded-tl-xl">No</th>
                    <th class="px-4 py-3 border-b">Nama Lengkap</th>
                    <th class="px-4 py-3 border-b">Email</th>
                    <th class="px-4 py-3 border-b">No. Telepon</th>
                    <th class="px-4 py-3 border-b">NIP</th>
                    <th class="px-4 py-3 border-b">NIK</th>
                    <th class="px-4 py-3 border-b">NIB</th>
                    <th class="px-4 py-3 border-b rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                
                {{-- Regular Users --}}
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-center">{{ $counter++ }}</td>
                    <td class="px-4 py-2">{{ $user->nama }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->telp }}</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">{{ $user->nik }}</td>
                    <td class="px-4 py-2">{{ $user->nib ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('manajemen.pengguna.edit', $user->id_user) }}" 
                                class="text-[#083358] hover:text-black">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            @if($user->role !== 'disdag')
                            <form action="{{ route('manajemen.pengguna.destroy', $user->id_user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[#083358] hover:text-black" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection