<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MesinProduksiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisList = ['Mesin', 'Peralatan'];
        $namaMesinList = ['Dryer', 'Grinder', 'Press', 'Mixer', 'Cutter', 'Sealer', 'Oven'];
        $teknologiList = ['Teknologi Manual', 'Semi Otomatis', 'Otomatis', 'Digital Precision'];
        $negaraList = ['Jepang', 'Jerman', 'Indonesia', 'Korea Selatan', 'Tiongkok', 'Amerika Serikat'];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            $jumlahMesin = rand(1, 3); // 1–3 data per IKM

            for ($i = 0; $i < $jumlahMesin; $i++) {
                $nama = $namaMesinList[array_rand($namaMesinList)];
                $tahun = rand(2015, 2024);

                DB::table('mesin_produksi')->insert([
                    'id_ikm' => $idIkm,
                    'jenis_mesin' => $jenisList[array_rand($jenisList)],
                    'nama_mesin' => $nama . ' ' . Str::random(3),
                    'merk_type' => strtoupper(Str::random(3)) . '-' . rand(100, 9999),
                    'teknologi' => $teknologiList[array_rand($teknologiList)],
                    'negara_pembuat' => $negaraList[array_rand($negaraList)],
                    'tahun_perolehan' => $tahun,
                    'tahun_pembuatan' => $tahun - rand(0, 3),
                    'jumlah_unit' => rand(1, 5),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
