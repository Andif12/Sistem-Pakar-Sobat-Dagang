<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendapatanSeeder extends Seeder
{
    public function run(): void
    {
        $sumberPendapatanList = [
            'Penjualan Produk',
            'Jasa Produksi',
            'Hasil Sewa',
            'Penjualan Online',
            'Ekspor Langsung',
            'Ekspor Tidak Langsung',
        ];

        for ($i = 1; $i <= 40; $i++) {
            DB::table('pendapatan')->insert([
                'id_ikm' => $i,
                'sumber' => $sumberPendapatanList[array_rand($sumberPendapatanList)],
                'nilai' => rand(100000, 10000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
