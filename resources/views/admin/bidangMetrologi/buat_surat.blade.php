@extends('layouts.metrologi.admin')
@section('title', "Admin Bidang Metrologi")
@section('content')
<!-- Add SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }

    /* Tambahan untuk mencegah list terpotong */
    .ck-content ol,
    .ck-content ul {
        padding-left: 1.5rem !important;
    }
</style>

<div class="p-6 bg-gray-100 min-h-screen">
    <div class="relative h-[150px] w-full bg-cover bg-[center_87%]" style="background-image: url('/assets/img/background/user_metrologi.png');">
        <div class="absolute bottom-[-30px] w-full px-8">
            <div class="flex flex-wrap items-center justify-between p-4 rounded-xl">
                <div class="relative flex-grow mt-2 md:mt-0">
                    <p class="pl-10 text-center justify-center pr-4 py-2 rounded-full bg-white shadow text-sm w-full">FORM SURAT BALASAN</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <form enctype="multipart/form-data" class="mt-6 bg-white p-6 rounded-xl shadow-lg w-full max-w-3xl" action="{{ route('proces-surat-balasan', $id) }}" method="POST" id="suratForm">
            @csrf
            <div class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="">
                        <label for="nomor_surat" class="block font-medium mb-1">Nomor Surat</label>
                        <input type="text" name="id_surat_balasan" id="id_surat_balasan" 
                            class="border px-4 py-2 w-full rounded-lg" 
                            value="{{ $draft->id_surat_balasan ?? '' }}" 
                            required
                            onchange="validateNomorSuratBalasan(this)">
                        <div id="nomor-surat-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        @error('id_surat_balasan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="tanggal_pembuatan_surat" value="{{ date('Y-m-d') }}">
                    <div class="form-group row">
                        <label for="nama_yang_dituju" class="block font-medium mb-1">Penerima</label>
                        <input type="text" name="nama_yang_dituju" id="nama_yang_dituju" 
                            class="border px-4 py-2 w-full rounded-lg" 
                            value="{{ $draft->nama_yang_dituju ?? $surat->user->nama ?? '' }}" 
                            required
                            onchange="validatePenerima(this)">
                        <div id="penerima-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        @error('nama_yang_dituju')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group row md:col-span-2">
                        <label for="isi_surat" class="block font-medium mb-1">Isi Surat</label>
                        <textarea id="editor" name="isi_surat" class="form-control">{{ $draft->isi_surat ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                <div class="flex justify-center gap-4">
                    <button type="submit" name="action" value="submit" onclick="return confirmSubmit(event, 'submit')" class="bg-blue-900 text-white px-6 py-2 rounded-lg mt-4 font-semibold">Buat Surat Balasan</button>
                    <button type="button" onclick="validateDraft(event)" class="bg-gray-500 text-white px-6 py-2 rounded-lg mt-4 font-semibold">Simpan Draft</button>
                </div>
            </div>
        </form>
    </div>
        
</div>
<script>
    let editorInstance;

    function validatePenerima(input) {
        const penerima = input.value.trim();
        const errorElement = document.getElementById('penerima-error');
        
        if (!penerima) {
            errorElement.textContent = 'Nama penerima tidak boleh kosong';
            errorElement.classList.remove('hidden');
            input.setCustomValidity('Nama penerima tidak boleh kosong');
        } else {
            errorElement.textContent = '';
            errorElement.classList.add('hidden');
            input.setCustomValidity('');
        }
    }

    function validateNomorSuratBalasan(input) {
        const nomorSurat = input.value.trim();
        const errorElement = document.getElementById('nomor-surat-error');
        
        if (!nomorSurat) {
            errorElement.textContent = 'Nomor surat tidak boleh kosong';
            errorElement.classList.remove('hidden');
            input.setCustomValidity('Nomor surat tidak boleh kosong');
            return;
        }

        // Kirim request ke server untuk cek nomor surat
        fetch('/check-nomor-surat-balasan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nomor_surat: nomorSurat })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                errorElement.textContent = 'Nomor surat balasan ini sudah digunakan. Silakan gunakan nomor surat yang berbeda.';
                errorElement.classList.remove('hidden');
                input.setCustomValidity('Nomor surat balasan ini sudah digunakan');
            } else {
                errorElement.textContent = '';
                errorElement.classList.add('hidden');
                input.setCustomValidity('');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function validateDraft(event) {
        event.preventDefault();
        
        // Validate nomor surat
        const nomorSuratInput = document.getElementById('id_surat_balasan');
        validateNomorSuratBalasan(nomorSuratInput);
        if (nomorSuratInput.validationMessage) {
            return false;
        }
        
        // Validate penerima
        const penerimaInput = document.getElementById('nama_yang_dituju');
        validatePenerima(penerimaInput);
        if (penerimaInput.validationMessage) {
            return false;
        }
        
        // Check if editor content is empty
        const editorData = editorInstance.getData();
        if (!editorData || editorData.trim() === '') {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Isi surat tidak boleh kosong!',
                icon: 'warning',
                confirmButtonColor: '#0c3252',
                confirmButtonText: 'OK'
            });
            return false;
        }

        // If content is not empty, submit the form as draft
        const form = document.getElementById('suratForm');
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'draft';
        form.appendChild(actionInput);
        form.submit();
        return false;
    }

    function confirmSubmit(event, action) {
        event.preventDefault();
        
        // Validate nomor surat
        const nomorSuratInput = document.getElementById('id_surat_balasan');
        validateNomorSuratBalasan(nomorSuratInput);
        if (nomorSuratInput.validationMessage) {
            return false;
        }
        
        // Validate penerima
        const penerimaInput = document.getElementById('nama_yang_dituju');
        validatePenerima(penerimaInput);
        if (penerimaInput.validationMessage) {
            return false;
        }
        
        // Check if editor content is empty
        const editorData = editorInstance.getData();
        if (!editorData || editorData.trim() === '') {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Isi surat tidak boleh kosong!',
                icon: 'warning',
                confirmButtonColor: '#0c3252',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'OK'
            });
            return false;
        }

        const title = 'Buat Surat Balasan';
        const text = 'Apakah Anda yakin ingin membuat surat balasan?';
        const icon = 'question';
        const confirmButtonText = 'Ya, Buat Surat';
        const cancelButtonText = 'Batal';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#0c3252',
            cancelButtonColor: '#6B7280',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = event.target.form;
                form.submit();
            }
        });
        return false;
    }

    document.addEventListener("DOMContentLoaded", function () {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editorInstance = editor;

                // Sinkronisasi isi CKEditor saat submit
                const form = document.querySelector('form');
                form.addEventListener('submit', function (e) {
                    const editorData = editor.getData();
                    const action = document.querySelector('button[type="submit"]:focus')?.value;
                    
                    // Validate nomor surat
                    const nomorSuratInput = document.getElementById('id_surat_balasan');
                    validateNomorSuratBalasan(nomorSuratInput);
                    if (nomorSuratInput.validationMessage) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Validate penerima
                    const penerimaInput = document.getElementById('nama_yang_dituju');
                    validatePenerima(penerimaInput);
                    if (penerimaInput.validationMessage) {
                        e.preventDefault();
                        return;
                    }

                    // Only validate for submit action, not for draft
                    if (action === 'submit' && (!editorData || editorData.trim() === '')) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Isi surat tidak boleh kosong!',
                            icon: 'warning',
                            confirmButtonColor: '#0c3252',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    // Set data ke textarea secara eksplisit agar bisa dikirim
                    document.querySelector('#editor').value = editorData;
                });
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>



@endsection
