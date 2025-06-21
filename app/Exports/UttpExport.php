<?php

namespace App\Exports;

use App\Models\Uttp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UttpExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Uttp::with(['user', 'dataAlatUkur'])->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Mulai',
            'No Registrasi',
            'Nama Usaha',
            'Jenis Alat',
            'Merk/Type',
            'Nomor Seri',
            'Kapasitas',
            'Alat Penguji',
            'Cap Tanda Tera',
            'No Surat Perintah Tugas',
            'Tanggal Selesai',
            'Cerapan',
            'Keterangan',
            'Status',
            'Tanggal Expired',
            'Nama User',
            'Email User'
        ];
    }

    public function map($uttp): array
    {
        return [
            $uttp->tanggal_penginputan,
            $uttp->no_registrasi,
            $uttp->nama_usaha,
            $uttp->jenis_alat,
            $uttp->merk_type,
            $uttp->nomor_seri,
            $uttp->nama_alat,
            $uttp->alat_penguji,
            $uttp->ctt,
            $uttp->spt_keperluan,
            $uttp->tanggal_selesai,
            $uttp->terapan,
            $uttp->keterangan,
            $uttp->dataAlatUkur->status ?? '-',
            $uttp->dataAlatUkur->tanggal_exp ?? '-',
            $uttp->user->nama ?? '-',
            $uttp->user->email ?? '-'
        ];
    }
} 