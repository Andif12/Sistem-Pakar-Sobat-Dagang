<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class ImportWilayah extends Command
{
    protected $signature = 'import:wilayah';
    protected $description = 'Import data kabupaten, kecamatan, dan kelurahan dari API ke database';

    public function handle()
    {
        $kabupatenList = [
            '7372' => 'Kota Parepare',
            '7315' => 'Kabupaten Pinrang',
            '7316' => 'Kabupaten Enrekang',
            '7314' => 'Kabupaten Sidenreng Rappang',
            '7311' => 'Kabupaten Barru',
        ];
    
        foreach ($kabupatenList as $id => $nama) {
            $this->info("Kabupaten: [$id] $nama");
    
            $response = Http::get("https://ibnux.github.io/data-indonesia/kecamatan/{$id}.json");
            foreach ($response->json() as $kec) {
                $this->info("  - Kecamatan: [{$kec['id']}] {$kec['nama']}");
    
                $kelResponse = Http::get("https://ibnux.github.io/data-indonesia/kelurahan/{$kec['id']}.json");
                foreach ($kelResponse->json() as $kel) {
                    $this->info("      - Kelurahan: [{$kel['id']}] {$kel['nama']}");
                }
            }
        }
    
        $this->info("Output selesai tanpa menyimpan ke database.");
    }
    
    
}
