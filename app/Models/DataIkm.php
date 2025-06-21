<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIkm extends Model
{
    use HasFactory;

    protected $table = 'data_ikm';
    protected $primaryKey = 'id_ikm';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_ikm',
        'luas',
        'nama_pemilik',
        'jenis_kelamin',
        'kecamatan',
        'kelurahan',
        'komoditi',
        'jenis_industri',
        'alamat',
        'nib',
        'no_telp',
        'tenaga_kerja',
        'level'
    ];

    // === RELASI ===

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id_ikm');
    }

    public function persentasePemilik()
    {
        return $this->hasOne(PersentasePemilik::class, 'id_ikm', 'id_ikm');
    }

    public function pemakaianBahan()
    {
        return $this->hasMany(PemakaianBahan::class, 'id_ikm', 'id_ikm');
    }

    public function penggunaanAir()
    {
        return $this->hasOne(PenggunaanAir::class, 'id_ikm');
    }

    public function pengeluaran()
    {
        return $this->hasOne(Pengeluaran::class, 'id_ikm', 'id_ikm');
    }

    public function penggunaanBahanBakar()
    {
        return $this->hasMany(PenggunaanBahanBakar::class, 'id_ikm', 'id_ikm');
    }

    public function listrik()
    {
        return $this->hasOne(Listrik::class, 'id_ikm');
    }

    public function mesinProduksi()
    {
        return $this->hasMany(MesinProduksi::class, 'id_ikm', 'id_ikm');
    }

    public function produksi()
    {
        return $this->hasMany(Produksi::class, 'id_ikm', 'id_ikm');
    }

    public function persediaan()
    {
        return $this->hasMany(Persediaan::class, 'id_ikm', 'id_ikm');
    }

    public function pendapatan()
    {
        return $this->hasMany(Pendapatan::class, 'id_ikm', 'id_ikm');
    }

    public function modal()
    {
        return $this->hasMany(Modal::class, 'id_ikm', 'id_ikm');
    }

    public function bentukPengelolaanLimbah()
    {
        return $this->hasOne(BentukPengelolaanLimbah::class, 'id_ikm', 'id_ikm');
    }

    public function hitungLevel()
    {
        $this->loadMissing([
            'pemakaianBahan',
            'penggunaanAir',
            'pengeluaran',
            'penggunaanBahanBakar',
            'listrik',
            'persediaan',
            'pendapatan',
            'modal',
        ]);

        $pengeluaran = $this->pengeluaran;
        $listrik = $this->listrik;

        return
            $this->pemakaianBahan->sum('nilai_dalam_negeri') +
            $this->pemakaianBahan->sum('nilai_impor') +
            ($this->penggunaanAir->biaya ?? 0) +
            ($pengeluaran->upah_gaji ?? 0) +
            ($pengeluaran->pengeluaran_industri_distribusi ?? 0) +
            ($pengeluaran->pengeluaran_rnd ?? 0) +
            ($pengeluaran->pengeluaran_tanah ?? 0) +
            ($pengeluaran->pengeluaran_gedung ?? 0) +
            ($pengeluaran->pengeluaran_mesin ?? 0) +
            ($pengeluaran->lainnya ?? 0) +
            $this->penggunaanBahanBakar->sum('nilai_proses_produksi') +
            $this->penggunaanBahanBakar->sum('nilai_pembangkit_tenaga_listrik') +
            ($listrik->nilai ?? 0) +
            $this->persediaan->sum('awal') +
            $this->persediaan->sum('akhir') +
            $this->pendapatan->sum('nilai') +
            $this->modal->sum('pembelian_penambahan_perbaikan') +
            $this->modal->sum('pengurangan_barang_modal') +
            $this->modal->sum('penyusutan_barang') +
            $this->modal->sum('nilai_taksiran');
    }
}
