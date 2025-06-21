<nav class="navbar" style="font-family: 'Poppins', sans-serif;">
    <div class="flex items-center justify-between w-full md:w-auto">
    <div class="navbar-left">
        <a href="/">
            <img src="{{ asset('assets/img/icon/logo.png') }}" alt="Logo" class="logo">
        </a>
    </div>

    <div class="burger-menu md:hidden">
        <button id="burger-btn" class="focus:outline-none">
            <svg class="w-6 h-6  text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
    </div>
    <div id="nav-menu" class="navbar-center hidden md:flex flex-col md:flex-row md:items-center md:space-x-6">
        <ul class="nav-menu flex flex-col md:flex-row">
            <li><a href="https://peraturan.bpk.go.id/"><strong>REGULASI</strong></a></li>
            <li><a href="{{ route('about') }}"><strong>ABOUT US</strong></a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle"><strong>PELAYANAN</strong> <span class="dropdown-icon">▼</span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <a href="#"><strong>PERDAGANGAN</strong></a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('bidangPerdagangan.formPermohonan') }}">
                                    <strong>Permohonan Perizinan/Non Perizinan</strong>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#"><strong>INDUSTRI</strong></a>
                        <ul class="submenu">
                            <li><a href="{{route('bidangIndustri.formPermohonan')}}"><strong>Permohonan IKM Binaan</strong></a></li>
                            <li><a href="{{route('halal.user')}}"><strong>Data Sertifikat Halal</strong></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#"><strong>METROLOGI</strong></a>
                        <ul class="submenu">
                            <li><a href="{{ route('administrasi-metrologi') }}"><strong>Permohonan Tera/Teraulang</strong></a></li>
                            <li><a href="{{ route('directory-metrologi') }}"><strong>Alat Milik Saya</strong></a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li><a href="{{ route('pelaporan') }}"><strong>PELAPORAN</strong></a></li>
            <li><a href="{{ route('faq') }}" id="open-chat"><strong>FAQ</strong></a></li>
            <div class="navbar-right mt-4 md:mt-0 md:hidden">
                <a href="{{ route('login') }}" class="btn-login"><strong>Login</strong></a>
            </div>
        </ul>
    </div>

    <div class="navbar-right hidden md:block">
        <a href="{{ route('login') }}" class="btn-login"><strong>Login</strong></a>
    </div>
</nav>
<script>
    const burgerBtn = document.getElementById('burger-btn');
    const navMenu = document.getElementById('nav-menu');

    burgerBtn.addEventListener('click', () => {
        navMenu.classList.toggle('hidden');
    });
</script>