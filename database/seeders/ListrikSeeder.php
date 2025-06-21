<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListrikSeeder extends Seeder
{
    public function run(): void
    {
        $sumberList = ['pln', 'non_pln', 'pembangkit_sendiri'];
        $peruntukkanList = [
            'Penerangan',
            'Mesin Produksi',
            'Pendingin Ruangan',
            'Operasional Umum',
            'Lainnya'
        ];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            DB::table('listrik')->insert([
                'id_ikm' => $idIkm,
                'sumber' => $sumberList[array_rand($sumberList)],
                'banyaknya' => rand(100, 10000) + (rand(0, 99) / 100), 
                'nilai' => rand(50000, 3000000),
                'peruntukkan' => $peruntukkanList[array_rand($peruntukkanList)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
