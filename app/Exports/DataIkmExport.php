<?php

namespace App\Exports;

use App\Models\DataIKM;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataIkmExport implements WithMultipleSheets
{
    protected $filterJenis;
    protected $filterKecamatan;
    protected $filterInvestasi;

    public function __construct(array $filterJenis = [], ?string $filterKecamatan = null, ?array $filterInvestasi = null)
    {
        $this->filterJenis = $filterJenis;
        $this->filterKecamatan = $filterKecamatan;
        $this->filterInvestasi = $filterInvestasi;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->filterJenis as $jenis) {
            $sheet = new IKMFullExportSheet($jenis, $this->filterKecamatan, $this->filterInvestasi);
            $collection = $sheet->collection();
            if ($collection && $collection->isNotEmpty()) {
                $sheets[] = $sheet;
            }
        }

        if (empty($sheets)) {
            $sheets[] = new IKMFullExportSheet(null, $this->filterKecamatan, $this->filterInvestasi);
        }

        return $sheets;
    }
}

class IKMFullExportSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $jenis;
    protected $kecamatan;
    protected $investasi;
    protected $cachedData;

    public function __construct(?string $jenis, ?string $kecamatan = null, ?array $investasi = null)
    {
        $this->jenis = $jenis;
        $this->kecamatan = $kecamatan;
        $this->investasi = $investasi;
    }


    public function collection()
    {
        if ($this->cachedData !== null) {
            return $this->cachedData;
        }
        $query = DataIKM::with([
            'karyawan',
            'persentasePemilik',
            'pemakaianBahan',
            'penggunaanAir',
            'pengeluaran',
            'penggunaanBahanBakar',
            'listrik',
            'mesinProduksi',
            'produksi',
            'persediaan',
            'pendapatan',
            'modal',
            'bentukPengelolaanLimbah',
        ]);
        if ($this->jenis !== null) {
            $query->where('jenis_industri', $this->jenis);
        }

        if ($this->kecamatan !== null) {
            $query->where('kecamatan', $this->kecamatan);
        }
        if ($this->investasi !== null && count($this->investasi) > 0) {
            $query->where(function ($q) {
                foreach ($this->investasi as $kategori) {
                    if ($kategori === 'kecil') {
                        $q->orWhere('level', '<', 100000000);
                    } elseif ($kategori === 'menengah') {
                        $q->orWhereBetween('level', [100000000, 999999999]);
                    } elseif ($kategori === 'besar') {
                        $q->orWhere('level', '>=', 1000000000);
                    }
                }
            });
        }

        $this->cachedData = $query->get()->map(function ($ikm) {
            return [
                'id_ikm' => $ikm->id_ikm,
                'nama_ikm' => $ikm->nama_ikm,
                'luas' => $ikm->luas,
                'nama_pemilik' => $ikm->nama_pemilik,
                'jenis_kelamin' => $ikm->jenis_kelamin,
                'kecamatan' => $ikm->kecamatan,
                'kelurahan' => $ikm->kelurahan,
                'komoditi' => $ikm->komoditi,
                'jenis_industri' => $ikm->jenis_industri,
                'alamat' => $ikm->alamat,
                'nib' => $ikm->nib,
                'no_telp' => $ikm->no_telp,
                'tenaga_kerja' => $ikm->tenaga_kerja,
                'investasi' => $ikm->level,

                'pemerintah_pusat' => $ikm->persentasePemilik->pemerintah_pusat ?? 0,
                'pemerintah_daerah' => $ikm->persentasePemilik->pemerintah_daerah ?? 0,
                'swasta_nasional' => $ikm->persentasePemilik->swasta_nasional ?? 0,
                'asing' => $ikm->persentasePemilik->asing ?? 0,

                'tenaga_kerja_tetap' => $ikm->karyawan->tenaga_kerja_tetap ?? 0,
                'tenaga_kerja_tidak_tetap' => $ikm->karyawan->tenaga_kerja_tidak_tetap ?? 0,
                'tenaga_kerja_laki_laki' => $ikm->karyawan->tenaga_kerja_laki_laki ?? 0,
                'tenaga_kerja_perempuan' => $ikm->karyawan->tenaga_kerja_perempuan ?? 0,
                'sd' => $ikm->karyawan->sd ?? 0,
                'smp' => $ikm->karyawan->smp ?? 0,
                'sma_smk' => $ikm->karyawan->sma_smk ?? 0,
                'd1_d3' => $ikm->karyawan->d1_d3 ?? 0,
                's1_d4' => $ikm->karyawan->s1_d4 ?? 0,
                's2' => $ikm->karyawan->s2 ?? 0,
                's3' => $ikm->karyawan->s3 ?? 0,

                'nama_bahan' => $ikm->pemakaianBahan->pluck('nama_bahan')->implode('; '),
                'jenis_bahan' => $ikm->pemakaianBahan->pluck('jenis_bahan')->implode('; '),
                'spesifikasi' => $ikm->pemakaianBahan->pluck('spesifikasi')->implode('; '),
                'kode_hs' => $ikm->pemakaianBahan->pluck('kode_hs')->implode('; '),
                'satuan_standar' => $ikm->pemakaianBahan->pluck('satuan_standar')->implode('; '),
                'jumlah_dalam_negeri' => $ikm->pemakaianBahan->pluck('jumlah_dalam_negeri')->implode('; '),
                'nilai_dalam_negeri' => $ikm->pemakaianBahan->pluck('nilai_dalam_negeri')->implode('; '),
                'jumlah_impor' => $ikm->pemakaianBahan->pluck('jumlah_impor')->implode('; '),
                'nilai_impor' => $ikm->pemakaianBahan->pluck('nilai_impor')->implode('; '),
                'negara_asal_impor' => $ikm->pemakaianBahan->pluck('negara_asal_impor')->implode('; '),

                'sumber_air' => $ikm->penggunaanAir->sumber_air ?? '',
                'banyaknya_penggunaan_m3' => $ikm->penggunaanAir->banyaknya_penggunaan_m3 ?? 0,
                'biaya_air' => $ikm->penggunaanAir->biaya ?? 0,

                'upah_gaji' => $ikm->pengeluaran->upah_gaji ?? 0,
                'pengeluaran_industri_distribusi' => $ikm->pengeluaran->pengeluaran_industri_distribusi ?? 0,
                'pengeluaran_rnd' => $ikm->pengeluaran->pengeluaran_rnd ?? 0,
                'pengeluaran_tanah' => $ikm->pengeluaran->pengeluaran_tanah ?? 0,
                'pengeluaran_gedung' => $ikm->pengeluaran->pengeluaran_gedung ?? 0,
                'pengeluaran_mesin' => $ikm->pengeluaran->pengeluaran_mesin ?? 0,
                'pengeluaran_lainnya' => $ikm->pengeluaran->lainnya ?? 0,

                'jenis_bahan_bakar' => $ikm->penggunaanBahanBakar->pluck('jenis_bahan_bakar')->implode('; '),
                'satuan_bahan_bakar' => $ikm->penggunaanBahanBakar->pluck('satuan_standar')->implode('; '),
                'proses_produksi_banyak' => $ikm->penggunaanBahanBakar->pluck('banyaknya_proses_produksi')->implode('; '),
                'proses_produksi_nilai' => $ikm->penggunaanBahanBakar->pluck('nilai_proses_produksi')->implode('; '),
                'ptl_banyak' => $ikm->penggunaanBahanBakar->pluck('banyaknya_pembangkit_tenaga_listrik')->implode('; '),
                'ptl_nilai' => $ikm->penggunaanBahanBakar->pluck('nilai_pembangkit_tenaga_listrik')->implode('; '),

                'sumber_listrik' => collect($ikm->listrik)->pluck('sumber')->implode('; '),
                'penggunaan_listrik' => collect($ikm->listrik)->pluck('banyaknya')->implode('; '),
                'nilai_listrik' => collect($ikm->listrik)->pluck('nilai')->implode('; '),
                'peruntukkan_listrik' => collect($ikm->listrik)->pluck('peruntukkan')->implode('; '),


                'jenis_mesin' => $ikm->mesinProduksi->pluck('jenis_mesin')->implode('; '),
                'nama_mesin' => $ikm->mesinProduksi->pluck('nama_mesin')->implode('; '),
                'merk_type' => $ikm->mesinProduksi->pluck('merk_type')->implode('; '),
                'teknologi' => $ikm->mesinProduksi->pluck('teknologi')->implode('; '),
                'negara_pembuat' => $ikm->mesinProduksi->pluck('negara_pembuat')->implode('; '),
                'tahun_perolehan' => $ikm->mesinProduksi->pluck('tahun_perolehan')->implode('; '),
                'tahun_pembuatan' => $ikm->mesinProduksi->pluck('tahun_pembuatan')->implode('; '),
                'jumlah_unit' => $ikm->mesinProduksi->pluck('jumlah_unit')->implode('; '),

                'jenis_produksi' => $ikm->produksi->pluck('jenis_produksi')->implode('; '),
                'kbli' => $ikm->produksi->pluck('kbli')->implode('; '),
                'kode_hs_produksi' => $ikm->produksi->pluck('kode_hs')->implode('; '),
                'spesifikasi_produksi' => $ikm->produksi->pluck('spesifikasi')->implode('; '),
                'jumlah_produksi' => $ikm->produksi->pluck('banyaknya')->implode('; '),
                'nilai_produksi' => $ikm->produksi->pluck('nilai')->implode('; '),
                'satuan_produksi' => $ikm->produksi->pluck('satuan')->implode('; '),
                'persen_ekspor' => $ikm->produksi->pluck('presentase_produk_ekspor')->implode('; '),
                'negara_ekspor' => $ikm->produksi->pluck('negara_tujuan_ekspor')->implode('; '),
                'kapasitas_tahun' => $ikm->produksi->pluck('kapasitas_terpasang_per_tahun')->implode('; '),

                'modal_jenis_barang' => collect($ikm->modal)->pluck('jenis_barang')->implode('; '),
                'modal_pembelian' => collect($ikm->modal)->pluck('pembelian_penambahan_perbaikan')->implode('; '),
                'modal_pengurangan' => collect($ikm->modal)->pluck('pengurangan_barang_modal')->implode('; '),
                'modal_penyusutan' => collect($ikm->modal)->pluck('penyusutan_barang')->implode('; '),
                'modal_taksiran' => collect($ikm->modal)->pluck('nilai_taksiran')->implode('; '),


                'persediaan_jenis' => $ikm->persediaan->pluck('jenis_persediaan')->implode('; '),
                'persediaan_awal' => $ikm->persediaan->pluck('awal')->implode('; '),
                'persediaan_akhir' => $ikm->persediaan->pluck('akhir')->implode('; '),

                'pendapatan_sumber' => $ikm->pendapatan->pluck('sumber')->implode('; '),
                'pendapatan_nilai' => $ikm->pendapatan->pluck('nilai')->implode('; '),

                'jenis_limbah' => $ikm->bentukPengelolaanLimbah->jenis_limbah ?? '',
                'jumlah_limbah' => $ikm->bentukPengelolaanLimbah->jumlah_limbah ?? 0,
                'jenis_limbah_b3' => $ikm->bentukPengelolaanLimbah->jenis_limbah_b3 ?? '',
                'jumlah_limbah_b3' => $ikm->bentukPengelolaanLimbah->jumlah_limbah_b3 ?? 0,
                'tps_limbah_b3' => $ikm->bentukPengelolaanLimbah->tps_limbah_b3 ?? '',
                'pihak_berizin' => $ikm->bentukPengelolaanLimbah->pihak_berizin ?? '',
                'internal_industri' => $ikm->bentukPengelolaanLimbah->internal_industri ?? '',
                'parameter_limbah_cair' => $ikm->bentukPengelolaanLimbah->parameter_limbah_cair ?? '',
                'jumlah_limbah_cair' => $ikm->bentukPengelolaanLimbah->jumlah_limbah_cair ?? 0,
            ];
        });
        return $this->cachedData;
    }

    public function headings(): array
    {
        $first = $this->collection()->first();
        return $first && is_array($first) ? array_keys($first) : [];
    }

    public function title(): string
    {
        return $this->jenis ?? 'Data IKM';
    }
}
