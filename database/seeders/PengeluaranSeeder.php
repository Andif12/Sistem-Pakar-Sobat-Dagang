<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            DB::table('pengeluaran')->insert([
                'id_ikm' => $idIkm,
                'upah_gaji' => rand(500000, 5000000),
                'pengeluaran_industri_distribusi' => rand(100000, 2000000),
                'pengeluaran_rnd' => rand(50000, 1500000),
                'pengeluaran_tanah' => rand(1000000, 10000000),
                'pengeluaran_gedung' => rand(2000000, 15000000),
                'pengeluaran_mesin' => rand(300000, 8000000),
                'lainnya' => rand(50000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
