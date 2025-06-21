@extends('layouts.admin')

@section('title', 'Detail Permohonan')

@section('content')
<div class="px-4 py-6 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Detail Permohonan</h1>
            <p class="mt-2 text-sm text-gray-700">Informasi lengkap tentang permohonan surat.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.daftarPermohonan') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informasi Permohonan
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Detail permohonan surat dari {{ $permohonan->nama_pengirim }}
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Pengirim</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $permohonan->nama_pengirim }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Pengajuan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $bidang === 'metrologi' ? \Carbon\Carbon::parse($permohonan->created_at)->format('d-m-Y') : \Carbon\Carbon::parse($permohonan->tgl_pengajuan)->format('d-m-Y') }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @php
                            $status = $bidang === 'metrologi' ? $permohonan->status_surat_masuk : $permohonan->status;
                            $color = match($status) {
                                'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                'Disetujui' => 'bg-green-100 text-green-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                                'Diproses' => 'bg-blue-100 text-blue-800',
                                'Menunggu Persetujuan' => 'bg-blue-100 text-blue-800',
                                'Butuh Revisi' => 'bg-orange-100 text-orange-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $color }}">
                            {{ $status }}
                        </span>
                    </dd>
                </div>

                @if($bidang === 'metrologi')
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jenis Surat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($permohonan->jenis_surat) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Titik Koordinat Usaha</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $permohonan->alamat_alat }}</dd>
                </div>
                @else
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('_', ' ', $permohonan->kecamatan)) }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kelurahan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('_', ' ', $permohonan->kelurahan)) }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jenis Surat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst(str_replace('_', ' ', $permohonan->jenis_surat)) }}</dd>
                </div>
                @endif

                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">File Surat</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($bidang === 'metrologi' && $permohonan->dokumen)
                            <a href="{{ Storage::url($permohonan->dokumen) }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                Lihat File
                            </a>
                        @elseif($permohonan->file_surat)
                            <a href="{{ Storage::url($permohonan->file_surat) }}" class="text-blue-600 hover:text-blue-900" target="_blank">
                                Lihat File
                            </a>
                        @else
                            <span class="text-gray-500">Tidak ada file</span>
                        @endif
                    </dd>
                </div>

                @if($bidang === 'metrologi' && $permohonan->file_balasan)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">File Balasan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <a href="{{ route('admin.downloadBalasan', ['id' => $permohonan->id_surat, 'bidang' => $bidang]) }}" class="text-green-600 hover:text-green-900">
                            Download Balasan
                        </a>
                    </dd>
                </div>
                @elseif($permohonan->file_balasan)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">File Balasan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <a href="{{ route('admin.downloadBalasan', ['id' => $permohonan->id_permohonan, 'bidang' => $bidang]) }}" class="text-green-600 hover:text-green-900">
                            Download Balasan
                        </a>
                    </dd>
                </div>
                @endif

                @if($bidang === 'metrologi' && $permohonan->isi_balasan)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Isi Balasan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {!! $permohonan->isi_balasan !!}
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection 