@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Tambah Admin Baru</h1>
    </div>
</div>

<div class="container px-4 py-8 mx-auto">
    <div class="max-w-4xl p-8 mx-auto bg-white shadow-md rounded-xl">
        <form method="POST" action="{{ route('manajemen.admin.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                
                <!-- NIP -->
                <div>
                    <label class="block mb-1 font-semibold">NIP</label>
                    <input type="text" id="nip" name="nip" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required> 
                    @error('nip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" id="email_edit" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label class="block mb-1 font-semibold">Nomor HP</label>
                    <input type="text" id="phone_edit" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block mb-1 font-semibold">Role</label>
                    <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="master_admin">Master Admin</option>
                        <option value="admin_perdagangan">Admin Perdagangan</option>
                        <option value="admin_industri">Admin Industri</option>
                        <option value="admin_metrologi">Admin Metrologi</option>
                        <option value="kabid_perdagangan">Kabid Perdagangan</option>
                        <option value="kabid_industri">Kabid Industri</option>
                        <option value="kabid_metrologi">Kabid Metrologi</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 font-semibold">Kata Sandi (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" placeholder="Masukkan Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block mb-1 font-semibold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <!-- Tombol -->
            <div class="flex justify-center gap-4 mt-8">
                <a href="{{ route('manajemen.admin') }}" 
                   class="px-6 py-2 text-gray-600 bg-gray-200 rounded-full hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 text-white bg-[#083358] rounded-full hover:bg-[#062a47]">
                    Tambahkan
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