<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersediaanSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPersediaanList = [
            'persediaan_bahan',
            'setengah_jadi',
            'barang_jadi'
        ];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            DB::table('persediaan')->insert([
                'id_ikm' => $idIkm,
                'jenis_persediaan' => $jenisPersediaanList[array_rand($jenisPersediaanList)],
                'awal' => rand(50000, 1000000),
                'akhir' => rand(50000, 1000000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
