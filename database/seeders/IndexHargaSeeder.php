<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndexHargaSeeder extends Seeder
{
    public function run()
    {
        $tanggal = now()->toDateString();
        $lokasiList = ['Pasar Sumpang', 'Pasar Lakessi']; 

        $data = [
            ['id_barang' => 1,  'id_index_kategori' => 1, 'harga' => 16000.00],
            ['id_barang' => 2,  'id_index_kategori' => 1, 'harga' => 13100.00],
            ['id_barang' => 3,  'id_index_kategori' => 1, 'harga' => 13000.00],
            ['id_barang' => 4,  'id_index_kategori' => 1, 'harga' => 12000.00],
            ['id_barang' => 5,  'id_index_kategori' => 1, 'harga' => 0.00],          // Beras Varietas Banda (Medium)
            ['id_barang' => 6,  'id_index_kategori' => 11, 'harga' => 18000.00],
            ['id_barang' => 7,  'id_index_kategori' => 12, 'harga' => 17550.00],
            ['id_barang' => 8,  'id_index_kategori' => 12, 'harga' => 17000.00],
            ['id_barang' => 9,  'id_index_kategori' => 12, 'harga' => 20000.00],
            ['id_barang' => 10, 'id_index_kategori' => 12, 'harga' => 15500.00],
            ['id_barang' => 11, 'id_index_kategori' => 13, 'harga' => 10500.00],
            ['id_barang' => 12, 'id_index_kategori' => 3, 'harga' => 31400.00],
            ['id_barang' => 13, 'id_index_kategori' => 3, 'harga' => 50000.00],
            ['id_barang' => 14, 'id_index_kategori' => 6, 'harga' => 130000.00],
            ['id_barang' => 15, 'id_index_kategori' => 6, 'harga' => 130000.00],
            ['id_barang' => 16, 'id_index_kategori' => 6, 'harga' => 130000.00],
            ['id_barang' => 17, 'id_index_kategori' => 6, 'harga' => 130000.00],
            ['id_barang' => 18, 'id_index_kategori' => 6, 'harga' => 130000.00],
            ['id_barang' => 19, 'id_index_kategori' => 6, 'harga' => 100000.00],
            ['id_barang' => 20, 'id_index_kategori' => 6, 'harga' => 0.00],          // Daging Sapi Impor Beku
            ['id_barang' => 21, 'id_index_kategori' => 5, 'harga' => 29400.00],     // Telur Ayam Ras
            ['id_barang' => 22, 'id_index_kategori' => 5, 'harga' => 50000.00],     // Telur Ayam Kampung
            ['id_barang' => 23, 'id_index_kategori' => 14, 'harga' => 42200.00],     // Susu Bubuk Balita Dancow
            ['id_barang' => 24, 'id_index_kategori' => 14, 'harga' => 43800.00],     // Susu Bubuk Balita SGM
            ['id_barang' => 25, 'id_index_kategori' => 14, 'harga' => 12500.00],     // Susu Kental Manis Frisian Flag
            ['id_barang' => 26, 'id_index_kategori' => 8, 'harga' => 10000.00],     // Tahu
            ['id_barang' => 27, 'id_index_kategori' => 9, 'harga' => 15000.00],     // Tempe
            ['id_barang' => 28, 'id_index_kategori' => 4, 'harga' => 38300.00],     // Bawang Merah
            ['id_barang' => 29, 'id_index_kategori' => 4, 'harga' => 45000.00],     // Bawang Putih
            ['id_barang' => 30, 'id_index_kategori' => 4, 'harga' => 36700.00],     // Bawang Bombay
            ['id_barang' => 31, 'id_index_kategori' => 7, 'harga' => 35000.00],     // Ikan Tuna
            ['id_barang' => 32, 'id_index_kategori' => 7, 'harga' => 30000.00],     // Ikan Bandeng
            ['id_barang' => 33, 'id_index_kategori' => 7, 'harga' => 95000.00],     // Ikan Teri Asin
            ['id_barang' => 34, 'id_index_kategori' => 7, 'harga' => 0.00],         // Ikan Asin
            ['id_barang' => 35, 'id_index_kategori' => 7, 'harga' => 28300.00],     // Ikan Cakalang
            ['id_barang' => 36, 'id_index_kategori' => 7, 'harga' => 30000.00],     // Ikan Kembung
            ['id_barang' => 37, 'id_index_kategori' => 15, 'harga' => 0.00],         // Garam Bata
            ['id_barang' => 38, 'id_index_kategori' => 15, 'harga' => 10000.00],     // Garam Halus
            ['id_barang' => 39, 'id_index_kategori' => 16,'harga' => 0.00],         // Kedelai Lokal
            ['id_barang' => 40, 'id_index_kategori' => 16,'harga' => 13000.00],     // Kedelai Impor
            ['id_barang' => 41, 'id_index_kategori' => 17,'harga' => 3000.00],      // Mie Instan
            ['id_barang' => 42, 'id_index_kategori' => 2, 'harga' => 40000.00],     // Cabe Merah Keriting
            ['id_barang' => 43, 'id_index_kategori' => 2, 'harga' => 37700.00],     // Cabe Merah Besar
            ['id_barang' => 44, 'id_index_kategori' => 2, 'harga' => 73300.00],     // Cabe Rawit Merah
            ['id_barang' => 45, 'id_index_kategori' => 2, 'harga' => 0.00],         // Cabe Rawit Hijau
            ['id_barang' => 46, 'id_index_kategori' => 18,'harga' => 30000.00],     // Kacang Tanah
            ['id_barang' => 47, 'id_index_kategori' => 18,'harga' => 20000.00],     // Kacang Hijau
            ['id_barang' => 48, 'id_index_kategori' => 19,'harga' => 10000.00],     // Ubi Ketela Pohon
            ['id_barang' => 49, 'id_index_kategori' => 20,'harga' => 5000.00],      // Jagung Pipilan Kuning
            ['id_barang' => 50, 'id_index_kategori' => 21,'harga' => 2250.00],      // Harga Pupuk Bersubsidi Urea
            ['id_barang' => 51, 'id_index_kategori' => 21,'harga' => 2300.00],      // Harga Pupuk Bersubsidi NPK Phonska
            ['id_barang' => 52, 'id_index_kategori' => 21,'harga' => 0.00],         // Harga Pupuk Bersubsidi Organik Petroganik
            ['id_barang' => 53, 'id_index_kategori' => 21,'harga' => 0.00],         // Harga Pupuk Bersubsidi SP-36
            ['id_barang' => 54, 'id_index_kategori' => 21,'harga' => 1700.00],      // Harga Pupuk Bersubsidi ZA
            ['id_barang' => 55, 'id_index_kategori' => 22,'harga' => 18500.00],     // Harga LPG Bersubsidi 3Kg
            ['id_barang' => 56, 'id_index_kategori' => 23,'harga' => 65000.00],     // Semen Tonasa 40Kg
            ['id_barang' => 57, 'id_index_kategori' => 23,'harga' => 60000.00],     // Semen bosowa 40Kg
            ['id_barang' => 58, 'id_index_kategori' => 24,'harga' => 35000.00],     // Besi beton
            ['id_barang' => 59, 'id_index_kategori' => 24,'harga' => 50000.00],         
            ['id_barang' => 60, 'id_index_kategori' => 24,'harga' => 77000.00],         
            ['id_barang' => 61, 'id_index_kategori' => 24,'harga' => 105000.00],     //Besi Beton 12mm/Btg
            ['id_barang' => 62, 'id_index_kategori' => 25,'harga' => 0.00],         //baja ringan
            ['id_barang' => 63, 'id_index_kategori' => 26,'harga' => 65000.00],     
            ['id_barang' => 64, 'id_index_kategori' => 27,'harga' => 0.00],     // kayu balok
            ['id_barang' => 65, 'id_index_kategori' => 27,'harga' => 0.00],      // kayu papan
            ['id_barang' => 66, 'id_index_kategori' => 28,'harga' => 20000.00],      
            ['id_barang' => 67, 'id_index_kategori' => 28,'harga' => 20000.00],      
            ['id_barang' => 68, 'id_index_kategori' => 28,'harga' => 18000.00],     // Paku 5cm/Kg
            ['id_barang' => 69, 'id_index_kategori' => 28,'harga' => 18000.00],         
            ['id_barang' => 70, 'id_index_kategori' => 28,'harga' => 18000.00],         // Paku 10cm/Kg
            ['id_barang' => 71, 'id_index_kategori' => 29,'harga' => 0.00],         // Benih Padi/Kg
            ['id_barang' => 72, 'id_index_kategori' => 29,'harga' =>0.00],          // Benih jagung/Kg
            ['id_barang' => 73, 'id_index_kategori' => 29,'harga' => 0.00],         // Benih kedelai/Kg
            ['id_barang' => 74, 'id_index_kategori' => 30,'harga' => 50000.00],         // udang
            ['id_barang' => 75, 'id_index_kategori' => 31,'harga' => 10000.00],     //jeruk
            ['id_barang' => 76, 'id_index_kategori' => 31,'harga' => 15000.00],     // pisang
            ['id_barang' => 77, 'id_index_kategori' => 32,'harga' => 10000.00],     // sawi Hijau
            ['id_barang' => 78, 'id_index_kategori' => 10,'harga' => 14000.00],     // tomat
            ['id_barang' => 79, 'id_index_kategori' => 22,'harga' => 25000.00],      // kentang
            ['id_barang' => 80, 'id_index_kategori' => 33,'harga' => 10000.00],      // kangkung
            ['id_barang' => 81, 'id_index_kategori' => 34,'harga' => 15000.00],      // kacang panjang
            ['id_barang' => 82, 'id_index_kategori' => 35,'harga' => 10000.00],     // timun
            ];

        foreach ($lokasiList as $lokasi) {
            foreach ($data as $item) {
                DB::table('index_harga')->insert([
                    'tanggal' => $tanggal,
                    'lokasi' => $lokasi,
                    'id_barang' => $item['id_barang'],
                    'id_index_kategori' => $item['id_index_kategori'],
                    'harga' => $item['harga'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
