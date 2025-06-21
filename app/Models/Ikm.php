<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikm extends Model
{
    use HasFactory;

    protected $table = 'data_ikm';
    protected $primaryKey = 'id_ikm';

    protected $fillable = [
        'id_distrik',
        'id_pemilik',
        'id_karyawan',
        'id_pemakaian_bahan',
        'id_srt',
        'id_pengeluaran',
        'id_bahan_bakar',
        'id_listrik',
        'id_produk',
        'id_mesin',
        'id_pendidikan',
        'id_pendapatan',
        'id_modal',
        'id_lembur',
        'nama_pemilik',
        'nama_ikm',
        'alamat',
        'no_telpon',
        'luas',
        'jenis_industri',
        'komoditi',
        'jumlah_tenaga_kerja',
        'nilai_investasi',
        'nib',
    ];

    public function sertifikasiHalal()
    {
        return $this->hasMany(SertifikasiHalal::class, 'id_ikm', 'id_ikm');
    }
}
