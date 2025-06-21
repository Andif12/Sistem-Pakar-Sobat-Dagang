<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi - Sobat Dagang</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
</head>
<body class="bg-primary min-h-screen flex flex-col justify-center items-center font-sans text-white">

    <div>
        <a href="{{ url()->previous() }}"
            class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
            <span class="text-2xl material-symbols-outlined">
                arrow_back
            </span>
        </a>
    </div>
    <div class="mb-6">
        <img src="{{ asset('/assets/img/icon/logo.png') }}" alt="Logo Dinas Perdagangan" class="w-32 mx-auto">
    </div>

    <div>
        <h1 class="text-2xl font-bold mb-2 text-center">Laman Verifikasi</h1>
        
        @if (isset($status))
            <p class="text-center mb-6 text-sm">{{ $status }}</p>
        @endif

        <div class="mt-6 w-full flex justify-center">
            <a href="{{ route('login') }}" class="w-[100px] text-center bg-secondary hover:bg-[var(--secondary-dark)] text-white font-semibold py-2 rounded-full transition">
                Login
            </a>
        </div>
    </div>
</body>
</html>