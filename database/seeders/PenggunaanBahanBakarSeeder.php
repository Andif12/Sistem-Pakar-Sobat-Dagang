<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenggunaanBahanBakarSeeder extends Seeder
{
    public function run(): void
    {
        $jenisBahanBakar = [
            'bensin',
            'solar_hsd_ado',
            'batubara',
            'briket_batubara',
            'gas_dari_pgn',
            'gas_bukan_dari_pgn',
            'cng',
            'lpg',
            'pelumas'
        ];

        $satuanList = ['liter', 'ton', 'mmbtu', 'kg'];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            $jumlahData = rand(1, 3);
            for ($i = 0; $i < $jumlahData; $i++) {
                DB::table('penggunaan_bahan_bakar')->insert([
                    'id_ikm' => $idIkm,
                    'jenis_bahan_bakar' => $jenisBahanBakar[array_rand($jenisBahanBakar)],
                    'satuan_standar' => $satuanList[array_rand($satuanList)],
                    'banyaknya_proses_produksi' => rand(10, 150) + (rand(0, 99) / 100),
                    'nilai_proses_produksi' => rand(100000, 3000000),
                    'banyaknya_pembangkit_tenaga_listrik' => rand(5, 100) + (rand(0, 99) / 100),
                    'nilai_pembangkit_tenaga_listrik' => rand(50000, 1500000),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
