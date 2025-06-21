<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BentukPengelolaanLimbahSeeder extends Seeder
{
    public function run(): void
    {
        $parameterCair = ['debit_inlet', 'debit_outlet', 'cod_inlet', 'cod_outlet', 'sludge_removed'];
        $tpsList = ['TPS Zona A', 'TPS Blok B', 'TPS Industri 1', 'TPS Khusus Limbah B3'];
        $mitraList = ['PT Bersih Alam', 'CV Hijau Lestari', 'PT Mitra Lingkungan'];
        $internalList = ['Digunakan untuk pupuk', 'Didaur ulang', 'Diproses kembali'];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            DB::table('bentuk_pengelolaan_limbah')->insert([
                'id_ikm' => $idIkm,
                'jenis_limbah' => 'Limbah Organik',
                'jumlah_limbah' => rand(10, 100) / 10, // ton

                'jenis_limbah_b3' => 'Oli Bekas',
                'jumlah_limbah_b3' => rand(1, 30) / 10,
                'tps_limbah_b3' => $tpsList[array_rand($tpsList)],

                'pihak_berizin' => $mitraList[array_rand($mitraList)],
                'internal_industri' => $internalList[array_rand($internalList)],

                'parameter_limbah_cair' => $parameterCair[array_rand($parameterCair)],
                'jumlah_limbah_cair' => rand(5, 50) / 10, // m3, mg/L, atau kg tergantung parameternya

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
