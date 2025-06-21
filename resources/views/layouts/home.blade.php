@php
use Illuminate\Support\Facades\Auth;
$user = Auth::guard('user')->user();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sobat Dagang')</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link rel="icon" href="{{ asset('assets/img/icon/logoIcon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</head>

<body>
    @if ($user)
    @include('component.navbar.user')
    @else
    @include('component.navbar.guest')
    @endif

    <main>
        @yield('content')
    </main>

    @include('component.footer')
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script type="module" src="app.js"></script>
</body>

</html>