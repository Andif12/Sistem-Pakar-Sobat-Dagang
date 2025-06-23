<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\StokOpname;
use App\Models\RencanaKebutuhanDistributor;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Distributor;
use Illuminate\Support\Facades\Auth;

class RekomendasiController extends Controller
{
    public function tampilOtomatis()
    {
        if (!Auth::guard('user')->check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::guard('user')->user();
        $userId = $user->id_user;

        $distributor = Distributor::where('id_user', $userId)->first();

        if (!$distributor) {
            return view('user.bidangPerdagangan.rekomendasi', [
                'results' => [],
                'error' => 'Distributor tidak ditemukan untuk akun ini.'
            ]);
        }

        $results = [];
        $tanggalTerbaru = optional(StokOpname::latest('tanggal')->first())->tanggal;

        if (!$tanggalTerbaru) {
            return view('user.bidangPerdagangan.rekomendasi', [
                'results' => [],
                'error' => 'Belum ada data distribusi pupuk untuk ditampilkan.'
            ]);
        }

        $tokoIds = StokOpname::pluck('id_toko')->unique();

        foreach ($tokoIds as $idToko) {
            $toko = Toko::where('id_toko', $idToko)->first();

            if (!$toko) {
                continue; 
            }

            $barangList = StokOpname::where('id_toko', $idToko)
                ->pluck('nama_barang')
                ->unique();


            foreach ($barangList as $namaBarang) {
                $stok = StokOpname::where('id_toko', $idToko)
                ->where('nama_barang', $namaBarang)
                ->orderByDesc('tanggal')
                ->first();


                if (!$stok) continue;

                $tahun = Carbon::parse($tanggalTerbaru)->year;

                $rencana = RencanaKebutuhanDistributor::whereYear('tahun', $tahun)
                    ->orderByDesc('jumlah')
                    ->first();

                if (!$rencana || $rencana->jumlah == 0) continue;

                $total_penyaluran = StokOpname::where('id_toko', $idToko)
                    ->whereYear('tanggal', $tahun)
                    ->where('nama_barang', $namaBarang)
                    ->sum('penyaluran');

                $realisasi = ($total_penyaluran / max($rencana->jumlah, 1)) * 100;

                // Kirim data ke Flask untuk diproses
                $response = Http::post('http://127.0.0.1:5000/rekomendasi', [
                    'stok_awal' => $stok->stok_awal,
                    'stok_akhir' => $stok->stok_akhir,
                    'realisasi' => $realisasi,
                ]);

                $data = $response->successful() ? $response->json() : ['rekomendasi' => 0, 'klasifikasi' => 'Tidak Terklasifikasi'];

                $results[] = [
                    'toko' => $toko->nama_toko,
                    'barang' => $namaBarang,
                    'rekomendasi' => $data['rekomendasi'],
                    'klasifikasi' => $data['klasifikasi'],
                ];
            }
        }

        return view('user.bidangPerdagangan.rekomendasi', compact('results', 'tanggalTerbaru'));
    }
}   
