<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaanAirSeeder extends Seeder
{
    public function run(): void
    {
        $sumberAirList = ['PDAM', 'Sumur Bor', 'Air Hujan', 'Air Sungai'];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            DB::table('penggunaan_air')->insert([
                'id_ikm' => $idIkm,
                'sumber_air' => $sumberAirList[array_rand($sumberAirList)],
                'banyaknya_penggunaan_m3' => rand(5, 30) + (rand(0, 100) / 100), // contoh: 12.75
                'biaya' => rand(20000, 200000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
