<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar - Sobat Dagang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body class="flex h-screen font-sans bg-primary">
    <div class="flex flex-col w-full h-full sm:flex-row">

        <div class="w-full sm:w-2/3 bg-white p-8 flex flex-col justify-center items-center rounded-[40px] sm:rounded-br-[40px] sm:rounded-tr-[40px] sm:rounded-tl-none sm:rounded-bl-none shadow-xl">
            <h3 class="mb-6 text-2xl font-bold text-center">Daftar ke Akun Anda</h3>

            @if(session('success'))
            <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <ul class="text-sm list-disc pl-5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="w-full max-w-2xl">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">

                    <div>
                        <label class="block mb-1 font-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan Nama Lengkap Anda"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Jenis Kelamin</label>
                        <div class="flex items-center gap-6 mt-1">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="accent-blue-500" required>
                                <span>Laki-Laki</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="accent-blue-500">
                                <span>Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Kabupaten/Kota</label>
                        <select id="kabupaten" name="kabupaten" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kabupaten</option>
                            @foreach ($wilayah['kabupaten'] as $kab)
                                <option value="{{ $kab['name'] }}">{{ $kab['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Email</label>
                        <input type="email" name="email" placeholder="Masukkan Email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">--Pilih Kecamatan--</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Nomor HP</label>
                        <input type="text" name="telp" placeholder="Masukkan Nomor HP"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Kelurahan</label>
                        <select id="kelurahan" name="kelurahan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>
                    </div>

                    <div class="relative">
                        <label class="block font-semibold">Kata Sandi</label>
                        <input type="password" name="password" placeholder="Masukkan Kata Sandi"
                            class="w-full pr-10 px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <i class="fa-regular fa-eye absolute right-4 top-1/2 cursor-pointer text-gray-500 toggle-password"></i>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Alamat</label>
                        <input type="text" name="alamat_lengkap" placeholder="Masukkan Alamat Anda"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="relative">
                        <label class="block  font-semibold">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi Kata Sandi"
                            class="w-full pr-10 px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <i class="fa-regular fa-eye absolute right-4 top-1/2 cursor-pointer text-gray-500 toggle-password"></i>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">NIK</label>
                        <input type="text" name="nik" placeholder="Masukkan NIK Anda"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">NIB (Opsional)</label>
                        <input type="text" name="nib" placeholder="Masukkan NIB Anda (Opsional)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-center col-span-2 mt-6">
                    <button type="submit"
                        class="w-[150px] bg-secondary hover:bg-[var(--secondary-dark)] text-white font-semibold py-2 rounded-full shadow transition duration-200">
                        Daftar
                    </button>
                </div>
            </form>
        </div>

        <!-- Kanan -->
        <div class="flex flex-col items-center justify-center w-full p-8 sm:w-1/2 bg-primary text-white">
            <div class="mt-6 mb-6">
                <img src="{{ asset('/assets/img/icon/logo.png') }}" alt="Logo" class="w-28 mx-auto">
            </div>
            
            <div id="alertBox" class="hidden text-center text-sm text-red-600 w-[300px] mx-auto"></div>
            <div class="flex flex-col items-center justify-center h-full text-center text-white">
                <h2 class="mb-2 text-2xl font-bold">Selamat Datang Kembali!</h2>
                <p class="mb-4">Masukkan informasi akun Anda untuk melanjutkan!</p>
                <a href="{{ route('login') }}"
                            class="block text-center w-[150px] text-white font-semibold py-2 -mt-33 rounded-full shadow transition duration-200"
                            style="background-color: rgba(33, 148, 243, 1);"
                            onmouseover="this.style.backgroundColor='rgba(81, 161, 227, 1)';"
                            onmouseout="this.style.backgroundColor='rgba(33, 148, 243, 1)';">
                            Masuk
                        </a>
            </div>
        </div>
    </div>

    <script>
        const dataWilayah = @json($wilayah['kabupaten']);

        const kabupatenSelect = document.getElementById('kabupaten');
        const kecamatanSelect = document.getElementById('kecamatan');
        const kelurahanSelect = document.getElementById('kelurahan');

        kabupatenSelect.addEventListener('change', function() {
            const selectedKab = dataWilayah.find(kab => kab.name === this.value);
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            kelurahanSelect.disabled = true;

            if (selectedKab) {
                selectedKab.kecamatan.forEach(kec => {
                    const opt = document.createElement('option');
                    opt.value = kec.name;
                    opt.textContent = kec.name;
                    kecamatanSelect.appendChild(opt);
                });
                kecamatanSelect.disabled = false;
            } else {
                kecamatanSelect.disabled = true;
            }
        });

        kecamatanSelect.addEventListener('change', function() {
            const selectedKab = dataWilayah.find(kab => kab.name === kabupatenSelect.value);
            const selectedKec = selectedKab?.kecamatan.find(kec => kec.name === this.value);

            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

            if (selectedKec) {
                selectedKec.kelurahan.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel;
                    opt.textContent = kel;
                    kelurahanSelect.appendChild(opt);
                });
                kelurahanSelect.disabled = false;
            } else {
                kelurahanSelect.disabled = true;
            }
        });
        // Toggle password
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const input = this.previousElementSibling;
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = "password";
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });

        const form = document.querySelector('form');
        const alertBox = document.getElementById('alertBox');

        form.addEventListener('submit', function (e) {
            const password = form.querySelector('input[name="password"]').value;
            const confirm = form.querySelector('input[name="password_confirmation"]').value;

            const valid = password.length >= 8 && /[a-zA-Z]/.test(password) 
            && /\d/.test(password) && /[^a-zA-Z0-9]/.test(password);

            if (!valid) {
                e.preventDefault();
                alertBox.textContent = 'Password harus minimal 8 karakter dan mengandung huruf, angka, serta simbol.';
                alertBox.classList.remove('hidden');
                return;
            }

            if (password !== confirm) {
                e.preventDefault();
                alertBox.textContent = 'Konfirmasi password tidak cocok.';
                alertBox.classList.remove('hidden');
                return;
            }

            alertBox.classList.add('hidden');
        });
    </script>

</body>

</html>
