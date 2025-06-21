<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalSeeder extends Seeder
{
    public function run(): void
    {
        $jenisBarangList = [
            'tanah',
            'gedung',
            'mesin dan perlengkapan',
            'kendaraan',
            'software/database'
        ];

        for ($idIkm = 1; $idIkm <= 40; $idIkm++) {
            $jumlahModal = rand(1, 3); 

            $jenisTerpilih = collect($jenisBarangList)->shuffle()->take($jumlahModal);

            foreach ($jenisTerpilih as $jenis) {
                DB::table('modal')->insert([
                    'id_ikm' => $idIkm,
                    'jenis_barang' => $jenis,
                    'pembelian_penambahan_perbaikan' => rand(100000, 10000000),
                    'pengurangan_barang_modal' => rand(50000, 3000000),
                    'penyusutan_barang' => rand(50000, 2000000),
                    'nilai_taksiran' => rand(500000, 15000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
