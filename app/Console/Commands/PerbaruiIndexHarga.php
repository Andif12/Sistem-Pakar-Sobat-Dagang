<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Barang;
use App\Models\IndexHarga;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; 
class PerbaruiIndexHarga extends Command
{
    protected $signature = 'index-harga:perbarui';
    protected $description = 'Menyalin data harga terakhir jika hari ini belum diinput admin';

    public function handle()
    {
        $today = Carbon::today();
        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $hargaTerakhirPerLokasi = IndexHarga::where('id_barang', $barang->id_barang)
                ->orderByDesc('tanggal')
                ->get()
                ->groupBy('lokasi');

            foreach ($hargaTerakhirPerLokasi as $lokasi => $records) {
                $sudahAda = IndexHarga::where('id_barang', $barang->id_barang)
                    ->where('lokasi', $lokasi)
                    ->whereDate('tanggal', $today)
                    ->exists();

                if (!$sudahAda) {
                    $terakhir = $records->first();

                    IndexHarga::create([
                        'id_barang' => $barang->id_barang,
                        'id_index_kategori' => $barang->id_index_kategori,
                        'harga' => $terakhir->harga,
                        'tanggal' => $today,
                        'lokasi' => $lokasi,
                    ]);
                }
            }
        }

        Log::info('Auto-perbarui index_harga dijalankan pada: ' . now()->toDateTimeString());
        $this->info('Data index_harga berhasil diperbarui untuk tanggal ' . $today->toDateString());
    }
}
