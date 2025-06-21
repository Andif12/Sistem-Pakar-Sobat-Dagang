@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('disdag')->user();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dinas Perdagangan')</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/app.css') }}">
    <link rel="icon" href="{{ asset('assets/img/icon/logoIcon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body x-data="{ open: true }" class="overflow-hidden font-sans relative bg-white">

    @if ($user)
        @switch($user->role)
            @case('master_admin')
                @include('component.navbar.adminMaster')
            @break

            @case('admin_perdagangan')
                @include('component.navbar.adminPerdagangan')
            @break

            @case('admin_industri')
                @include('component.navbar.adminPerindustrian')
            @break

            @case('admin_metrologi')
                @include('component.navbar.admin_metrologi')
            @break

            @case('kabid_perdagangan')
                @include('component.navbar.kabidPerdagangan')
            @break

            @case('kabid_industri')
                @include('component.navbar.kabidIndustri')
            @break

            @case('kabid_metrologi')
                @include('component.navbar.kabidMetrologi')
            @break

            @case('kepala_dinas')
                @include('component.navbar.kepalaDinas')
            @break

            @default
                @include('component.navbar.guest')
        @endswitch
    @else
        @include('component.navbar.guest')
    @endif

    <div class="relative z-0 flex-1 p-0 overflow-y-auto">
        @yield('content')
    </div>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="{{ asset('/assets/js/showDokumen.js') }}"></script>
    @stack('modals')
    @stack('scripts')
</body>

</html>
