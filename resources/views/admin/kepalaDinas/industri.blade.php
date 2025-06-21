@extends('layouts.metrologi.kadis')
@section('title', 'Dashboard Kadis Bidang Industri')

@section('content')
<div class="relative w-full h-32">
    <img src="{{ asset('assets/img/background/user_industri.png') }}" alt="Background" class="object-cover w-full h-full" />
    <div class="absolute bottom-0 w-full -left-4 h-60 -z-10">
        <img src="{{ asset('assets/img/background/user_industri.png') }}" alt="Background" class="object-cover w-full h-full -ml-16">
    </div>
    <a href="{{ route('dashboard-kadis') }}"
        class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:scale-110">
        <span class="text-2xl material-symbols-outlined">
            arrow_back
        </span>
    </a>
</div>
<div class="bg-white p-6 overflow-y-auto min-h-screen">
  <div>
      <div class="flex flex-col mt-0 sm:flex-row sm:space-x-6 space-y-6 sm:space-y-0 ">
        <!-- Jumlah Surat Balasan Card (Larger) -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <div class="text-5xl text-emerald-600 mb-2">📄</div>
          <p class="font-semibold text-lg mb-1 mt-0">Jumlah Surat Terverifikasi</p>
          <p class="font-extrabold text-3xl mb-1 mt-0">{{ $totalSuratTerverifikasi }}</p>
          <p class="text-base">Surat Permohonan Telah Diverifikasi </p>
        </div>
        <!-- Akumulasi Perkembangan Card (Smaller) -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <div class="text-5xl text-emerald-600 mb-2">🏭</div>
          <p class="font-semibold text-lg mb-1 flex items-center gap-2">Akumulasi Perkembangan IKM</p>
          <p class="font-extrabold text-3xl mb-1">{{ $akumulasiIKM ?? 0 }}</p>
          <p class="text-base">IKM Bertambah Hingga Bulan Ini</p>
        </div>
        <!-- Jumlah Data IKM -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <div class="text-5xl text-emerald-600 mb-2">💰</div>
          <p class="font-semibold text-lg mb-1 mt-0">Total Nilai Investasi</p>
          <p class="font-extrabold text-3xl mb-1 mt-0">Rp {{ number_format($totalInvestasi, 0, ',', '.') }}</p>
          <p class="text-base">Total Nilai Investasi Seluruh Industri</p>
        </div>
        <!-- Jumlah IKM Bersertifikasi HALAL -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <div class="text-5xl text-emerald-600 mb-2"><img src="{{ asset('assets/img/icon/halal.png') }}" alt="Ikon Halal" class="w-8 h-11"></div>
          <p class="font-semibold text-lg mb-1 mt-0">Jumlah IKM Bersertifikasi HALAL</p>
          <p class="font-extrabold text-3xl mb-1 mt-0">{{ $totalHalal }}</p>
          <p class="text-base">IKM telah memiliki sertifikasi Halal</p>
        </div>
      </div>
    
    <!-- Left Column: Dashboard Content -->
    <div>
      <div class="mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] max-h-[400px] mb-2 mt-6">
          <article class="bg-white rounded-xl p-4 h-[370px] flex flex-col">
            <h3 class="font-bold text-xl mb-4">Pertumbuhan IKM</h3>
            <div class="flex flex-col items-center">
              <canvas id="perkembanganChart" class="mb-2 w-300 h-250"></canvas>
            </div>
          </article>
        </div>
        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] max-h-[400px] mb-2 mt-6">
            <article class="bg-white rounded-xl p-4 h-[370px] flex flex-col">
              <h3 class="font-bold text-xl mb-4">Pertumbuhan IKM Bersertifikat Halal</h3>
              <div class="flex flex-col items-center">
                <canvas id="halalChart" class="mb-2 w-300 h-250"></canvas>
              </div>
            </article>
          </div>
      </div>
    </div>
    <!-- Right Column: Data IKM Content -->
    <div>
      <section class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
        <!-- Summary IKM -->
        <article class="bg-white rounded-xl p-4 sm:p-6 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] max-h-[400px] mb-2 mt-2">
          <h3 class="font-bold text-lg mb-2">Sebaran Jenis Industri</h3>
          <div class="flex flex-col items-center">
            <canvas id="distribusiPie" class="mb-3 w-64 h-64"></canvas>
            <ul class="w-full h-full grid grid-cols-5 text-sm text-[#000]">
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#5bc0f8] rounded-sm"></span> Sandang
              </li>
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#d9e9fb] rounded-sm"></span> Pangan
              </li>
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#ffcd56] rounded-sm"></span> Kerajinan
              </li>
              <li class="flex items-center gap-3">
                <span class="inline-block w-2 h-2 bg-[#f3f3f3] rounded-sm"></span> Logam & Elektronika
              </li>
              <li class="flex items-center gap-3">
                <span class="inline-block w-2 h-2 bg-[#1a1a1a] rounded-sm"></span> Kimia & Bahan Bangunan
              </li>
            </ul>
          </div>
        </article>
        <div class="bg-white rounded-xl p-4 sm:p-6 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] max-h-[400px] mb-2 mt-2">
          <article class="bg-white rounded-xl p-4 h-[370px] flex flex-col">
            <h3 class="font-bold text-xl mb-4">Perbandingan IKM Berdasarkan Investasi</h3>
            <div class="flex flex-col items-center">
              <canvas id="perbandinganChart" class="mb-2 w-300 h-250"></canvas>
            </div>
          </article>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
  // Pie Chart Distribusi Industri
  const distribusiCtx = document.getElementById('distribusiPie').getContext('2d');
  const labels = {!! json_encode($sebaranJenisIndustri->pluck('jenis_industri')) !!};
  const dataJumlah = {!! json_encode($sebaranJenisIndustri->pluck('jumlah')) !!};
  const total = {{ $totalIndustri }};
  const distribusiPie = new Chart(distribusiCtx, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        label: 'Sebaran Jenis Industri',
        data: dataJumlah,
        backgroundColor: ['#5bc0f8', '#d9e9fb', '#1a1a1a', '#f3f3f3', '#ffcd56'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: false,
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              let value = context.parsed;
              let percentage = (value / total * 100).toFixed(1);
              return context.label + ': ' + percentage + '% (' + value + ' IKM)';
            }
          }
        },
        legend: {
          display: false // Legend kan sudah kamu buat manual di <ul>
        }
      }
    }
  });

  // Line Chart Perkembangan Industri
  const perkembanganCtx = document.getElementById('perkembanganChart').getContext('2d');
  const perkembanganChart = new Chart(perkembanganCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($pertumbuhanIkm->pluck('tahun')) !!},
      datasets: [{
        label: 'Jumlah Industri',
        data: {!! json_encode($pertumbuhanIkm->pluck('jumlah')) !!}, 
        fill: false,
        borderColor: '#5bc0f8',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          position: 'bottom'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Line Chart Perkembangan IKM HALAL
  const halalCtx = document.getElementById('halalChart').getContext('2d');
  const halalChart = new Chart(halalCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($pertumbuhanHalal->pluck('tahun')) !!},
      datasets: [{
        label: 'Jumlah Industri',
        data: {!! json_encode($pertumbuhanHalal->pluck('jumlah')) !!},
        fill: false,
        borderColor: '#5bc0f8',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          position: 'bottom'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Bar Chart Perbandingan IKM
  const levelLabels = {!! json_encode(array_keys($levelInvestasi)) !!};
  const levelData = {!! json_encode(array_values($levelInvestasi)) !!};
  const perbandinganCtx = document.getElementById('perbandinganChart').getContext('2d');
  const perbandinganChart = new Chart(perbandinganCtx, {
    type: 'bar',
    data: {
      labels: levelLabels,
      datasets: [{
        label: 'Jumlah IKM',
        data: levelData, 
        backgroundColor: [
          'rgba(255, 206, 86, 0.7)',
          'rgba(255, 99, 132, 0.7)'
        ],
        borderColor: [
          'rgba(255, 206, 86, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false,
          // position: 'bottom'
          },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.parsed.y + ' IKM';
              }
            }
          }
        },
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Jumlah IKM'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Level IKM'
          }
        }
      }
    }
  });

</script>
@endsection