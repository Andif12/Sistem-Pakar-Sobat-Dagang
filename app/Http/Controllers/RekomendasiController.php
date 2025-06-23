<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Http;
// use App\Models\StokOpname;
// use App\Models\RencanaKebutuhanDistributor;
// use App\Models\Toko;
// use App\Models\Barang;
// use Carbon\Carbon;

// class RekomendasiController extends Controller
// {
//     public function formView()
//     {
//         $barangs = Barang::all();
//         $results = [];

//         // Ambil tanggal terbaru di stok_opname
//         $tanggalTerbaru = StokOpname::latest('tanggal')->first()->tanggal ?? now();

//         // Ambil semua toko yang ada dalam stok_opname
//         $tokoIds = StokOpname::pluck('id_toko')->unique();

//         foreach ($tokoIds as $idToko) {
//             $toko = Toko::find($idToko);

//             foreach ($barangs as $barang) {
//                 $stok = StokOpname::where('id_toko', $idToko)
//                     ->whereDate('tanggal', $tanggalTerbaru)
//                     ->where('nama_barang', $barang->nama)
//                     ->first();

//                 if (!$stok) continue;

//                 $tahun = \Carbon\Carbon::parse($tanggalTerbaru)->year;

//                 $rencana = RencanaKebutuhanDistributor::where('id_barang_pelaporan', $barang->nama)
//                     ->where('tahun', $tahun)
//                     ->first();

//                 if (!$rencana) continue;

//                 $total_penyaluran = StokOpname::where('id_toko', $idToko)
//                     ->whereYear('tanggal', $tahun)
//                     ->where('nama_barang', $barang->nama)
//                     ->sum('penyaluran');

//                 $realisasi = ($total_penyaluran / max($rencana->jumlah, 1)) * 100;

//                 $response = Http::post('http://127.0.0.1:5000/rekomendasi', [
//                     'stok_awal' => $stok->stok_awal,
//                     'stok_akhir' => $stok->stok_akhir,
//                     'realisasi' => $realisasi,
//                 ]);

//                 $results[] = [
//                     'toko' => $toko->nama,
//                     'barang' => $barang->nama,
//                     'rekomendasi' => $response['rekomendasi'],
//                     'klasifikasi' => $response['klasifikasi'],
//                 ];
//             }
//         }

//         return view('user.bidangPerdagangan.rekomendasi', compact('results'));
//     }

//     public function hitungRekomendasi(Request $request)
//     {
//         $request->validate([
//             'id_toko' => 'required',
//             'tanggal' => 'required|date',
//         ]);

//         $barangs = Barang::all();
//         $resultArray = [];

//         foreach ($barangs as $barang) {
//             $stok = StokOpname::where('id_toko', $request->id_toko)
//                 ->whereDate('tanggal', $request->tanggal)
//                 ->where('nama_barang', $barang->nama)
//                 ->first();

//             if (!$stok) continue;

//             $tahun = Carbon::parse($request->tanggal)->year;
//             $rencana = RencanaKebutuhanDistributor::where('id_barang_pelaporan', $barang->nama)
//                 ->where('tahun', $tahun)
//                 ->first();

//             if (!$rencana) continue;

//             $total_penyaluran = StokOpname::where('id_toko', $request->id_toko)
//                 ->whereYear('tanggal', $tahun)
//                 ->where('nama_barang', $barang->nama)
//                 ->sum('penyaluran');

//             $realisasi = ($total_penyaluran / max($rencana->jumlah, 1)) * 100;

//             $response = Http::post('http://127.0.0.1:5000/rekomendasi', [
//                 'stok_awal' => $stok->stok_awal,
//                 'stok_akhir' => $stok->stok_akhir,
//                 'realisasi' => $realisasi,
//             ]);

//             $resultArray[] = [
//                 'barang' => $barang->nama,
//                 'rekomendasi' => $response['rekomendasi'],
//                 'klasifikasi' => $response['klasifikasi'],
//             ];
//         }

//         $tokos = Toko::whereIn('id', DB::table('stok_opname')
//             ->where('id_distributor', 2)
//             ->pluck('id_toko')
//             ->unique())->get();

//         return view('user.bidangPerdagangan.rekomendasi', [
//             'results' => $resultArray,
//             'tokos' => $tokos,
//             'barangs' => $barangs,
//             'selected' => $request->only(['id_toko', 'tanggal']),
//         ]);
//     }
// }
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\StokOpname;
use App\Models\RencanaKebutuhanDistributor;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RekomendasiController extends Controller
{
    public function tampilOtomatis()
    {
        $results = [];

        // Ambil tanggal distribusi terbaru
        $tanggalTerbaru = optional(StokOpname::latest('tanggal')->first())->tanggal;

        if (!$tanggalTerbaru) {
            return view('user.bidangPerdagangan.rekomendasi', [
                'results' => [],
                'error' => 'Belum ada data distribusi pupuk untuk ditampilkan.'
            ]);
        }

        $tokoIds = StokOpname::pluck('id_toko')->unique();

        foreach ($tokoIds as $idToko) {
            // Gunakan where karena primary key adalah id_toko, bukan id
            $toko = Toko::where('id_toko', $idToko)->first();

            if (!$toko) {
                continue; // skip jika toko tidak ditemukan
            }

            // Ambil semua barang yang dikirim ke toko ini pada tanggal tersebut
            $barangList = StokOpname::where('id_toko', $idToko)
                ->whereDate('tanggal', $tanggalTerbaru)
                ->pluck('nama_barang');

            foreach ($barangList as $namaBarang) {
                $stok = StokOpname::where('id_toko', $idToko)
                    ->whereDate('tanggal', $tanggalTerbaru)
                    ->where('nama_barang', $namaBarang)
                    ->first();

                if (!$stok) continue;

                $tahun = Carbon::parse($tanggalTerbaru)->year;

                // Ambil rencana kebutuhan yang tersedia untuk tahun tersebut
                $rencana = RencanaKebutuhanDistributor::whereYear('tahun', $tahun)
                    ->orderByDesc('jumlah')
                    ->first();

                if (!$rencana || $rencana->jumlah == 0) continue;

                // Hitung total penyaluran untuk toko + barang sepanjang tahun
                $total_penyaluran = StokOpname::where('id_toko', $idToko)
                    ->whereYear('tanggal', $tahun)
                    ->where('nama_barang', $namaBarang)
                    ->sum('penyaluran');

                $realisasi = ($total_penyaluran / max($rencana->jumlah, 1)) * 100;

                // Kirim data ke Flask untuk diproses
                $response = Http::post('http://127.0.0.1:8000/rekomendasi', [
                    'stok_awal' => $stok->stok_awal,
                    'stok_akhir' => $stok->stok_akhir,
                    'realisasi' => $realisasi,
                ]);

                $data = $response->json();

                $results[] = [
                    'toko' => $toko->nama_toko, // pakai nama_toko karena itu nama kolom kamu
                    'barang' => $namaBarang,
                    'rekomendasi' => $data['rekomendasi'],
                    'klasifikasi' => $data['klasifikasi'],
                ];
            }
        }

        return view('user.bidangPerdagangan.rekomendasi', compact('results', 'tanggalTerbaru'));
    }
}   
