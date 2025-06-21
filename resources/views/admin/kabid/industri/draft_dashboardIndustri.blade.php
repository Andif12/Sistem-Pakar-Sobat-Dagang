@extends('layouts.admin')
@section('title', 'Dashboard Industri')

@section('content')
<div class="bg-white p-6 overflow-y-auto min-h-screen">
  <div class="mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
    <!-- Left Column: Dashboard Content -->
    <div>
      <div class="flex flex-col mt-0 sm:flex-row sm:space-x-6 space-y-6 sm:space-y-0 ">
        <!-- Jumlah Surat Balasan Card (Larger) -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <p class="font-semibold text-lg mb-1 mt-0">Jumlah Surat Terverifikasi</p>
          <p class="font-extrabold text-3xl mb-1 mt-0">{{ $totalSuratTerverifikasi }}</p>
          <p class="text-base">Surat Permohonan Telah Diverifikasi </p>
        </div>
        <!-- Akumulasi Perkembangan Card (Smaller) -->
        <div class="sm:w-[370px] p-4 bg-white rounded-xl shadow-[0_0_15px_3px_rgba(0,54,94,0.25)]">
          <p class="font-semibold text-lg mb-1 flex items-center gap-2">
            <i class="fas fa-file-alt"></i>
            Akumulasi Perkembangan
          </p>
          <p class="font-extrabold text-3xl mb-1">210</p>
          <p class="text-base">Hingga Bulan Ini</p>
        </div>
      </div>


      <div class="bg-white rounded-xl p-4 sm:p-6 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] max-h-[500px] mb-4 mt-6">
        <div class="max-h-[470px] overflow-y-auto overflow-x-hidden">
        <table class="w-full table-wrapper border-collapse border-spacing-0 text-[11px] rounded-t-xl">
        <thead class="sm:text-xs leading-4 sm:leading-5 rounded-t-xl">
          <tr>
            <th class="bg-[#00365e] sticky top-0 text-white text-[10px] font-bold px-2 py-2 rounded-tl-xl">NAMA USAHA</th>
            <th class="bg-[#00365e] sticky top-0 text-white text-[10px] font-bold px-2 py-2">NAMA PEMILIK</th>
            <th class="bg-[#00365e] sticky top-0 text-white text-[10px] font-bold px-2 py-2">NAMA PRODUK</th>
            <th class="bg-[#00365e] sticky top-0 text-white text-[10px] font-bold px-2 py-2 rounded-tr-xl">KECAMATAN</th>
          </tr>
        </thead>
        <tbody class="text-black text-[10px] sm:text-xs leading-4 sm:leading-5" id="data-industri"></tbody>
      </table>
      </div>
      </div>
    </div>

    <!-- Right Column: Data IKM Content -->
    <div>
      <!-- Dropdown for selecting Data IKM -->
      <select id="dataSelector" class="w-full bg-[#073763] text-white text-lg rounded-lg py-3 px-5 appearance-none relative" style="background-image: url('data:image/svg+xml;utf8,&lt;svg fill=\'white\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'&gt;&lt;path d=\'M7 10l5 5 5-5z\'/&gt;&lt;/svg&gt;'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25rem;">
        <option value="ikm">Data IKM</option>
        <option value="halal">Sertifikat Halal</option>
      </select>

      <!-- Filter container -->
      <section class="bg-white rounded-xl p-5 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] space-y-2 mt-6">
        <h2 class="font-bold text-lg flex items-center gap-2 text-[#073763]">
          <i class="fas fa-sliders-h"></i>
          Filter
        </h2>
        <form class="flex flex-col sm:flex-row gap-4">
          <div class="relative w-full">
              <div onclick="toggleDropdown()" class="flex items-center justify-between bg-[#CDE4F7] text-black px-4 py-2 rounded-lg w-full cursor-pointer hover:bg-[#b9daf2] transition-all duration-200">
                  <span id="selected-kecamatan">Soreang</span>
                  <span class="material-symbols-outlined text-sm text-gray-700">tune</span>
              </div>
              <div id="dropdown-kecamatan" class="hidden absolute top-full mt-2 left-0 w-full bg-white rounded-xl shadow-lg z-20 overflow-hidden border border-gray-200">
                  <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectKecamatan('Soreang')">Soreang</div>
                  <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectKecamatan('Bacukiki')">Bacukiki</div>
                  <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectKecamatan('Bacukiki Barat')">Bacukiki Barat</div>
                  <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectKecamatan('Ujung')">Ujung</div>
              </div>
          </div>
          <div class="relative w-full">
            <div onclick="toggleDropdowns()" class="flex items-center justify-between bg-[#CDE4F7] text-black px-4 py-2 rounded-lg w-full cursor-pointer hover:bg-[#b9daf2] transition-all duration-200">
              <span id="selected-level">Invenstasi</span>
              <span class="material-symbols-outlined text-sm text-gray-700">tune</span>
            </div>
            <div id="dropdown-level" class="hidden absolute top-full mt-2 left-0 w-full bg-white rounded-xl shadow-lg z-20 overflow-hidden border border-gray-200">
              <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectLevel('Kecil')">Kecil</div>
              <div class="hover:bg-blue-100 px-4 py-2 cursor-pointer text-gray-700" onclick="selectLevel('Menengah')">Menengah</div>
            </div>
        </div>
        </form>
      </section>

      <!-- Cards for stats: Industri Terdaftar and Informasi Tambahan -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
        <!-- Industri Terdaftar & Tenaga Kerja card -->
        <article class="bg-white rounded-xl p-4 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] h-[300px]  flex flex-col">
          <h3 class="font-bold text-lg flex items-center gap-2 mb-8 text-[#000]">
            <span>⚖</span>
              Industri Terdaftar
            </h3>
            <p class="text-[#073763] font-extrabold text-center text-6xl mb-1">0</p>
            <p class="text-[#073763] font-extrabold text-center text-3xl mb-6">Usaha</p>
            <h4 class="font-extrabold text-xl text-[#073763] mt-4">Tenaga Kerja</h4>
            <p id="tenagaKerjaSummary" class="flex items-center gap-2 text-[#073763] font-semibold">
              <span class="inline-block w-4 h-4 bg-[#5bc0f8] rounded-sm"></span>0<span class="text-sm">Laki-Laki</span>
              <span class="inline-block w-4 h-4 bg-[#f26c6c] rounded-sm"></span>0<span class="text-sm">Perempuan</span>
            </p>
        </article>
      
        <!-- Informasi Tambahan card -->
        <article class="bg-white rounded-xl p-4 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] h-[300px] flex flex-col">
          <h3 class="font-bold text-lg mb-2">Sebaran Jenis Industri</h3>
          <div class="flex flex-col items-center">
            <canvas id="distribusiPie" class="mb-3 w-32 h-32"></canvas>
            <ul class="w-full h-full grid grid-cols-3 text-sm text-[#000]">
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#5bc0f8] rounded-sm"></span> Sandang
              </li>
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#d9e9fb] rounded-sm"></span> Pangan
              </li>
              <li class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-[#ffcd56] rounded-sm"></span> Kerajinan
              </li>
            </ul>
            <ul class="w-full h-full grid grid-cols-2 text-sm text-[#000]">  
              <li class="flex items-center gap-3">
                <span class="inline-block w-2 h-2 bg-[#f3f3f3] rounded-sm"></span> Logam & Elektronika
              </li>
              <li class="flex items-center gap-3">
                <span class="inline-block w-2 h-2 bg-[#1a1a1a] rounded-sm"></span> Kimia & Bahan Bangunan
              </li>
            </ul>
          </div>
        </article>
      </section>
      <article class="bg-white rounded-xl p-4 shadow-[0_0_15px_3px_rgba(0,54,94,0.25)] mt-6 h-[400px] flex flex-col">
        <h3 class="font-bold text-xl mb-4">Pertumbuhan IKM</h3>
        <div class="flex flex-col items-center">
          <canvas id="perkembanganChart" class="mb-2 w-300 h-250"></canvas>
        </div>
      </article>
    </div>
    
    </div>
    
  </div>
</div>

<script>
  // Toggle dropdown kecamatan
  function toggleDropdown() {
    document.getElementById('dropdown-kecamatan').classList.toggle('hidden');
  }

  // Toggle dropdown level
  function toggleDropdowns() {
    document.getElementById('dropdown-level').classList.toggle('hidden');
  }

  // Pilih kecamatan
  function selectKecamatan(kecamatan) {
    document.getElementById('selected-kecamatan').textContent = kecamatan;
    toggleDropdown();
  }

  // Pilih level
  function selectLevel(level) {
    document.getElementById('selected-level').textContent = level;
    toggleDropdowns();
  }

  document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('dropdown-kecamatan');
    const trigger = document.querySelector('[onclick="toggleDropdown()"]');
    if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
  });

  document.addEventListener('click', function (e) {
    const dropdowns = document.getElementById('dropdown-level');
    const trigger = document.querySelector('[onclick="toggleDropdowns()"]');
    if (!dropdowns.contains(e.target) && !trigger.contains(e.target)) {
        dropdowns.classList.add('hidden');
    }
  });


  const chartData = {
    ikm: [25, 20, 15, 10, 30],
    halal: [10, 15, 20, 5, 50]
  };
  // Pie Chart Distribusi Industri
  const distribusiCtx = document.getElementById('distribusiPie').getContext('2d');
  const distribusiPie = new Chart(distribusiCtx, {
    type: 'pie',
    data: {
      labels: ['Sandang', 'Pangan', 'Kimia & Bahan Bangunan', 'Logam & Elektronika', 'Kerajinan'],
      datasets: [{
        data: chartData.ikm, // default IKM
        backgroundColor: ['#5bc0f8', '#d9e9fb', '#1a1a1a', '#f3f3f3', '#ffcd56'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: false,
      plugins: {
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
      labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
      datasets: [{
        label: 'Jumlah Industri',
        data: [201, 222, 289, 304, 320, 356], // Contoh data, bisa kamu ganti dari controller
        fill: false,
        borderColor: '#5bc0f8',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
  }
});

  document.getElementById('dataSelector').addEventListener('change', function () {
    const selected = this.value;
    
    // Ubah data Pie Chart sesuai pilihan
    distribusiPie.data.datasets[0].data = chartData[selected];
    distribusiPie.update();
  });

  document.addEventListener("DOMContentLoaded", function () {
  fetch("/json/data-industri.json")
    .then(response => {
      if (!response.ok) {
        throw new Error("Gagal memuat data");
      }
      return response.json();
    })
    .then(data => {
      const tableBody = document.getElementById("data-industri");
      tableBody.innerHTML = "";

      data.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td class="px-2 py-2">${item.nama_usaha}</td>
          <td class="px-2 py-2">${item.nama_pemilik}</td>
          <td class="px-2 py-2">${item.produk}</td>
          <td class="px-2 py-2">${item.kecamatan}</td>
        `;
        tableBody.appendChild(row);
      });

      // Simpan data ke variabel global
      window.dataIndustri = data;

      // Tampilkan summary awal (semua kecamatan)
      renderSummary(data);
    })
    .catch(error => console.error("Error:", error));
});

// Fungsi render summary industri
function renderSummary(data) {
  const totalUsaha = data.length;

  const totalLaki = data.reduce((sum, item) => sum + (item.tk_l || 0), 0);
  const totalPerempuan = data.reduce((sum, item) => sum + (item.tk_p || 0), 0);

  // Update isi elemen summary di halaman
  document.querySelector('.text-6xl.mb-1').innerText = `${totalUsaha}`;

  const tenagaKerjaElement = document.getElementById('tenagaKerjaSummary');
  tenagaKerjaElement.innerHTML = `
    <span class="inline-block w-4 h-4 bg-[#5bc0f8] rounded-sm"></span> ${totalLaki} <span class="text-sm">Laki-Laki</span>
    <span class="inline-block w-4 h-4 bg-[#f26c6c] rounded-sm"></span> ${totalPerempuan} <span class="text-sm">Perempuan</span>
  `;
}

// Pilih kecamatan dan render summary + table
function selectKecamatan(kecamatan) {
  document.getElementById('selected-kecamatan').textContent = kecamatan;
  toggleDropdown();

  const filteredData = window.dataIndustri.filter(item => item.kecamatan === kecamatan);

  // Update table
  const tableBody = document.getElementById("data-industri");
  tableBody.innerHTML = "";
  filteredData.forEach(item => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td class="px-2 py-2">${item.nama_usaha}</td>
      <td class="px-2 py-2">${item.nama_pemilik}</td>
      <td class="px-2 py-2">${item.produk}</td>
      <td class="px-2 py-2">${item.kecamatan}</td>
    `;
    tableBody.appendChild(row);
  });

  // Update summary
  renderSummary(filteredData);
}



</script>
@endsection