@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')

<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Kelola Berita</h1>
    </div>
</div>

<div class="container relative px-4 mx-auto -mt-8">
    <div class="flex justify-center mb-6 space-x-4">
        <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
            <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">
                search
            </span>
            <input type="text" placeholder="Cari"
                class="w-full p-3 pl-10 bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>
        <div class="bg-white rounded-full shadow-xl shadow-gray-400/40">
            <button onclick="openModal('tambah')" class="btn btn-primary rounded-full py-3 px-6 text-[#083358] font-semibold bg-white
                    hover:text-white hover:bg-[#083358]">
                + Tambah Berita
            </button>
        </div>
    </div>
</div>

<div class="container px-4 pb-12 mx-auto rounded-xl">

    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto border border-gray-300 shadow-md rounded-xl">
        <table class="min-w-full bg-white w-max">
            <thead>
                <tr class="bg-[#083358] text-white font-semibold">
                    <th class="px-4 py-3 border-b rounded-tl-xl">No</th>
                    <th class="px-4 py-3 border-b">Tanggal</th>
                    <th class="px-4 py-3 border-b">Judul Berita</th>
                    <th class="px-4 py-3 border-b rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarBerita as $index => $item)
                <tr>
                    <td class="px-4 py-2 text-center border">{{ $index + 1 + $daftarBerita->firstItem() - 1 }}</td>
                    <td class="px-4 py-2 text-center border">
                        {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                    </td>
                    <td class="px-4 py-2 border">{{ $item->judul }}</td>
                    <td class="flex items-center justify-center px-4 py-2 space-x-2 border">
                        <button
                            onclick="openModal('edit', this)"
                            data-id="{{ $item->id_berita }}"
                            data-judul="{{ $item->judul }}"
                            data-tanggal="{{ $item->tanggal }}"
                            data-isi="{{ htmlentities($item->isi) }}"
                            data-lampiran="{{ $item->lampiran ? asset('storage/' . $item->lampiran) : '' }}"
                            class="text-[#083358] hover:text-black">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                        <button
                            onclick="openModal('delete', this)"
                            data-id="{{ $item->id_berita }}"
                            class="text-[#083358] hover:text-black">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $daftarBerita->links() }}
    </div>
</div>


