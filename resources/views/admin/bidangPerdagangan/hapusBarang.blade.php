@extends('layouts.admin')
@section('title', 'Hapus Data Barang')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="w-full h-36">
    <img src="{{ asset('assets/img/background/dagang.jpg') }}"
        alt="Background" class="object-cover w-full h-full">
</div>

<div class="bg-white py-4 px-6 md:px-10 min-h-[calc(100vh-8rem)]">
    <h2 class="text-center text-lg md:text-xl font-bold mb-4 text-[#083358]">Tabel Data Barang</h2>
    @if (session('success'))
    <div class="mt-4 font-semibold text-green-600">
        {{ session('success') }}
    </div>
    @endif
    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-[#083358] text-white shadow-md">
        <table class="min-w-full text-sm text-left">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">Nama Barang</th>
                    <th class="px-4 py-3 text-center">Kategori Barang</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $index => $barang)
                <tr class="text-black bg-white border-b-2 border-r-2 border-gray-300">
                    <td class="px-4 py-2 text-center border-r-2 border-gray-300">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-center border-r-2 border-gray-300">
                        {{ Str::title($barang->nama_barang) }}
                    </td>
                    <td class="px-4 py-2 text-center border-r-2 border-gray-300">
                        {{ $barang->kategori ? Str::title($barang->kategori->nama_kategori) : 'Tidak Ada Kategori' }}
                    </td>
                    <td class="px-4 py-2 text-center border-r-2 border-gray-300">
                        <button type="button" class="px-4 py-1 text-xs text-white bg-red-600 rounded-full hover:bg-red-700 open-modal-button" data-id="{{ $barang->id_barang }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-black bg-white border-b border-gray-300">Tidak ada data barang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modal-verifikasi" class="fixed inset-0 z-50 flex items-center justify-center hidden px-4 ml-24 bg-black bg-opacity-50 rounded-lg sm:justify-center">
    <div class="w-11/12 max-w-md p-6 bg-white shadow-xl rounded-2xl">
        <h2 class="mb-4 text-lg font-semibold">Konfirmasi Penghapusan</h2>
        <p class="mb-6 text-sm text-black-600">Apakah Anda yakin ingin menghapus barang ini?</p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeModal()"
                class="px-4 py-2 text-black transition-all bg-gray-200 rounded-full hover:bg-gray-300">
                Batal
            </button>
            <button type="button" id="confirm-delete" class="px-4 py-2 text-white transition-all bg-red-600 rounded-full hover:bg-red-700">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalButtons = document.querySelectorAll('.open-modal-button');
        const modal = document.getElementById('modal-verifikasi');
        const confirmDeleteButton = document.getElementById('confirm-delete');
        let itemToDelete = null;

        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                itemToDelete = this.getAttribute('data-id');
                modal.classList.remove('hidden'); 
            });
        });

        function closeModal() {
            modal.classList.add('hidden');
            itemToDelete = null;
        }

        confirmDeleteButton.addEventListener('click', function() {
            if (itemToDelete) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/dashboard-perdagangan/barang/${itemToDelete}`;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
            closeModal();
        });

        const cancelButton = document.querySelector('.bg-gray-200');
        cancelButton.addEventListener('click', closeModal);
    });
</script>

@endsection