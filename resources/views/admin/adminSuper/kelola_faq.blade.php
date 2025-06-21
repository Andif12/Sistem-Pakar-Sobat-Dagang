@extends('layouts.admin')

@section('content')
<div class="relative w-full h-44">
    <img src="{{ asset('assets\img\background\kepalaDinas_SuperAdmin.jpg') }}" alt="Port Background" class="object-cover w-full h-full">
    <div class="absolute z-10 text-center transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        <h1 class="text-5xl font-bold text-[#FAA31E]">Kelola FAQ</h1>
    </div>
</div>

    <div class="container relative px-4 mx-auto -mt-8">
        <div class="flex justify-center mb-6 space-x-4">
            <div class="relative w-1/2 bg-white rounded-full shadow-xl shadow-gray-400/40">
                <span class="absolute text-gray-500 transform -translate-y-1/2 material-symbols-outlined left-3 top-1/2">
                    search
                </span>
                <input id="faqSearch" type="text" placeholder="Cari"
                    class="w-full p-3 pl-10 bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="bg-white rounded-full shadow-xl shadow-gray-400/40">
                <button onclick="openModal()" class="btn btn-primary rounded-full py-3 px-6 text-[#083358] font-semibold bg-white
                        hover:text-white hover:bg-[#083358]">
                    + Tambah FAQ
                </button>
            </div>
        </div>
    </div>
    <div class="mt-4 overflow-x-auto rounded-lg shadow-sm">
		<div class="inline-block min-w-full px-4 align-middle sm:px-8">
			<div class="overflow-hidden rounded-xl">
                <table class="min-w-full pb-12 text-sm text-left text-gray-700 bg-white border border-gray-200">
					<thead class="bg-[#0c3252] text-white">
                        <tr>
							<th scope="col" class="px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5">No</th>
							<th scope="col" class="px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5">Pertanyaan</th>
							<th scope="col" class="px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5">Jawaban</th>
							<th scope="col" class="px-3 py-3 font-medium text-center border-b border-blue-100 sm:px-5">Aksi</th>
						</tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $faq)
                        <tr class="transition hover:bg-blue-50">
                            <td class="px-3 py-3 text-center border-b sm:px-5">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 border-b sm:px-5">{{ $faq->pertanyaan }}</td>
                            <td class="px-3 py-3 border-b sm:px-5">{{ $faq->jawaban }}</td>
                            <td class="px-3 py-3 text-center border-b sm:px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditModal(this)" data-id="{{ $faq->id }}" data-pertanyaan="{{ htmlspecialchars($faq->pertanyaan, ENT_QUOTES) }}" data-jawaban="{{ htmlspecialchars($faq->jawaban, ENT_QUOTES) }}" class="inline-flex items-center justify-center px-2 py-1 text-black rounded-full" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <form action="{{ route('faq-destroy', $faq->id) }}" method="POST"onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-2 py-1 text-black rounded-full"
                                            title="Hapus">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit FAQ -->
    <div id="editFaqModal" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
        <div class="relative w-11/12 max-w-lg p-6 bg-white rounded-lg">
            <h2 class="mb-4 text-xl font-semibold">Edit FAQ</h2>
            <form id="editFaqForm" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="edit_pertanyaan" class="block mb-1 font-medium">Pertanyaan</label>
                    <input type="text" name="pertanyaan" id="edit_pertanyaan" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="edit_jawaban" class="block mb-1 font-medium">Jawaban</label>
                    <textarea name="jawaban" id="edit_jawaban" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded" required></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded bg-[#0c3252] text-white hover:bg-[#F49F1E]">Simpan</button>
                </div>
            </form>
            <!-- Close button -->
            <button onclick="closeEditModal()" class="absolute text-xl font-bold text-gray-600 top-3 right-3 hover:text-gray-800">&times;</button>
        </div>
    </div>


    <!-- Modal Tambah FAQ -->
    <div id="faqModal" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
        <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
            <h2 class="mb-4 text-xl font-semibold">Tambah FAQ</h2>
            <form action="{{ route('faq-store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="pertanyaan" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <input type="text" name="pertanyaan" id="pertanyaan" required
                        class="block w-full px-4 py-2 mt-1 border rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="jawaban" class="block text-sm font-medium text-gray-700">Jawaban</label>
                    <textarea name="jawaban" id="jawaban" rows="4" required
                        class="block w-full px-4 py-2 mt-1 border rounded-md shadow-sm focus:ring focus:ring-blue-200"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
            <button onclick="closeModal()" class="absolute text-gray-500 top-2 right-3 hover:text-red-500">
                ✕
            </button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('faqModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('faqModal').classList.add('hidden');
    }

    function openEditModal(button) {
        console.log('openEditModal triggered');
        const id = button.getAttribute('data-id');
        const pertanyaan = button.getAttribute('data-pertanyaan');
        const jawaban = button.getAttribute('data-jawaban');

        document.getElementById('edit_pertanyaan').value = pertanyaan;
        document.getElementById('edit_jawaban').value = jawaban;

        document.getElementById('editFaqForm').action = `/admin/faq/${id}`;

        document.getElementById('editFaqModal').classList.remove('hidden');
    }  

    function closeEditModal() {
        document.getElementById('editFaqModal').classList.add('hidden');
    }


    function closeEditModal() {
        document.getElementById('editFaqModal').classList.add('hidden');
    }
    document.getElementById('searchInput').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const pertanyaan = row.children[1].textContent.toLowerCase();
            const jawaban = row.children[2].textContent.toLowerCase();

            if (pertanyaan.includes(keyword) || jawaban.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    const searchInput = document.getElementById("faqSearch");

    searchInput.addEventListener("keyup", function (event) {
        const keyword = event.target.value.toLowerCase();

        // Ambil semua elemen FAQ (gantilah '.faq-item' sesuai class/item yang ingin difilter)
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(keyword)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    
    });
</script>
@endsection