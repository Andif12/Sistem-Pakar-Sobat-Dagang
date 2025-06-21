@extends('layouts.admin')
@section('title', 'Sertifikat Halal')

@section('content')

<div class="w-full max-w-full">
  <!-- Fix: Improved Alpine.js state management -->
  <div class="w-full max-w-full"
    x-data="{ 
      openAdd: false, 
      openEdit: false, 
      selectedItem: null,
      init() {
        this.$nextTick(() => {
          @if(session('openAdd'))
            this.openAdd = true;
          @endif
        });
      }
    }"
    x-init="init()">

  
    <div class="relative w-full h-44">
      <img src="{{ asset('/assets/img/background/user_industri.png') }}" alt="Banner" class="object-cover w-full h-44">
        <a href="{{ route('dashboard.industri') }}"
          class="absolute flex items-center justify-center w-12 h-12 text-black transition-all duration-300 transform -translate-y-1/2 rounded-full shadow-lg left-14 top-1/2 bg-white/80 hover:bg-black hover:text-white hover:border-white hover:scale-110">
          <span class="text-2xl material-symbols-outlined">
              arrow_back
          </span>
        </a>
    </div>

    <div class="relative flex items-center w-full gap-4 px-6 py-6 mx-auto">
      <div class="relative flex-1">
        <form method="GET" action="{{ route('admin.industri.halal') }}">
            <input type="text" name="search" placeholder="Cari"
              class="w-full p-3 pl-10 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('search') }}" />
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">search</span>
        </form>
    </div>

    <button @click="openAdd = true" class="sticky bg-[#002B4E] text-white font-semibold rounded-full px-6 py-3 shadow-md hover:bg-white hover:text-[#003366] border border-transparent hover:border-[#003366] transition duration-300">
      TAMBAH DATA
    </button>
  </div>

  <!-- Fixed Form Tambah Data Modal -->
  <div x-show="openAdd" 
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
       style="display: none;"
       x-cloak>
    <div class="bg-white p-6 rounded shadow w-full max-w-lg max-h-[90vh] ml-24 mr-2 sm:justify-center overflow-y-auto"
         @click.away="openAdd = false">
      <h2 class="mb-4 text-xl font-semibold text-center">Tambah Data Sertifikat Halal</h2>
      
      <!-- Alert Messages -->
      @if (session('success'))
      <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-lg" role="alert">
          {{ session('success') }}
          <script>
            // Auto close modal after success
            setTimeout(() => {
              if (window.Alpine) {
                window.Alpine.store('modal', { openAdd: false });
              }
            }, 2000);
          </script>
      </div>
      @endif
      
      @if (session('error'))
      <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg" role="alert">
          {{ session('error') }}
      </div>
      @endif
      
      @if ($errors->any())
      <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded-lg">
          <strong>Terjadi kesalahan:</strong>
          <ul class="mt-1 ml-4 list-disc list-inside">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      @endif
      
      <form action="{{ route('admin.industri.halal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="block mb-1 font-semibold">Nama Usaha</label>
              <input type="text" name="nama_usaha" placeholder="Nama Usaha" 
                     value="{{ old('nama_usaha') }}"
                     class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            </div>
            <div>
              <label class="block mb-1 font-semibold">Nomor Sertifikat Halal</label>
              <input type="text" name="no_sertifikasi_halal" placeholder="No Sertifikat Halal" 
                     value="{{ old('no_sertifikasi_halal') }}"
                     class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
              <label class="block mb-1 font-semibold">Tanggal Diterbitkan</label>
              <input type="date" name="tanggal_sah" 
                     value="{{ old('tanggal_sah') }}"
                     class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            </div>
            <div>
              <label class="block mb-1 font-semibold">Berlaku Sampai</label>
              <input type="date" name="tanggal_exp" 
                     value="{{ old('tanggal_exp') }}"
                     class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            </div>
            <div>
              <label class="block mb-1 font-semibold">Status</label>
              <select name="status" class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                <option value="Berlaku" {{ old('status') == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                <option value="Perlu Pembaruan" {{ old('status') == 'Perlu Pembaruan' ? 'selected' : '' }}>Perlu Pembaruan</option>
              </select>
            </div>
            <div x-data="{ fileName: '' }">
              <p class="block mb-1 font-semibold">Sertifikat Halal</p>
              <label for="filesertifikat" class="px-4 py-2 bg-blue-100 text-black rounded-full cursor-pointer transition-all duration-300 hover:bg-[#083358] hover:text-white w-max">Pilih File</label>
              <input type="file" id="filesertifikat" name="sertifikat" accept="application/pdf" class="hidden" @change="fileName = $event.target.files[0].name" required>
              <p x-text="fileName" class="mt-2 text-sm text-gray-600"></p>
              <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file 512KB (PDF).</p>
            </div>
          </div>
          
          <div class="mt-4">
            <label class="block mb-1 font-semibold">Alamat</label>
            <textarea name="alamat" placeholder="Alamat" 
                      class="w-full px-4 py-2 text-sm placeholder-gray-400 transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
          </div>
          
          <div class="flex justify-center mt-6 space-x-2">
            <button type="button" @click="openAdd = false" class="px-4 py-2 transition bg-gray-300 rounded-full hover:bg-gray-400">Batal</button>
            <button type="submit" class="bg-[#002B4E] text-white font-semibold rounded-full px-6 py-3 shadow-md hover:brightness-110 transition">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Tabel Data -->
  <div class="container px-4 pb-4 mx-auto">
    <section class="overflow-hidden bg-white border border-gray-300 shadow-md rounded-xl">
      <div class="overflow-y-auto max-h-[350px]">
        <table class="w-full text-sm text-left table-auto">
          <thead class="bg-[#0d3b66] text-white sticky top-0 z-10">
            <tr>
              <th class="px-4 py-3 font-semibold text-left">NO</th>
              <th class="px-4 py-3 font-semibold text-left">Nama Usaha</th>
              <th class="px-4 py-3 font-semibold text-left">No Sertifikat</th>
              <th class="px-4 py-3 font-semibold text-left">Tanggal Diterbitkan</th>
              <th class="px-4 py-3 font-semibold text-left">Berlaku Sampai</th>
              <th class="px-4 py-3 font-semibold text-left">Alamat</th>
              <th class="px-4 py-3 font-semibold text-left min-w-[140px]">Status</th>
              <th class="px-4 py-3 font-semibold text-left">Sertifikat</th>
              <th class="px-4 py-3 font-semibold text-left rounded-tr-xl">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr id="row-{{ $item->id_halal }}" class="transition-colors hover:bg-gray-50">
              <td class="px-4 py-3">{{ $loop->iteration }}</td>
              <td class="px-4 py-3">{{ $item->nama_usaha }}</td>
              <td class="px-4 py-3">{{ $item->no_sertifikasi_halal }}</td>
              <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_sah)->format('d-m-Y') }}</td>
              <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_exp)->format('d-m-Y') }}</td>
              <td class="px-4 py-3">{{ $item->alamat }}</td>
              <td class="px-4 py-3 min-w-[140px]">
                <span class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap
                  {{ $item->status == 'Berlaku' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                  {{ $item->status }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if($item->sertifikat)
                  <a href="{{ asset('storage/' . $item->sertifikat) }}" target="_blank" class="text-blue-600 underline transition hover:text-blue-800">Lihat</a>
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button onclick="openEditModal({{ json_encode($item) }})" class="text-green-600 transition hover:text-green-800" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                    </svg>
                  </button>
                  <button onclick="deleteData({{ $item->id_halal }})" class="text-red-600 transition hover:text-red-800" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m4-3h2a1 1 0 011 1v1H8V5a1 1 0 011-1z" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>

<!-- Fixed Modal Edit -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
  <div class="min-h-screen px-4 text-center">
    <div class="inline-block w-full max-w-2xl p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
      <h3 class="mb-6 text-xl font-bold text-center">Edit Sertifikat Halal</h3>
      
      <form id="formEdit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_id" name="id_halal">
        
        <div class="grid gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-1 font-semibold">Nama Usaha</label>
            <input type="text" id="edit_nama_usaha" name="nama_usaha" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block mb-1 font-semibold">Nomor Sertifikat Halal</label>
            <input type="text" id="edit_no_sertifikasi_halal" name="no_sertifikasi_halal" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
          </div>
          <div>
            <label class="block mb-1 font-semibold">Tanggal Sah</label>
            <input type="date" id="edit_tanggal_sah" name="tanggal_sah" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block mb-1 font-semibold">Tanggal Exp</label>
            <input type="date" id="edit_tanggal_exp" name="tanggal_exp" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
          </div>
          <div>
            <label class="block mb-1 font-semibold">Status</label>
            <select id="edit_status" name="status" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
              <option value="Berlaku">Berlaku</option>
              <option value="Perlu Pembaruan">Perlu Pembaruan</option>
            </select>
          </div>
          <div x-data="{ fileName: '' }">
            <p class="block mb-1 font-semibold">File Sertifikat - kosongkan jika tidak berubah</p>
            <label for="edit_filesertifikat" class="px-4 py-2 bg-blue-100 text-black rounded-full cursor-pointer transition-all duration-300 hover:bg-[#083358] hover:text-white inline-block">Pilih File</label>
            <input type="file" id="edit_filesertifikat" name="sertifikat" accept="application/pdf" class="hidden" @change="fileName = $event.target.files[0].name">
            <p x-text="fileName" class="mt-2 text-sm text-gray-600"></p>
            <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file 512KB (PDF).</p>
          </div>
        </div>
        
        <div class="mt-1">
          <label class="block mb-1 font-semibold">Alamat</label>
          <textarea id="edit_alamat" name="alamat" placeholder="Alamat" class="w-full px-4 py-2 text-sm transition border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required></textarea>
        </div>
        
        <div class="flex justify-center gap-4 mt-6">
          <button type="button" onclick="closeEditModal()" class="px-4 py-2 transition bg-gray-300 rounded-full hover:bg-gray-400">Batal</button>
          <button type="button" onclick="submitEdit()" class="bg-[#002B4E] text-white font-semibold rounded-full px-6 py-3 shadow-md hover:brightness-110 transitionn">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>

<!-- Fixed and Improved JavaScript -->
<script>
// Improved modal functions with better error handling
function openEditModal(item) {
  const modal = document.getElementById('modalEdit');
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden'; // Prevent background scroll
  
  // Populate form fields
  document.getElementById('edit_id').value = item.id_halal;
  document.getElementById('edit_nama_usaha').value = item.nama_usaha || '';
  document.getElementById('edit_no_sertifikasi_halal').value = item.no_sertifikasi_halal || '';
  document.getElementById('edit_tanggal_sah').value = item.tanggal_sah || '';
  document.getElementById('edit_tanggal_exp').value = item.tanggal_exp || '';
  document.getElementById('edit_alamat').value = item.alamat || '';
  document.getElementById('edit_status').value = item.status || 'Berlaku';
}

function closeEditModal() {
  const modal = document.getElementById('modalEdit');
  modal.classList.add('hidden');
  document.body.style.overflow = 'auto'; // Restore background scroll
  
  // Reset form
  document.getElementById('formEdit').reset();
}

async function submitEdit() {
  const id = document.getElementById('edit_id').value;
  const form = document.getElementById('formEdit');
  const formData = new FormData(form);
  
  // Show loading state
  const submitBtn = event.target;
  const originalText = submitBtn.textContent;
  submitBtn.textContent = 'Menyimpan...';
  submitBtn.disabled = true;
  
  try {
    const response = await fetch(`/admin/industri/sertifikat-halal/${id}`, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    });
    
    if (response.ok) {
      alert('Data berhasil diupdate');
      closeEditModal();
      window.location.reload();
    } else {
      const errorData = await response.json();
      const errorMessage = errorData.errors 
        ? Object.values(errorData.errors).flat().join('\n')
        : errorData.message || 'Terjadi kesalahan';
      alert('Error: ' + errorMessage);
    }
  } catch (err) {
    alert('Terjadi kesalahan koneksi: ' + err.message);
  } finally {
    // Restore button state
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  }
}

async function deleteData(id) {
  if (!confirm('Yakin ingin menghapus data ini?')) return;
  
  try {
    const response = await fetch(`/admin/industri/sertifikat-halal/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest',
      }
    });
    
    if (response.ok) {
      alert('Data berhasil dihapus');
      const row = document.getElementById('row-' + id);
      if (row) {
        row.style.transition = 'opacity 0.3s ease-out';
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 300);
      }
    } else {
      const errorData = await response.json();
      alert('Gagal menghapus data: ' + (errorData.message || 'Unknown error'));
    }
  } catch (err) {
    alert('Terjadi kesalahan koneksi: ' + err.message);
  }
}

// Close modal when clicking outside
document.getElementById('modalEdit')?.addEventListener('click', function(e) {
  if (e.target === this) {
    closeEditModal();
  }
});

// Handle Escape key to close modals
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeEditModal();
  }
});

// Clear session flash messages after showing
@if(session('success') || session('error'))
setTimeout(() => {
  // This will be handled by Laravel session flash - automatically cleared after next request
}, 3000);
@endif
</script>

<!-- Add CSS for better modal transitions -->
<style>
[x-cloak] { 
  display: none !important; 
}

.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

@endsection