<div id="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
    <div class="relative max-w-xl w-full max-h-[90vh] overflow-y-auto p-8 bg-white rounded-lg shadow-xl">
        <h3 class="mb-6 text-2xl font-semibold text-center">Edit Berita</h3>
        <form method="POST" id="editForm" action="" enctype="multipart/form-data" class="relative bg-white rounded-lg p-6 w-full max-w-full sm:max-w-xl md:max-w-2xl max-h-[90vh] overflow-y-auto
                            scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
                        style="scrollbar-width: thin;">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="judul_edit" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" id="judul_edit" name="judul" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="tanggal_edit" class="block text-sm font-medium text-gray-700">Tanggal Berita</label>
                <input type="date" id="tanggal_edit" name="tanggal" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="summernote_edit" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                <textarea id="summernote_edit" name="isi" class="w-full p-3 border rounded-md resize-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label for="gambar_edit" class="block text-sm font-medium text-gray-700">Lampiran (Gambar)</label>
                <div class="flex items-center space-x-3">
                    <label for="gambar_edit" class="px-4 py-2 bg-blue-100 text-black rounded-full cursor-pointer hover:bg-[#083358] hover:text-white transition">Pilih File</label>
                    <span id="file-name-edit" class="text-gray-500">Tidak ada file yang dipilih</span>
                    <input type="file" id="gambar_edit" name="lampiran" class="hidden" onchange="document.getElementById('file-name-edit').innerText = this.files[0]?.name ?? 'Tidak ada file yang dipilih'">
                </div>

                <!-- Preview gambar lama -->
                <div id="preview-lama" class="hidden mt-3">
                    <p class="text-sm text-gray-600">Lampiran saat ini:</p>
                    <img id="preview-lama-img" src="" alt="Gambar lama" class="w-32 h-auto rounded shadow">
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <button type="button" onclick="closeModal('edit')" class="px-4 py-2 text-black bg-gray-300 rounded-full hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-6 py-2 bg-[#083358] text-white rounded-full hover:bg-[#061f3c] transition">Simpan</button>
            </div>

            @if ($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <ul class="pl-5 list-disc">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>
    </div>
</div>

<div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
    <div class="relative max-w-xl w-full max-h-[90vh] overflow-y-auto p-8 bg-white rounded-lg shadow-xl">
        <h3 class="mb-6 text-2xl font-semibold text-center">Tambah Berita</h3>
        <form action="{{ route('tambah.berita') }}" method="POST" id="tambahForm" enctype="multipart/form-data" class="relative bg-white rounded-lg p-6 w-full max-w-full sm:max-w-xl md:max-w-2xl max-h-[90vh] overflow-y-auto
                            scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
                        style="scrollbar-width: thin;">
            @csrf
            <div class="mb-4">
                <label for="judul_tambah" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" name="judul" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Judul Berita" required>
            </div>

            <div class="mb-4">
                <label for="tanggal_tambah" class="block text-sm font-medium text-gray-700">Tanggal Berita</label>
                <input type="date" name="tanggal" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="konten_tambah" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                <textarea name="isi" id="summernote" class="w-full p-3 border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Isi Berita" required></textarea>
            </div>

            <div class="mb-4">
                <label for="gambar_tambah" class="block text-sm font-medium text-gray-700">Lampiran (Gambar)</label>
                <div class="flex items-center space-x-3">
                    <label for="gambar_tambah" class="px-4 py-2 bg-blue-100 text-black rounded-full cursor-pointer transition-all duration-300 hover:bg-[#083358] hover:text-white">Pilih File</label>
                    <span id="file-name-tambah" class="text-gray-500">Tidak ada file yang dipilih</span>
                    <input type="file" id="gambar_tambah" name="lampiran" class="hidden" accept="image/*"
                        onchange="document.getElementById('file-name-tambah').innerText = this.files[0]?.name ?? 'Tidak ada file yang dipilih'">
                </div>
                
                <div id="preview-tambah" class="hidden mt-3">
                    <p class="text-sm text-gray-600">Preview Gambar:</p>
                    <img id="preview-tambah-img" src="" alt="Preview Gambar" class="w-32 h-auto rounded shadow">
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3 ">
                <button type="button" onclick="closeModal('tambah')"
                    class="px-4 py-2 text-black transition-all bg-gray-300 rounded-full hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-[#083358] text-white rounded-full hover:bg-[#061f3c] transition-all">
                    Simpan
                </button>
            </div>

            @if ($errors->any())
            <div class="mt-4 text-sm text-red-600">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </form>
    </div>
</div>

<div id="modalDelete" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
    <div class="w-11/12 max-w-md p-6 bg-white shadow-xl rounded-2xl">
        <h2 class="mb-4 text-lg font-semibold">Hapus Berita</h2>
        <p class="mb-6 text-sm text-black-600">Apakah Anda yakin ingin menghapus berita ini?</p>
        <form id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('delete')" class="px-4 py-2 text-black bg-gray-300 rounded-full hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 text-white transition bg-red-600 rounded-full hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


<script>
    // Fungsi untuk membuka modal
    function openModal(type, button) {
        if (type === 'edit') {
            const beritaId = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');
            const isi = button.getAttribute('data-isi');
            const tanggal = button.getAttribute('data-tanggal');
            const lampiran = button.getAttribute('data-lampiran');

            const dummy = document.createElement("div");
            dummy.innerHTML = isi;
            const plainText = dummy.innerText;

            document.getElementById('judul_edit').value = judul;
            document.getElementById('tanggal_edit').value = tanggal;
            $('#summernote_edit').summernote('code', plainText);
            document.getElementById('editForm').action = `/admin/${beritaId}`;

            // Reset input file dan label
            document.getElementById('gambar_edit').value = '';
            document.getElementById('file-name-edit').innerText = 'Tidak ada file yang dipilih';

            // Preview gambar lama
            if (lampiran && lampiran !== 'null' && lampiran !== '') {
                document.getElementById('preview-lama').classList.remove('hidden');
                document.getElementById('preview-lama-img').src = lampiran;
            } else {
                document.getElementById('preview-lama').classList.add('hidden');
                document.getElementById('preview-lama-img').src = '';
            }

            $(document).ready(function () {
                $('#summernote_edit').summernote({
                    tabsize: 2,
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ],
                });
            });

            document.getElementById('modalEdit').classList.remove('hidden');
        } else if (type === 'delete') {
            const beritaId = button.getAttribute('data-id');
            const form = document.getElementById('formDelete');
            form.action = `/admin/${beritaId}`;
            document.getElementById('modalDelete').classList.remove('hidden');
        } else if (type === 'tambah') {
            document.getElementById('modalTambah').classList.remove('hidden');

            $(document).ready(function () {
                $("#summernote").summernote({
                    tabsize: 2,
                    height: 150,
                    toolbar: [
                        ["style", ["bold", "italic", "underline", "clear"]],
                        ["fontsize", ["fontsize"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });

                // Tambahkan preview file setelah summernote siap
                const fileInput = document.getElementById('gambar_tambah');
                const fileNameSpan = document.getElementById('file-name-tambah');

                fileInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        fileNameSpan.innerText = file.name;

                        // Tampilkan preview
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            let preview = document.getElementById('preview-tambah');
                            let img = document.getElementById('preview-tambah-img');
                            preview.classList.remove('hidden');
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        fileNameSpan.innerText = 'Tidak ada file yang dipilih';
                        document.getElementById('preview-tambah').classList.add('hidden');
                        document.getElementById('preview-tambah-img').src = '';
                    }
                });
            });
        }
    }

    // Fungsi untuk menutup modal
    function closeModal(type) {
        if (type === 'edit') {
            document.getElementById('modalEdit').classList.add('hidden');
        } else if (type === 'delete') {
            document.getElementById('modalDelete').classList.add('hidden');
        } else if (type === 'tambah') {
            document.getElementById('modalTambah').classList.add('hidden');
        }
    }

</script>