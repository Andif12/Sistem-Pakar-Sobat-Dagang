<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProduksiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisProduksiList = ['Makanan', 'Minuman', 'Pakaian', 'Kerajinan', 'Elektronik'];
        $satuanList = ['kg', 'bungkus', 'biji', 'ton', 'buah', 'liter', 'galon', 'dos', 'balok', 'meter', 'set', 'lusin', 'potong', 'lembar', 'm3', 'tabung', 'unit'];
        $negaraList = ['Jepang', 'Singapura', 'Amerika Serikat', 'Malaysia', 'Australia', 'Korea Selatan', ''];


        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            $jumlahProduksi = rand(1, 3); // 1–3 data per IKM

            for ($i = 0; $i < $jumlahProduksi; $i++) {
                $jenis = $jenisProduksiList[array_rand($jenisProduksiList)];
                $kbli = rand(10000, 99999);
                $hs = rand(100000, 999999);
                $nilai = rand(100000, 5000000);
                $satuan = $satuanList[array_rand($satuanList)];
                $persenEkspor = round(rand(0, 10000) / 100, 2); // 0.00 - 100.00
                $negara = $negaraList[array_rand($negaraList)];

                DB::table('produksi')->insert([
                    'id_ikm' => $idIkm,
                    'jenis_produksi' => $jenis,
                    'kbli' => $kbli,
                    'kode_hs' => $hs,
                    'spesifikasi' => 'Spesifikasi ' . $jenis . ' ' . strtoupper(Str::random(2)),
                    'banyaknya' => rand(10, 1000),
                    'nilai' => $nilai,
                    'satuan' => $satuan,
                    'presentase_produk_ekspor' => $persenEkspor,
                    'negara_tujuan_ekspor' => $negara ?: null,
                    'kapasitas_terpasang_per_tahun' => rand(500, 10000),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
