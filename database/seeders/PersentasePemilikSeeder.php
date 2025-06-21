<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersentasePemilikSeeder extends Seeder
{
    public function run(): void
    {
        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            $sisa = 100;

            $pemerintahPusat = rand(0, $sisa);
            $sisa -= $pemerintahPusat;

            $pemerintahDaerah = rand(0, $sisa);
            $sisa -= $pemerintahDaerah;

            $swastaNasional = rand(0, $sisa);
            $sisa -= $swastaNasional;

            $asing = $sisa;

            DB::table('persentase_pemilik')->insert([
                'id_ikm' => $idIkm,
                'pemerintah_pusat' => number_format($pemerintahPusat, 2, '.', ''),
                'pemerintah_daerah' => number_format($pemerintahDaerah, 2, '.', ''),
                'swasta_nasional' => number_format($swastaNasional, 2, '.', ''),
                'asing' => number_format($asing, 2, '.', ''),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
