@extends('layouts.admin')
@section('title', 'Sertifikat Halal')

@section('content')

<section 
  x-data="halalData()"
  class="relative"
>

  <img src="{{ asset('/assets/img/background/user_industri.png') }}" alt="Banner" class="object-cover w-full h-44">
 

  <div class="container px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6 gap-8">
    <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
      <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">search</span>
      <input type="text" x-model="searchQuery" placeholder="Cari"
        class="w-full p-3 pl-10 bg-transparent border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <span class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2">
       
      </span>
    </div>
  </div>
  </div>

  <section class="relative z-10 flex-1 px-6 pb-10 mt-1 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-transparent">
    <div class="overflow-hidden rounded-xl">
      <div class="w-full overflow-x-auto">
        <table class="w-full text-sm table-auto min-w-[800px]">
          <thead class="bg-[#0d3b66] text-white">
            <tr>
              <th class="px-4 py-3 font-semibold text-left">NO</th>
              <th class="px-4 py-3 font-semibold text-left">NAMA USAHA</th>
              <th class="px-4 py-3 font-semibold text-left">NO. SERTIFIKAT</th>
              <th class="px-4 py-3 font-semibold text-left">TANGGAL DITERBITKAN</th>
              <th class="px-4 py-3 font-semibold text-left">BERLAKU SAMPAI</th>
              <th class="px-4 py-3 font-semibold text-left">ALAMAT</th>
              <th class="px-4 py-3 font-semibold text-left">DOKUMEN</th>
            </tr>
          </thead>
          <tbody>
            <template x-if="filteredItems.length">
              <template x-for="(item, index) in filteredItems" :key="item.id_halal">
                <tr :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-white'" class="border-b hover:bg-gray-50">
                  <td class="px-4 py-3" x-text="index + 1"></td>
                  <td class="px-4 py-3" x-text="item.nama_usaha"></td>
                  <td class="px-4 py-3" x-text="item.no_sertifikasi_halal"></td>
                  <td class="px-4 py-3" x-text="item.tanggal_sah_formatted"></td>
                  <td class="px-4 py-3" x-text="item.tanggal_exp_formatted"></td>
                  <td class="px-4 py-3" x-text="item.alamat"></td>
                  <td class="px-4 py-3">
                    <a :href="'/storage/' + item.sertifikat" target="_blank" class="text-blue-600 hover:underline">
                      Lihat Sertifikat
                    </a>
                  </td>
                </tr>
              </template>
            </template>

            <template x-if="filteredItems.length === 0">
              <tr>
                <td colspan="8" class="py-6 text-center text-gray-500">Tidak ada data yang cocok.</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

  </section>
</section>
<script>
function halalData() {
  function formatDateToYMD(dateStr) {
    const d = new Date(dateStr);
    if (isNaN(d)) return '';
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`; 
  }

  return {
    openModal: false,
    searchQuery: '',
    originalData: @json($data),
    formData: {
      id: null,
      nama_usaha: '',
      no_sertifikasi_halal: '',
      tanggal_sah: '',
      tanggal_exp: '',
      alamat: '',
      status: '',
    },
    get filteredItems() {
      if (!this.searchQuery.trim()) return this.originalData;

      const q = this.searchQuery.toLowerCase();
      return this.originalData.filter(item =>
        (item.nama_usaha && item.nama_usaha.toLowerCase().includes(q)) ||
        (item.no_sertifikasi_halal && item.no_sertifikasi_halal.toLowerCase().includes(q)) ||
        (item.alamat && item.alamat.toLowerCase().includes(q))
      );
    },
  }
}
</script>
@endsection