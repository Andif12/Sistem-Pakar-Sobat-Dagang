<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PemakaianBahanSeeder extends Seeder
{
    public function run(): void
    {
        $ikms = DB::table('data_ikm')->pluck('id_ikm'); // Ambil semua id_ikm
        $jenisBahan = ['Bahan Baku', 'Bahan Penolong'];
        $satuanList = ['kg', 'ton', 'liter', 'ml', 'm', 'm2', 'm3', 'pcs', 'drum', 'nm3'];
        $negaraList = ['Indonesia', 'Tiongkok', 'Malaysia', 'India', 'Jepang', 'Korea Selatan', 'Jerman', 'Amerika Serikat'];

        foreach ($ikms as $id_ikm) {
            $jumlahData = rand(1, 3);  

            for ($i = 0; $i < $jumlahData; $i++) {
                DB::table('pemakaian_bahan')->insert([
                    'id_ikm' => $id_ikm,
                    'nama_bahan' => 'Bahan ' . Str::random(5),
                    'jenis_bahan' => $jenisBahan[array_rand($jenisBahan)],
                    'spesifikasi' => 'Spesifikasi ' . chr(65 + rand(0, 3)), // A, B, C, D
                    'kode_hs' => 'HS' . rand(1000, 9999),
                    'satuan_standar' => $satuanList[array_rand($satuanList)],
                    'jumlah_dalam_negeri' => rand(10, 500),
                    'nilai_dalam_negeri' => rand(1_000_000, 10_000_000),
                    'jumlah_impor' => rand(0, 300),
                    'nilai_impor' => rand(500_000, 5_000_000),
                    'negara_asal_impor' => $negaraList[array_rand($negaraList)],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
