<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('index_kategori')->insert([
            ['nama_kategori' => 'Beras',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Cabe',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Ayam',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Bawang',           'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Telur',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Daging',           'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Ikan',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Tahu',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Tempe',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Tomat',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Gula',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Minyak Goreng',    'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Tepung',           'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Susu',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Garam',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Kedelai',          'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Mie Instan',       'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Kacang',           'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Ubi Ketela',       'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Jagung Pipilan',   'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Pupuk Bersubsidi', 'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'LPG Bersubsidi',   'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Semen',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Besi Beton',       'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Baja Ringan',      'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Triplek',          'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Kayu',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Paku',             'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Benih',            'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Udang Basah',      'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Buah-buahan',      'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Sayuran',          'created_at' => $now, 'updated_at' => $now],    
            ['nama_kategori' => 'Kentang',      'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Kangkung',      'created_at' => $now, 'updated_at' => $now],
            ['nama_kategori' => 'Kacang Panjang',          'created_at' => $now, 'updated_at' => $now],

        ]);
    }
}
