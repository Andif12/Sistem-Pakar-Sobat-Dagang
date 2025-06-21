@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Bidang Industri')</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link rel="icon" href="{{ asset('assets/img/icon/logoIcon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body x-data="{ open: true }" class="bg-gray-100 font-sans overflow-auto">


    @include('component.navbar.adminPerindustrian')

    <!-- Main Content Area -->
    <div :class="open ? 'ml-64' : 'ml-20'" class="flex-1 relative z-0 p-0 overflow-y-auto transition-all duration-300">
        @yield('content')
    </div>

    @yield('scripts')


</body>

</html>
