@auth('user')

<nav class="navbar w-full px-4 py-2 text-white bg-[#083358]" style="font-family: 'Poppins', sans-serif;" x-data="{ showProfile: false, menuOpen: false }">
    <div class="flex flex-col w-full md:flex-row md:items-center md:justify-between">
        <div class="flex items-center w-full md:w-auto">
            <a href="{{ route('user.dashboard') }}">
                <img src="{{ asset('assets/img/icon/logo.png') }}" alt="Logo" class="h-10">
            </a>

            <div class="flex items-center ml-auto space-x-4 md:hidden">
                <button aria-label="Profil" class="focus:outline-none" @click="showProfile = true">
                    @php
                        $avatarPath = $user->avatar && file_exists(public_path('storage/foto_profil/' . $user->avatar))
                            ? asset('storage/foto_profil/' . $user->avatar)
                            : "https://ui-avatars.com/api/?name=" . urlencode($user->nama) . "&background=0D8ABC&color=fff";
                    @endphp

                    <img src="{{ $avatarPath }}" alt="Foto Profil"
                        class="object-cover border-2 border-white rounded-full h-7 w-7 hover:opacity-80">
                </button>
            </div>

            <button id="burger-btn" class="ml-4 md:hidden focus:outline-none">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
            
        <div id="nav-menu" class="flex-col hidden navbar-center md:flex md:flex-row md:items-center md:space-x-6">
            <ul class="flex flex-col nav-menu md:flex-row">
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
                                <li><a href="{{ route('administrasi-metrologi') }}"><strong>Permohonan Tera/Tera ulang</strong></a></li>
                                <li><a href="{{ route('directory-metrologi') }}"><strong>Alat Ukur Valid</strong></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                    <li><a href="{{ route('pelaporan') }}"><strong>PELAPORAN</strong></a></li>
                    <li><a href="{{ route('faq') }}" id="open-chat"><strong>FAQ</strong></a></li>    
                </ul>
            </div>

        <div class="items-center hidden space-x-4 md:flex">
            <button @click="showProfile = true" class="focus:outline-none">
                @php
                    $avatarPath = $user->avatar && file_exists(public_path('storage/foto_profil/' . $user->avatar))
                        ? asset('storage/foto_profil/' . $user->avatar)
                        : "https://ui-avatars.com/api/?name=" . urlencode($user->nama) . "&background=0D8ABC&color=fff";
                @endphp

                <img src="{{ $avatarPath }}" alt="Foto Profil"
                    class="object-cover border-2 border-white rounded-full h-7 w-7 hover:opacity-80">
            </button>
        </div>
        </div>
    </div>
    <!-- Modal Profil -->
    <div
        x-show="showProfile"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        @click.outside="showProfile = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60"
        style="display: none;">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto p-6 relative mx-4">
            <button @click="showProfile = false"
                class="absolute text-2xl font-bold text-gray-600 top-3 right-3 hover:text-gray-900 focus:outline-none">
                &times;
            </button>

            <h2 class="mb-2 text-lg font-semibold text-center text-black">Profile Anda</h2>

            @php
                $avatarPath = $user->avatar && file_exists(public_path('storage/foto_profil/' . $user->avatar))
                    ? asset('storage/foto_profil/' . $user->avatar)
                    : "https://ui-avatars.com/api/?name=" . urlencode($user->nama) . "&background=0D8ABC&color=fff";
            @endphp

            <img src="{{ $avatarPath }}" alt="Foto Profil"
                class="object-cover w-20 h-20 mx-auto mb-4 rounded-full">

            <div class="max-w-md px-6 py-2 mx-auto mt-2 overflow-hidden text-left bg-white rounded-lg shadow-md">
                <h3 class="mb-4 text-xl font-bold text-center text-gray-900 capitalize break-words break-all">
                    {{ ucfirst(strtolower($user->nama ?? '-')) }}
                </h3>
                <div class="space-y-3 text-sm text-gray-700">
                    @php
                        $info = [
                            'NIK' => $user->nik ?? '-',
                            'Alamat Lengkap' => $user->alamat_lengkap ?? '-',
                            'Jenis Kelamin' => $user->jenis_kelamin ?? '-',
                            'Email' => $user->email ?? '-',
                            'Telepon' => $user->telp ?? '-',
                        ];
                    @endphp

                    @foreach ($info as $label => $value)
                        <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-1 sm:gap-4 items-start capitalize">
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-gray-800 break-words sm:block">
                                <span>{{ $label }}</span>
                                <span class="sm:hidden">:</span>
                            </span>
                            <span class="break-all w-full block text-sm relative sm:before:content-[':'] sm:before:absolute sm:before:-left-2 sm:pl-4">
                                {{ $value }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="px-4 mt-6 space-y-4 text-left">
                <a href="{{ route('change.password') }}"
                class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">🔑</span>
                        <span class="text-sm font-medium text-black">Ubah Kata Sandi</span>
                    </div>
                    <span class="text-xl text-black">›</span>
                </a>
                <a href="{{ route('edit.profile') }}"
                class="flex items-center justify-between w-full p-3 border border-gray-200 rounded-lg hover:bg-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">👤</span>
                        <span class="text-sm font-medium text-black">Edit Profil</span>
                    </div>
                    <span class="text-xl text-black">›</span>
                </a>
            </div>

            <div class="pt-4 mt-6 text-center border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 text-white bg-red-600 rounded hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('burger-btn').addEventListener('click', function() {
        const navMenu = document.getElementById('nav-menu');
        navMenu.classList.toggle('hidden');
    });
</script>
@endauth    