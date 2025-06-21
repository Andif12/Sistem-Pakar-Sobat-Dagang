<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Kata Sandi - Sobat Dagang</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-primary min-h-screen flex flex-col justify-center items-center font-sans">
  <div>
    <a href="{{ route('login') }}"
      class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
      <span class="text-2xl material-symbols-outlined">
          arrow_back
      </span>
    </a>
  </div>
  <div class="mb-8">
    <img src="{{ asset('/assets/img/icon/logo.png') }}" alt="Logo Dinas Perdagangan" class="w-32 mx-auto">
  </div>

  <div class="w-full max-w-md bg-primary text-white p-6 flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-2 text-center">Lupa Kata Sandi?</h1>
    <p class="text-center mb-6 text-sm">Masukkan Email Anda untuk melakukan reset kata sandi</p>

    @if (session('status'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm w-full text-center">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm w-full">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="w-full mt-5">
      @csrf

    <div class="mb-4 w-full flex justify-center">
      <div class="w-full max-w-[350px]">
        <label for="email" class="block mb-1 font-semibold">Email</label>
        <div class="relative">
          <input type="email" id="email" name="email" placeholder="Masukkan Email Anda"
            class="w-full pl-4 pr-10 py-2 rounded-full text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <div class="absolute inset-y-0 right-3 flex items-center text-gray-400">
            <i class="fas fa-envelope"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 w-full flex justify-center">
      <button type="submit"
        class="w-[100px] bg-secondary hover:bg-[var(--secondary-dark)] text-white font-semibold py-2 rounded-full transition">
        Lanjut
      </button>
    </div>
    </form>
  </div>

</body>
</html>