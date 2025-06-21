<?php

namespace Database\Seeders;

use App\Models\DataIkm;
use Illuminate\Database\Seeder;

class IndustriSeeder extends Seeder
{
    /**
     * Jalankan semua seeder yang dibutuhkan untuk data industri.
     */
    public function run(): void
    {
        $this->call([
            DataIKMSeeder::class,
            PersentasePemilikSeeder::class,
            KaryawanSeeder::class,
            PemakaianBahanSeeder::class,
            PenggunaanAirSeeder::class,
            PengeluaranSeeder::class,
            PenggunaanBahanBakarSeeder::class,
            ListrikSeeder::class,
            MesinProduksiSeeder::class,
            ProduksiSeeder::class,
            PersediaanSeeder::class,
            PendapatanSeeder::class,
            ModalSeeder::class,
            BentukPengelolaanLimbahSeeder::class
        ]);

        // Update kolom level untuk semua data IKM setelah semua seeder dijalankan
        $dataIkms = DataIkm::all();
        foreach ($dataIkms as $ikm) {
            $ikm->level = $ikm->hitungLevel();
            $ikm->save();
        }
    }
}
