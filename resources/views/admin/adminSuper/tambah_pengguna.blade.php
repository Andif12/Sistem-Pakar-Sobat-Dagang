@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Tambah Pengguna</h1>
    </div>
</div>
<div class="container px-4 py-8 mx-auto">
    <div class="max-w-4xl p-8 mx-auto bg-white rounded-xl shadow-md">
        <form method="POST" action="{{ route('manajemen.pengguna.store') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block mb-1 font-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Lengkap"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block mb-1 font-semibold">Jenis Kelamin</label>
                    <div class="flex items-center gap-6 mt-1">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" class="accent-blue-500" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                            <span>Laki-Laki</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="accent-blue-500" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kabupaten -->
                <div class="form-group">
                    <label class="block mb-1 font-semibold">Kabupaten/Kota</label>
                    <select id="kabupaten" name="kabupaten" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm form-control focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kabupaten</option>
                        @foreach ($wilayah['kabupaten'] as $kab)
                        <option value="{{ $kab['name'] }}">{{ $kab['name'] }}</option>
                        @endforeach
                    </select>
                    @error('kabupaten')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kecamatan -->
                <div class="form-group">
                    <label class="block mb-1 font-semibold">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm form-control focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">--Pilih Kecamatan--</option>
                    </select>
                     @error('kecamatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label class="block mb-1 font-semibold">Nomor HP</label>
                    <input type="text" name="telp" value="{{ old('telp') }}" placeholder="Masukkan Nomor HP"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelurahan -->
                <div class="form-group">
                    <label class="block mb-1 font-semibold">Kelurahan</label>
                    <select id="kelurahan" name="kelurahan" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm form-control focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Kelurahan --</option>
                    </select>
                     @error('kelurahan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 font-semibold">Kata Sandi</label>
                    <input type="password" name="password" placeholder="Masukkan Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block mb-1 font-semibold">Alamat</label>
                    <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}" placeholder="Masukkan Alamat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('alamat_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block mb-1 font-semibold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- NIK -->
                <div>
                    <label class="block mb-1 font-semibold">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIB -->
                <div>
                    <label class="block mb-1 font-semibold">NIB (Nomor Induk Berusaha)</label>
                    <input type="text" name="nib" value="{{ old('nib') }}" placeholder="Masukkan NIB (Opsional)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nib')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center gap-4 mt-8">
                <a href="{{ route('manajemen.pengguna') }}" 
                   class="px-6 py-2 text-gray-600 bg-gray-200 rounded-full hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 text-white bg-[#083358] rounded-full hover:bg-[#062a47]">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Gunakan IIFE (Immediately Invoked Function Expression) untuk mengisolasi kode
(function() {
    // Get data from PHP
    const dataWilayah = @json($wilayah['kabupaten']);
    
    // Get select elements dengan ID yang spesifik untuk tambah pengguna
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const kelurahanSelect = document.getElementById('kelurahan');

    // Function to reset a select
    function resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    // Function to populate a select with options
    function populateSelect(select, options) {
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            select.appendChild(opt);
        });
    }

    // Kabupaten change event
    kabupatenSelect.addEventListener('change', function() {
        const selectedKabupaten = dataWilayah.find(kab => kab.name === this.value);
        
        // Reset kecamatan and kelurahan
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
        resetSelect(kelurahanSelect, '-- Pilih Kelurahan --');

        if (selectedKabupaten && selectedKabupaten.kecamatan) {
            const kecamatanNames = selectedKabupaten.kecamatan.map(kec => kec.name);
            populateSelect(kecamatanSelect, kecamatanNames);
        }
    });

    // Kecamatan change event
    kecamatanSelect.addEventListener('change', function() {
        const selectedKabupaten = dataWilayah.find(kab => kab.name === kabupatenSelect.value);
        if (!selectedKabupaten) return;

        const selectedKecamatan = selectedKabupaten.kecamatan.find(kec => kec.name === this.value);
        
        // Reset kelurahan
        resetSelect(kelurahanSelect, '-- Pilih Kelurahan --');

        if (selectedKecamatan && selectedKecamatan.kelurahan) {
            populateSelect(kelurahanSelect, selectedKecamatan.kelurahan);
        }
    });

    // Set old values if they exist
    const oldKabupaten = '{{ old('kabupaten') }}';
    const oldKecamatan = '{{ old('kecamatan') }}';
    const oldKelurahan = '{{ old('kelurahan') }}';

    if (oldKabupaten) {
        kabupatenSelect.value = oldKabupaten;
        kabupatenSelect.dispatchEvent(new Event('change'));
        
        if (oldKecamatan) {
            setTimeout(() => {
                kecamatanSelect.value = oldKecamatan;
                kecamatanSelect.dispatchEvent(new Event('change'));
                
                if (oldKelurahan) {
                    setTimeout(() => {
                        kelurahanSelect.value = oldKelurahan;
                    }, 100);
                }
            }, 100);
        }
    }
})(); // End of IIFE
</script>
@endsection 