<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataIkm;
use Illuminate\Support\Str;

class DataIKMSeeder extends Seeder
{
    public function run(): void
    {
        $kecamatanList = ['Bacukiki', 'Ujung', 'Soreang', 'Bacukiki Barat'];
        $jenisIndustriList = [
            'Sandang',
            'Pangan',
            'Kimia & Bahan Bangunan',
            'Logam & Elektronika',
            'Kerajinan'
        ];
        $komoditiList = ['Komoditi 1', 'Komoditi 2', 'Komoditi 3'];
        $genderList = ['Laki-laki', 'Perempuan'];

        for ($i = 1; $i <= 40; $i++) {
            // Buat data lewat model supaya event saving aktif
            $ikm = DataIkm::create([
                'nama_ikm' => 'IKM-' . Str::random(5),
                'luas' => rand(50, 300) . ' m2',
                'nama_pemilik' => 'Pemilik-' . $i,
                'jenis_kelamin' => $genderList[array_rand($genderList)],
                'kecamatan' => $kecamatanList[array_rand($kecamatanList)],
                'kelurahan' => 'Kelurahan ' . chr(65 + rand(0, 3)), // e.g. Kelurahan A, B, ...
                'komoditi' => $komoditiList[array_rand($komoditiList)],
                'jenis_industri' => $jenisIndustriList[array_rand($jenisIndustriList)],
                'alamat' => 'Jl. Contoh No.' . $i,
                'nib' => 'NIB' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'no_telp' => '08' . rand(1000000000, 9999999999),
                'tenaga_kerja' => rand(1, 100),
            ]);

            // Update level jika perlu, biasanya sudah otomatis jika ada event saving
            $ikm->level = $ikm->hitungLevel();
            $ikm->save();
        }
    }
}
