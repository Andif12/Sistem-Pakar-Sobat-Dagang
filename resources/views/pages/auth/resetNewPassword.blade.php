<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Kata Sandi Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="bg-primary min-h-screen flex flex-col justify-center items-center text-white">
    <div>
    <a href="{{ route('login') }}"
      class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
      <span class="text-2xl material-symbols-outlined">
          arrow_back
      </span>
    </a>
    </div>
  <div class="mb-6">
    <img src="{{ asset('/assets/img/icon/logo.png') }}" alt="Logo Dinas Perdagangan" class="w-32 mx-auto">
  </div>

  <div class="w-full max-w-md bg-primary p-6 text-white">
    <h1 class="text-2xl font-bold text-center mb-4">Reset Kata Sandi Baru</h1>
    <form action="{{ route('password.updateNew') }}" method="POST">
      @csrf

      <div class="mb-4 relative">
        <label for="password" class="block mb-1 font-semibold">Kata Sandi Baru</label>
        <input type="password" id="password" name="password"
               class="w-full pl-4 pr-10 py-2 rounded-full text-black focus:ring-2 focus:ring-blue-400"
               placeholder="Masukkan kata sandi baru">
        <span onclick="togglePassword('password', this)" class="absolute right-3 top-[38px] cursor-pointer text-gray-500">
          <i class="fa-solid fa-eye"></i>
        </span>
        @error('password')
          <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4 relative">
        <label for="password_confirmation" class="block mb-1 font-semibold">Konfirmasi Kata Sandi Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="w-full pl-4 pr-10 py-2 rounded-full text-black focus:ring-2 focus:ring-blue-400"
               placeholder="Ulangi kata sandi baru">
        <span onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-[38px] cursor-pointer text-gray-500">
          <i class="fa-solid fa-eye"></i>
        </span>
      </div>

      <div class="flex justify-center">
        <button type="submit" class="bg-secondary hover:bg-[var(--secondary-dark)] text-white px-6 py-2 rounded-full font-semibold">
          Simpan Kata Sandi
        </button>
      </div>
    </form>
  </div>

  <script>
    function togglePassword(id, el) {
      const input = document.getElementById(id);
      const icon = el.querySelector('i');
      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }
  </script>
</body>
</html>
