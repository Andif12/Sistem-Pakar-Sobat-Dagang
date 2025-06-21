<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="bg-[#0d3b66] flex items-center justify-center min-h-screen px-4">
    <div>
        <div>
            <a href="{{ route('login') }}"
            class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
            <span class="text-2xl material-symbols-outlined">
                arrow_back
            </span>
            </a>
        </div>
        <!-- Header -->
        <div class="text-center mb-6">
            <img src="{{ asset('/assets/img/icon/logo.png') }}" alt="Logo Dinas Perdagangan" class="h-14 mx-auto mb-3">
            <h2 class="text-2xl font-bold text-white">Reset Kata Sandi</h2>
            <p class="text-sm text-white">Masukkan password baru Anda di bawah ini</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5" onsubmit="return validatePasswords()">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-white mb-1">Password Baru</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <span onclick="togglePassword('password', this)" class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <span onclick="togglePassword('password_confirmation', this)" class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500">
                        <i class="fa-solid fa-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Alert -->
            <div id="alertBox" class="hidden text-sm text-red-600 text-center"></div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-secondary hover:bg-[var(--secondary-dark)] text-white font-semibold py-2 rounded-full transition">
                Reset Password
            </button>
        </form>
    </div>

    <!-- Scripts -->
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const alertBox = document.getElementById('alertBox');

            const minLength = 8;
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSymbol = /[^a-zA-Z0-9]/.test(password);

            if (password.length < minLength) {
                alertBox.innerText = "Password minimal harus 8 karakter.";
                alertBox.classList.remove("hidden");
                return false;
            }

            if (!hasLetter || !hasNumber || !hasSymbol) {
                alertBox.innerText = "Password harus mengandung huruf, angka, dan simbol.";
                alertBox.classList.remove("hidden");
                return false;
            }

            if (password !== confirmation) {
                alertBox.innerText = "Konfirmasi password tidak cocok.";
                alertBox.classList.remove("hidden");
                return false;
            }

            alertBox.classList.add("hidden");
            return true;
        }

    </script>
</body>
</html>