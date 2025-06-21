@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Edit Pengguna</h1>
    </div>
</div>

<div class="container px-4 py-8 mx-auto">
    <div class="max-w-4xl p-8 mx-auto bg-white rounded-xl shadow-md">
        <form method="POST" action="{{ route('manajemen.pengguna.update', $user->id_user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block mb-1 font-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" placeholder="Masukkan Nama Lengkap"
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
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" class="accent-blue-500" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} required>
                            <span>Laki-Laki</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="accent-blue-500" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
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
                        <option value="">-- Pilih Kabupaten --</option>
                        @foreach ($wilayah['kabupaten'] as $kab)
                        <option value="{{ $kab['name'] }}" {{ old('kabupaten', $user->kabupaten) == $kab['name'] ? 'selected' : '' }}>{{ $kab['name'] }}</option>
                        @endforeach
                    </select>
                    @error('kabupaten')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email"
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
                    <input type="text" name="telp" value="{{ old('telp', $user->telp) }}" placeholder="Masukkan Nomor HP"
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
                    <label class="block mb-1 font-semibold">Kata Sandi (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" placeholder="Masukkan Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block mb-1 font-semibold">Alamat</label>
                    <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap', $user->alamat_lengkap) }}" placeholder="Masukkan Alamat"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('alamat_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block mb-1 font-semibold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- NIK -->
                <div>
                    <label class="block mb-1 font-semibold">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" placeholder="Masukkan NIK"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIB -->
                <div>
                    <label class="block mb-1 font-semibold">NIB (Nomor Induk Berusaha)</label>
                    <input type="text" name="nib" value="{{ old('nib', $user->nib) }}" placeholder="Masukkan NIB (Opsional)"
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataWilayah = @json($wilayah);
    let selectedKabupaten = null;

    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const kelurahanSelect = document.getElementById('kelurahan');

    // Check if elements exist before proceeding
    if (!kabupatenSelect || !kecamatanSelect || !kelurahanSelect) {
        console.error('Required select elements not found');
        return;
    }

    // Debug: Log initial data
    console.log('Initial dataWilayah:', dataWilayah);

    // Inisialisasi dropdowns
    kecamatanSelect.disabled = true;
    kelurahanSelect.disabled = true;

    kabupatenSelect.addEventListener('change', function() {
        console.log('Kabupaten changed to:', this.value);
        selectedKabupaten = dataWilayah.kabupaten.find(kab => kab.name === this.value);
        console.log('Selected kabupaten data:', selectedKabupaten);
        
        kecamatanSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
        kelurahanSelect.disabled = true;

        if (selectedKabupaten) {
            selectedKabupaten.kecamatan.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec.name;
                opt.textContent = kec.name;
                if (kec.name === '{{ old('kecamatan', $user->kecamatan) }}') {
                    opt.selected = true;
                }
                kecamatanSelect.appendChild(opt);
            });
            kecamatanSelect.disabled = false;
        } else {
            kecamatanSelect.disabled = true;
        }
    });

    kecamatanSelect.addEventListener('change', function() {
        console.log('Kecamatan changed to:', this.value);
        console.log('Current selectedKabupaten:', selectedKabupaten);
        
        if (!selectedKabupaten) {
            console.log('No kabupaten selected');
            return;
        }

        const selectedKec = selectedKabupaten.kecamatan.find(kec => kec.name === this.value);
        console.log('Selected kecamatan data:', selectedKec);

        kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';

        if (selectedKec && selectedKec.kelurahan) {
            console.log('Found kelurahan data:', selectedKec.kelurahan);
            
            selectedKec.kelurahan.forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = kel;
                if (kel === '{{ old('kelurahan', $user->kelurahan) }}') {
                    opt.selected = true;
                }
                kelurahanSelect.appendChild(opt);
            });
            kelurahanSelect.disabled = false;
        } else {
            console.log('No kelurahan data found');
            kelurahanSelect.disabled = true;
        }
    });

    // Set nilai awal jika ada data old
    if (kabupatenSelect.value) {
        kabupatenSelect.dispatchEvent(new Event('change'));
        if (kecamatanSelect.value) {
            kecamatanSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endsection 