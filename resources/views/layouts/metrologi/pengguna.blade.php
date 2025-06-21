<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.7/dist/sweetalert2.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-100">
    @include('component.navbar.user')
    
    <div class="relative">
        <!-- Gambar Background -->
        <div class="h-[150px] w-full bg-cover bg-[center_87%] relative"
            style="background-image: url('/assets/img/background/user_metrologi.png');">

            <!-- Tombol Kembali -->
            <a href="{{ url('/user/dashboard') }}"
                class="absolute z-10 inline-flex items-center justify-center w-10 h-10 text-white top-4 left-4 hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Tombol Tab -->
            @yield('tab')
        </div>
    </div>

    {{-- Konten utama --}}
    <main class="flex-grow relative mx-5 md:mx-20 p-6 rounded-lg min-h-[calc(100vh-250px)]">
        @yield('content')
    </main>

    <div class="z-10">
        @include('component.footer')
    </div>
    
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/filter.js') }}"></script>
    <script src="{{ asset('/assets/js/showDokumen.js') }}"></script>
</body>

</html>