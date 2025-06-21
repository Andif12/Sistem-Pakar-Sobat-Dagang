@extends('layouts.home')
@section('title', 'Edit Profil')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-pink-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl p-8 bg-white/40 backdrop-blur-md shadow-2xl rounded-3xl border border-white/30 transition-all">

        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#083358] hover:bg-blue-300 hover:text-black rounded-lg shadow transition-all duration-300">
                ← Kembali
            </a>
        </div>

        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">Edit Profil</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col items-center">
                @php
                    $avatarPath = $user->avatar && file_exists(public_path('storage/foto_profil/' . $user->avatar))
                        ? asset('storage/foto_profil/' . $user->avatar)
                        : "https://ui-avatars.com/api/?name=" . urlencode($user->nama) . "&background=0D8ABC&color=fff";
                @endphp

                <div class="relative group w-28 h-28">
                    <img id="preview" src="{{ $avatarPath }}" alt="Foto Profil"
                         class="rounded-full object-cover w-28 h-28 border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-110">
                </div>
                <div class="mt-4 w-full">
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*"
                           onchange="previewImage(event)"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#083358] hover:file:bg-blue-100">
                    <p class="text-sm text-gray-500">Maksimal ukuran file 500KB.</p>
                    <p id="avatarError" class="text-sm text-red-600 mt-1">@error('avatar'){{ $message }}@enderror</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <div class="relative">
                        <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" required oninput="validateNik(this)"
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                        <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-id-card"></i></span>
                    </div>
                    <p id="nikError" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <div class="relative">
                        <input type="text" id="nama" name="nama" value="{{ old('nama', ucfirst(strtolower($user->nama))) }}"
                                required oninput="validateUsername(this)"
                               class="capitalize w-full pl-10 pr-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                        <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-user"></i></span>
                    </div>
                    <p id="usernameError" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required oninput="validateEmail(this)"
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                        <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-envelope"></i></span>
                    </div>
                    <p id="emailError" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                <div>
                    <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <div class="relative">
                        <input type="text" id="telp" name="telp" value="{{ old('telp', $user->telp) }}" oninput="validateTelp(this)"
                               class="w-full pl-10 pr-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                        <span class="absolute left-3 top-2.5 text-gray-400"><i class="fas fa-phone-alt"></i></span>
                    </div>
                    <p id="telpError" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full px-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="nib" class="block text-sm font-medium text-gray-700 mb-1">NIB (Opsional)</label>
                    <input type="text" name="nib" id="nib" value="{{ old('nib', $user->nib) }}" oninput="validateNIB(this)"
                           class="w-full px-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                    <p id="nibError" class="mt-1 text-sm text-red-500 hidden"></p>
                </div>
            </div>

            <div>
                <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3"
                          class="capitalize w-full px-4 py-2 rounded-lg bg-white/60 border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
            </div>

            <div class="text-center pt-4">
                <button type="submit"
                        class="px-6 py-3 text-white font-bold rounded bg-[#083358] hover:bg-blue-300 hover:text-black transition-all duration-300 shadow-lg">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const maxSize = 500 * 1024;
        const errorBox = document.getElementById('avatarError');

        if (file && file.size > maxSize) {
            errorBox.innerText = "Ukuran gambar maksimal 500KB.";
            event.target.value = "";
        } else {
            errorBox.innerText = "";
            const reader = new FileReader();
            reader.onload = () => {
                document.getElementById('preview').src = reader.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function validateEmail(input) {
        const value = input.value.trim();
        const error = document.getElementById('emailError');
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        error.innerText = value === '' ? 'Email wajib diisi.' : (!regex.test(value) ? 'Format email tidak valid.' : '');
        error.classList.toggle('hidden', error.innerText === '');
    }

    function validateUsername(input) {
        const value = input.value.trim();
        const error = document.getElementById('usernameError');
        const regex = /^[a-zA-Z\s]+$/;
        if (value === '') {
            error.innerText = 'Nama tidak boleh kosong.';
        } else if (value.length < 3) {
            error.innerText = 'Nama minimal 3 karakter.';
        } else if (!regex.test(value)) {
            error.innerText = 'Nama hanya boleh huruf.';
        } else {
            error.innerText = '';
        }
        error.classList.toggle('hidden', error.innerText === '');
    }

    function validateTelp(input) {
        const value = input.value.trim();
        const error = document.getElementById('telpError');
        const regex = /^\d{10,15}$/;
        error.innerText = value && !regex.test(value) ? 'Nomor telepon harus 10-15 digit angka.' : '';
        error.classList.toggle('hidden', error.innerText === '');
    }

    function validateNik(input) {
        const value = input.value.trim();
        const error = document.getElementById('nikError');
        const regex = /^\d{16}$/;
        error.innerText = !regex.test(value) ? 'NIK harus terdiri dari 16 digit angka.' : '';
        error.classList.toggle('hidden', error.innerText === '');
    }

    function validateNIB(input) {
        const value = input.value.trim();
        const error = document.getElementById('nibError');
        const regex = /^\d{10,20}$/;

        if (value === '') {
            error.innerText = '';
            error.classList.add('hidden');
        } else if (!regex.test(value)) {
            error.innerText = 'NIB harus berupa angka dengan panjang 10-20 digit.';
            error.classList.remove('hidden');
        } else {
            error.innerText = '';
            error.classList.add('hidden');
        }
    }

</script>
@endsection
