@extends('layouts.admin')

@section('title', 'Edit Pengguna Disdag')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Edit Data Admin</h1>
    </div>
</div>

<div class="container px-4 py-8 mx-auto">
    <div class="max-w-4xl p-8 mx-auto bg-white shadow-md rounded-xl">
        <form method="POST" action="{{ route('manajemen.admin.update', $user->id_disdag) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- NIP -->
                <div>
                    <label class="block mb-1 font-semibold">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="Masukkan NIP"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        pattern="[0-9]*" 
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        maxlength="18"
                        required>
                    @error('nip')
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

                <!-- No HP -->
                <div>
                    <label class="block mb-1 font-semibold">Nomor HP</label>
                    <input type="text" name="telp" value="{{ old('telp', $user->telp) }}" placeholder="Masukkan Nomor HP"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('telp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block mb-1 font-semibold">Role</label>
                    <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="master_admin" {{ old('role', $user->role) == 'master_admin' ? 'selected' : '' }}>Master Admin</option>
                        <option value="admin_perdagangan" {{ old('role', $user->role) == 'admin_perdagangan' ? 'selected' : '' }}>Admin Perdagangan</option>
                        <option value="admin_industri" {{ old('role', $user->role) == 'admin_industri' ? 'selected' : '' }}>Admin Industri</option>
                        <option value="admin_metrologi" {{ old('role', $user->role) == 'admin_metrologi' ? 'selected' : '' }}>Admin Metrologi</option>
                        <option value="kabid_perdagangan" {{ old('role', $user->role) == 'kabid_perdagangan' ? 'selected' : '' }}>Kabid Perdagangan</option>
                        <option value="kabid_industri" {{ old('role', $user->role) == 'kabid_industri' ? 'selected' : '' }}>Kabid Industri</option>
                        <option value="kabid_metrologi" {{ old('role', $user->role) == 'kabid_metrologi' ? 'selected' : '' }}>Kabid Metrologi</option>
                        <option value="kepala_dinas" {{ old('role', $user->role) == 'kepala_dinas' ? 'selected' : '' }}>Kepala Dinas</option>
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 