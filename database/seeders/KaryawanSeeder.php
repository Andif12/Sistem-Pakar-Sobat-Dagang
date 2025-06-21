<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $ikms = DB::table('data_ikm')->get();

        foreach ($ikms as $ikm) {
            $total = $ikm->tenaga_kerja;

            // Default semua nilai 0
            $tetap = 0;
            $tidakTetap = 0;
            $lakiLaki = 0;
            $perempuan = 0;
            $pendidikan = array_fill_keys(['sd', 'smp', 'sma_smk', 'd1_d3', 's1_d4', 's2', 's3'], 0);

            if ($total > 0) {
                $tetap = rand(0, $total);
                $tidakTetap = $total - $tetap;

                $lakiLaki = rand(0, $total);
                $perempuan = $total - $lakiLaki;

                $pendidikan = $this->distributePendidikan($total);
            }

            DB::table('karyawan')->insert([
                'id_ikm' => $ikm->id_ikm,
                'tenaga_kerja_tetap' => $tetap,
                'tenaga_kerja_tidak_tetap' => $tidakTetap,
                'tenaga_kerja_laki_laki' => $lakiLaki,
                'tenaga_kerja_perempuan' => $perempuan,
                'sd' => $pendidikan['sd'],
                'smp' => $pendidikan['smp'],
                'sma_smk' => $pendidikan['sma_smk'],
                'd1_d3' => $pendidikan['d1_d3'],
                's1_d4' => $pendidikan['s1_d4'],
                's2' => $pendidikan['s2'],
                's3' => $pendidikan['s3'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function distributePendidikan(int $total): array
    {
        $levels = ['sd', 'smp', 'sma_smk', 'd1_d3', 's1_d4', 's2', 's3'];
        $result = array_fill_keys($levels, 0);
        $remaining = $total;

        foreach ($levels as $i => $level) {
            if ($i === count($levels) - 1) {
                $result[$level] = $remaining;
            } else {
                $jumlah = rand(0, $remaining);
                $result[$level] = $jumlah;
                $remaining -= $jumlah;
            }
        }

        return $result;
    }
}
