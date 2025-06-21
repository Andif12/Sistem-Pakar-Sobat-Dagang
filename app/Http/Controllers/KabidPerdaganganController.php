<?php

namespace App\Http\Controllers;

use App\Models\IndexHarga;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Models\PermohonanSurat;
use App\Models\Barang;
use Carbon\Carbon;

class KabidPerdaganganController extends Controller
{
    private function getSuratPerdaganganData()
    {
        $jenis = [
            'surat_rekomendasi_perdagangan',
            'surat_keterangan_perdagangan',
            'dan_lainnya_perdagangan',
        ];

        return [
        'totalSuratPerdagangan' => DB::table('form_permohonan')
            ->whereIn('jenis_surat', $jenis)
            ->where('status', '!=', 'disimpan') // hanya hitung status selain disimpan
            ->count(),

        'totalSuratTerverifikasi' => DB::table('form_permohonan')
            ->whereIn('jenis_surat', $jenis)
            ->where('status', 'diterima')
            ->count(),

        'totalSuratDitolak' => DB::table('form_permohonan')
            ->whereIn('jenis_surat', $jenis)
            ->where('status', 'ditolak')
            ->count()

        ];
    }
    public function dashboardKabid(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        $rekapSurat = $this->getSuratPerdaganganData();
        $suratMasuk = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan'])
            ->where('status', '!=', 'disimpan')
            ->whereIn('status', ['menunggu', 'ditolak', 'diterima']) // hanya status ini yang ditampilkan
            ->orderBy('created_at', 'desc')
            ->get();

        $jenis = [
            'surat_rekomendasi_perdagangan',
            'surat_keterangan_perdagangan',
        ];

        $statusCounts = [
            'diterima' => PermohonanSurat::whereYear('created_at', $tahun)
                ->whereIn('jenis_surat', $jenis)
                ->where('status', 'diterima')
                ->count(),
            'ditolak' => PermohonanSurat::whereYear('created_at', $tahun)
                ->whereIn('jenis_surat', $jenis)
                ->where('status', 'ditolak')
                ->count(),
            'menunggu' => PermohonanSurat::whereYear('created_at', $tahun)
                ->whereIn('jenis_surat', $jenis)
                ->where('status', 'menunggu')
                ->count(),
        ];

        $dataBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulanan[] = PermohonanSurat::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $i)
                ->whereIn('jenis_surat', $jenis)
                ->where('status', '!=', 'disimpan')
                ->count();
        }


        if ($request->ajax()) {
            return response()->json([
                'statusCounts' => $statusCounts,
                'dataBulanan' => $dataBulanan
            ]);
        }
        

        return view('admin.kabid.perdagangan.perdagangan', [
            'totalSuratPerdagangan' => $rekapSurat['totalSuratPerdagangan'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'suratMasuk' => $suratMasuk,
            'statusCounts' => $statusCounts,
            'dataBulanan' => $dataBulanan
        ]);
    }
    public function setujui($id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);

        // Ubah status menjadi 'diterima'
        $permohonan->status = 'diterima';
        $permohonan->save();

        return redirect()->back()->with('success', 'Surat berhasil disetujui dan status diperbarui.');
    }

    public function analisisPasar(Request $request)
    {
        // Menentukan lokasi pasar yang dipilih, defaultnya adalah 'Pasar Sumpang'
        $lokasi = $request->lokasi ?? 'Pasar Sumpang';

        // Menentukan periode tanggal yang digunakan untuk filter data
        $startDate = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Inisialisasi variabel yang akan digunakan
        $tanggalList = collect();
        $barangs = Barang::orderBy('nama_barang')->get(); 
        $dataHarga = [];  
        $topHargaNaik = []; 
        $topHargaTurun = [];  
        $barChartData = [
            'labels' => [], 
            'today' => [],
            'yesterday' => []
        ];

        // Cek jika lokasi yang dipilih adalah 'Pasar Sumpang' atau 'Pasar Lakessi'
        if (in_array($lokasi, ['Pasar Sumpang', 'Pasar Lakessi'])) {
            // Mengambil daftar tanggal antara startDate dan endDate
            $current = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            while ($current <= $end) {
                $tanggalList->push($current->format('Y-m-d'));
                $current->addDay();
            }

            // Mengambil harga per barang per tanggal dari model IndexHarga
            foreach ($tanggalList as $tanggal) {
                foreach ($barangs as $barang) {
                    $harga = IndexHarga::whereDate('tanggal', $tanggal)
                        ->where('id_barang', $barang->id_barang)
                        ->where('lokasi', $lokasi)
                        ->value('harga');

                    // Menyimpan harga per tanggal per barang, jika tidak ada harga maka diset '-'
                    $dataHarga[$tanggal][$barang->id_barang] = $harga ?? '-';
                }
            }

            // Perbandingan harga hari ini dan kemarin
            $today = Carbon::parse($endDate);
            $yesterday = $today->copy()->subDay();

            // Menyiapkan label untuk bar chart
            $barChartData['labels'] = $barangs->pluck('nama_barang');

            // Menyiapkan data harga hari ini
            $barChartData['today'] = $barangs->map(function ($barang) use ($lokasi, $today) {
                return IndexHarga::where('id_barang', $barang->id_barang)
                    ->where('lokasi', $lokasi)
                    ->whereDate('tanggal', $today)  // Mengambil harga hari ini
                    ->value('harga') ?? 0;  // Jika tidak ada harga, set ke 0
            });

            // Menyiapkan data harga kemarin
            $barChartData['yesterday'] = $barangs->map(function ($barang) use ($lokasi, $yesterday) {
                return IndexHarga::where('id_barang', $barang->id_barang)
                    ->where('lokasi', $lokasi)
                    ->whereDate('tanggal', $yesterday)  // Mengambil harga kemarin
                    ->value('harga') ?? 0;  // Jika tidak ada harga, set ke 0
            });

            // Menghitung perubahan harga antara hari ini dan kemarin
            $perubahan = $barangs->map(function ($barang, $index) use ($barChartData) {
                $todayPrice = $barChartData['today'][$index] ?? 0;
                $yesterdayPrice = $barChartData['yesterday'][$index] ?? 0;
                $diff = $todayPrice - $yesterdayPrice;  // Selisih harga

                return [
                    'label' => $barang->nama_barang,
                    'price_change' => abs($diff),  // Harga perubahan absolut
                    'isNaik' => $diff > 0,  // Menentukan apakah harga naik
                ];
            });

            $topHargaNaik = $perubahan->filter(function ($item) {
                    return $item['isNaik'] && $item['price_change'] > 0;
                })
                ->sortByDesc('price_change')
                ->take(5)
                ->map(function ($item) {
                    $item['color'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // kasih warna random
                    return $item;
                })
                ->values()
                ->all();

            $topHargaTurun = $perubahan->filter(function ($item) {
                    return !$item['isNaik'] && $item['price_change'] > 0;
                })
                ->sortByDesc('price_change')
                ->take(5)
                ->map(function ($item) {
                    $item['color'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // kasih warna random
                    return $item;
                })
                ->values()
                ->all();

        }

        // Mengembalikan tampilan dengan data yang telah diproses
        return view('admin.kabid.perdagangan.analisisPasar', [
            'lokasiOptions' => ['Pasar Sumpang', 'Pasar Lakessi'],
            'selectedLokasi' => $lokasi, 
            'startDate' => $startDate, 
            'endDate' => $endDate,
            'tanggalList' => $tanggalList,
            'barangs' => $barangs,
            'dataHarga' => $dataHarga,
            'topHargaNaik' => $topHargaNaik,
            'topHargaTurun' => $topHargaTurun,
            'barChartData' => $barChartData,  
        ]);
    }
    public function distribusiPupuk(Request $request)
    {
        $kecamatan = $request->input('kecamatan');

        // Query data utama
        $query = DB::table('stok_opname')
            ->join('toko', 'stok_opname.id_toko', '=', 'toko.id_toko')
            ->join('distributor', 'stok_opname.id_distributor', '=', 'distributor.id_distributor');

        if ($kecamatan) {
            $query->where('toko.kecamatan', $kecamatan);
        }

        $data = $query->select(
                'toko.nama_toko',
                'toko.no_register',
                'stok_opname.nama_barang',
                DB::raw('SUM(stok_opname.penyaluran) as total_penyaluran')
            )
            ->groupBy('toko.id_toko', 'stok_opname.nama_barang', 'toko.nama_toko', 'toko.no_register')
            ->get()
            ->groupBy('nama_toko');

        $jumlahToko = $data->count();
        
        $tokoPenyaluranTerbanyak = DB::table('stok_opname')
        ->join('toko', 'stok_opname.id_toko', '=', 'toko.id_toko')
        ->select('toko.nama_toko', DB::raw('SUM(stok_opname.penyaluran) as total_penyaluran'))
        ->groupBy('stok_opname.id_toko', 'toko.nama_toko')
        ->orderByDesc('total_penyaluran')
        ->limit(3)
        ->get();

        // Data pie chart (total pupuk per jenis)
        $dataPupuk = DB::table('stok_opname')
            ->join('toko', 'stok_opname.id_toko', '=', 'toko.id_toko')
            ->when($kecamatan, function ($query) use ($kecamatan) {
                $query->where('toko.kecamatan', $kecamatan);
            })
            ->select('stok_opname.nama_barang', DB::raw('SUM(stok_opname.penyaluran) as total'))
            ->groupBy('stok_opname.nama_barang')
            ->pluck('total', 'stok_opname.nama_barang');

        $totalDistribusi = $dataPupuk->sum();

        // Data line chart (perkembangan per tahun)
        $dataPerTahun = DB::table('stok_opname')
            ->join('toko', 'stok_opname.id_toko', '=', 'toko.id_toko')
            ->when($kecamatan, function ($query) use ($kecamatan) {
                $query->where('toko.kecamatan', $kecamatan);
            })
            ->select(DB::raw('YEAR(stok_opname.created_at) as tahun'), DB::raw('SUM(penyaluran) as total'))
            ->groupBy(DB::raw('YEAR(stok_opname.created_at)'))
            ->orderBy('tahun')
            ->get();

        $lineLabels = $dataPerTahun->pluck('tahun')->toArray();
        $lineValues = $dataPerTahun->pluck('total')->toArray();

        $lineDatasets = [
            [
                'label' => 'Total Penyaluran Pupuk per Tahun',
                'data' => $lineValues,
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'fill' => true,
                'tension' => 0.4,
            ]
        ];

        return view('admin.kabid.perdagangan.distribusiPupuk', [
            'data' => $data,
            'jumlahToko' => $jumlahToko,
            'dataPupuk' => $dataPupuk,
            'totalDistribusi' => $totalDistribusi,
            'tokoPenyaluranTerbanyak' => $tokoPenyaluranTerbanyak,
            'selectedKecamatan' => $kecamatan,
            'lineLabels' => $lineLabels,
            'lineDatasets' => $lineDatasets,
        ]);
    }
}
