<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\suratMetrologi;
use App\Models\Uttp;
use App\Models\DataAlatUkur;
use App\Models\suratBalasan;

class DashboardMetrologiController extends Controller
{
    public function index()
    {
        $dataSurat = $this->getJumlahSurat();
        $dataSuratAdmin = $this->getJumlahSuratAdmin();
        $chartData = $this->chartData();
        $chartBar = $this->chartBarJenisAlat();
        $donutChart = $this->getDonutChartData();
        
        $data = array_merge(
            $dataSurat,
            ['dataSuratAdmin' => $dataSuratAdmin],
            $chartData,
            $chartBar,
            $donutChart
        );

        return view('admin.bidangMetrologi.dashboard', $data);
    }
    
    public function showKabid() {
        $dataSurat = $this->getJumlahSurat();
        
        // Get all types and their counts
        $jumlahPerJenis = Uttp::select('jenis_alat', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_alat')
            ->orderBy('total', 'desc')
            ->get();
            
        // Take top 5 and group the rest
        $topFive = $jumlahPerJenis->take(5);
        $others = $jumlahPerJenis->skip(5);
        
        // Calculate total for "Lainnya"
        $othersTotal = $others->sum('total');
        
        // Create final collection with "Lainnya" if needed
        $finalJumlahPerJenis = $topFive;
        if ($othersTotal > 0) {
            $finalJumlahPerJenis->push((object)[
                'jenis_alat' => 'Lainnya',
                'total' => $othersTotal
            ]);
        }
        
        // Get count of valid and expired measuring instruments
        $jumlahValid = DB::table('uttp')
            ->join('data_alat_ukur', 'uttp.id_uttp', '=', 'data_alat_ukur.id_uttp')
            ->where('data_alat_ukur.tanggal_exp', '>=', now())
            ->count();
            
        $jumlahKadaluarsa = DB::table('uttp')
            ->join('data_alat_ukur', 'uttp.id_uttp', '=', 'data_alat_ukur.id_uttp')
            ->where('data_alat_ukur.tanggal_exp', '<', now())
            ->count();
            
        $uttps = DataAlatUkur::with('uttp')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();
        $donutData = $this->getDonutChartData();
        $calibrationData = $this->getCalibrationComparisonData();
        
        return view('admin.kabid.metrologi.dashboard', array_merge(
            $dataSurat, 
            ['jumlahPerJenis' => $finalJumlahPerJenis],
            ['jumlahValid' => $jumlahValid],
            ['jumlahKadaluarsa' => $jumlahKadaluarsa],
            ['uttps' => $uttps],
            $donutData,
            $calibrationData
        ));
    }

    public function showKadisMetro()
    {
        $dataSurat = $this->jumlahSuratKadis();
        
        $jumlahPerJenis = Uttp::select('jenis_alat', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_alat')
            ->orderBy('total', 'desc')
            ->get();
            
        $topFive = $jumlahPerJenis->take(5);
        $others = $jumlahPerJenis->skip(5);
        
        $othersTotal = $others->sum('total');
        
        $finalJumlahPerJenis = $topFive;
        if ($othersTotal > 0) {
            $finalJumlahPerJenis->push((object)[
                'jenis_alat' => 'Lainnya',
                'total' => $othersTotal
            ]);
        }
        $jumlahValid = DB::table('uttp')
            ->join('data_alat_ukur', 'uttp.id_uttp', '=', 'data_alat_ukur.id_uttp')
            ->where('data_alat_ukur.tanggal_exp', '>=', now())
            ->count();
            
        $jumlahKadaluarsa = DB::table('uttp')
            ->join('data_alat_ukur', 'uttp.id_uttp', '=', 'data_alat_ukur.id_uttp')
            ->where('data_alat_ukur.tanggal_exp', '<', now())
            ->count();
            
        $uttps = DataAlatUkur::with('uttp')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();
        $donutData = $this->getDonutChartData();
        $calibrationData = $this->getCalibrationComparisonData();
        
        return view('admin.kepalaDinas.dashboardMetrologi', array_merge(
            $dataSurat, 
            ['jumlahPerJenis' => $finalJumlahPerJenis],
            ['jumlahValid' => $jumlahValid],
            ['jumlahKadaluarsa' => $jumlahKadaluarsa],
            ['uttps' => $uttps],
            $donutData,
            $calibrationData
        ));
    }

    public function chartBarJenisAlat()
    {
        $tahunSekarang = Carbon::now()->year;
        $tahunLalu = $tahunSekarang - 1;
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Fungsi bantu untuk ambil data per tahun dan prefix jenis_alat
        $ambilData = function ($tahun, $prefix) {
            $bulanan = Uttp::selectRaw('MONTH(tanggal_selesai) as bulan, COUNT(*) as total')
                ->whereYear('tanggal_selesai', $tahun)
                ->where('jenis_alat', 'like', $prefix . '%')
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray();

            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[] = $bulanan[$i] ?? 0;
            }

            return $result;
        };

        // Ambil data untuk satu jenis alat (misalnya UP)
        $dataTahunLaluUP = $ambilData($tahunLalu, 'UP-');
        $dataTahunIniUP = $ambilData($tahunSekarang, 'UP-');
        $dataTahunLaluVOL = $ambilData($tahunLalu, 'VOL-');
        $dataTahunIniVOL = $ambilData($tahunSekarang, 'VOL-');
        $dataTahunLaluMAS = $ambilData($tahunLalu, 'MAS-');
        $dataTahunIniMAS = $ambilData($tahunSekarang, 'MAS-');

        return  [
            'labels' => json_encode($labels),
            'dataTahunLaluUP' => json_encode($dataTahunLaluUP),
            'dataTahunIniUP' => json_encode($dataTahunIniUP),
            'dataTahunLaluVOL' => json_encode($dataTahunLaluVOL),
            'dataTahunIniVOL' => json_encode($dataTahunIniVOL),
            'dataTahunLaluMAS' => json_encode($dataTahunLaluMAS),
            'dataTahunIniMAS' => json_encode($dataTahunIniMAS),
            'tahunLalu' => $tahunLalu,
            'tahunSekarang' => $tahunSekarang,
        ];
    }

    public function chartData()
    {
        // Ambil data bulanan untuk jenis 'tera'
        $tera = suratMetrologi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('jenis_surat', 'tera')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Ambil data bulanan untuk jenis 'tera_ulang'
        $teraUlang = suratMetrologi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('jenis_surat', 'tera_ulang')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Konversi ke array dengan default 0 untuk tiap bulan (1–12)
        $dataTera = [];
        $dataTeraUlang = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataTera[] = $tera[$i] ?? 0;
            $dataTeraUlang[] = $teraUlang[$i] ?? 0;
        }

        return [
            'dataTera' => json_encode($dataTera),
            'dataTeraUlang' => json_encode($dataTeraUlang),
        ];
    }

    public function getDonutChartData()
    {
        $jenisList = ['BUS', 'AT', 'ATB'];
        $data = [];

        foreach ($jenisList as $jenis) {
            $jumlah = Uttp::where('alat_penguji', $jenis)->count();
            $data[$jenis] = $jumlah;
        }

        return [
            'donutLabels' => json_encode(array_keys($data)),
            'donutData' => json_encode(array_values($data))
        ];
    }

    private function jumlahSuratKadis()
    {
        // Total surat yang sudah diproses (Disetujui + Ditolak + Menunggu)
        $totalSuratMasuk = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->count();
        
        // Surat yang sudah diproses oleh kadis (diterima/ditolak)
        $totalSuratDiterima = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Disetujui')
            ->count();
            
        $totalSuratDitolak = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Ditolak')
            ->count();
            
        $totalSuratMenunggu = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Menunggu')
            ->count();

        // Surat yang menunggu persetujuan kadis
        $totalSuratMenungguKabid = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Menunggu')
            ->count();
            
        $suratTerbaru = suratMetrologi::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik bulanan
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $suratTerkirim = suratBalasan::where('status_surat_keluar', 'Disetujui')->count();

        $totalSuratMasukBulanIni = DB::table('surat_keluar_metrologi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->where('status_kepalaBidang', 'Disetujui')
            ->count();

        return [
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratMasukBulanIni' => $totalSuratMasukBulanIni,
            'totalSuratDiterima' => $totalSuratDiterima,
            'totalSuratDitolak' => $totalSuratDitolak,
            'totalSuratMenunggu' => $totalSuratMenunggu,
            'totalSuratMenungguKabid' => $totalSuratMenungguKabid,
            'suratTerbaru' => $suratTerbaru,
            'totalSuratTerkirim' => $suratTerkirim
        ];
    }


    public function getJumlahSurat()
    {
        // Total surat yang sudah diproses (Disetujui + Ditolak + Menunggu)
        $totalSuratMasuk = DB::table('surat_keluar_metrologi')
            ->whereIn('status_kepalaBidang', ['Disetujui', 'Ditolak', 'Menunggu'])
            ->count();
        
        // Surat yang sudah diproses oleh kabid (diterima/ditolak)
        $totalSuratDiterima = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Disetujui')
            ->count();
            
        $totalSuratDitolak = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Ditolak')
            ->count();
            
        $totalSuratMenunggu = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Menunggu')
            ->count();

        // Surat yang menunggu persetujuan kabid
        $totalSuratMenungguKabid = DB::table('surat_keluar_metrologi')
            ->where('status_kepalaBidang', 'Menunggu')
            ->count();

        // Surat terbaru untuk ditampilkan di dashboard
        $suratTerbaru = suratMetrologi::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik bulanan
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $suratTerkirim = suratBalasan::where('status_surat_keluar', 'Disetujui')->count();

        $totalSuratMasukBulanIni = DB::table('surat_metrologi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        return [
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratMasukBulanIni' => $totalSuratMasukBulanIni,
            'totalSuratDiterima' => $totalSuratDiterima,
            'totalSuratDitolak' => $totalSuratDitolak,
            'totalSuratMenunggu' => $totalSuratMenunggu,
            'totalSuratMenungguKabid' => $totalSuratMenungguKabid,
            'suratTerbaru' => $suratTerbaru,
            'totalSuratTerkirim' => $suratTerkirim
        ];
    }

    private function getCalibrationComparisonData()
    {
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        // Get data for current year
        $currentYearData = DB::table('surat_metrologi')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status_surat_masuk', 'Disetujui')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        // Get data for last year
        $lastYearData = DB::table('surat_metrologi')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $lastYear)
            ->where('status_surat_masuk', 'Disetujui')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        // Fill in missing months with 0
        $currentYearComplete = [];
        $lastYearComplete = [];
        for ($i = 1; $i <= 12; $i++) {
            $currentYearComplete[] = $currentYearData[$i] ?? 0;
            $lastYearComplete[] = $lastYearData[$i] ?? 0;
        }
        
        return [
            'currentYearData' => json_encode($currentYearComplete),
            'lastYearData' => json_encode($lastYearComplete),
            'currentYear' => $currentYear,
            'lastYear' => $lastYear
        ];
    }

    public function showAlatukur()
    {
        return view('admin.bidangMetrologi.directory_alat_ukur_sah');
    }

    public function showAdministrasi(Request $request)
    {
        $query = SuratMetrologi::with('user', 'suratBalasan');

        // Handle status filter
        if ($request->filled('status')) {
            $query->where('status_admin', $request->status);
        }

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id_surat', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat_alat', 'like', "%{$searchTerm}%")
                  ->orWhere('jenis_surat', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('nama', 'like', "%{$searchTerm}%")
                        ->orWhere('id_user', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $suratList = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        $dataJumlahSurat = $this->getJumlahSurat();
        $dataSuratAdmin = $this->getJumlahSuratAdmin();

        return view('admin.bidangMetrologi.directory_surat', array_merge(
            $dataJumlahSurat,
            ['suratList' => $suratList],
            ['dataSuratAdmin' => $dataSuratAdmin]
        ));
    }

    public function showAdministrasiKabid(Request $request)
    {
        $query = SuratMetrologi::with(['user', 'suratBalasan'])
            ->whereHas('suratBalasan', function($query) {
                $query->whereIn('status_kepalaBidang', ['Disetujui', 'Ditolak', 'Menunggu']);
            });

        // Handle status filter
        if ($request->filled('status')) {
            $query->whereHas('suratBalasan', function($query) use ($request) {
                $query->where('status_kepalaBidang', $request->status);
            });
        }

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id_surat', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat_alat', 'like', "%{$searchTerm}%")
                  ->orWhere('jenis_surat', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($q) use ($searchTerm) {
                      $q->where('nama', 'like', "%{$searchTerm}%")
                        ->orWhere('id_user', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $suratList = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();
            
        $dataJumlahSurat = $this->getJumlahSurat();

        return view('admin.kabid.metrologi.directory_surat', array_merge(
            $dataJumlahSurat,
            ['suratList' => $suratList]
        ));
    }

    public function showKadis()
    {
        $suratList = suratBalasan::with('suratMetrologi.user')
            ->where('status_kepalaBidang', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSurat = suratBalasan::count();
        $totalSuratDisetujui = suratBalasan::where('status_kadis', 'Disetujui')->count();
        $totalSuratDitolak = suratBalasan::where('status_kadis', 'Ditolak')->count();
        $totalSuratMenunggu = suratBalasan::where('status_kadis', 'Menunggu')->count();

        return view('admin.kepalaDinas.dashboard', compact(
            'suratList',
            'totalSurat',
            'totalSuratDisetujui',
            'totalSuratDitolak',
            'totalSuratMenunggu',
        ));
    }
    public function showUttp(Request $request)
    {
        $query = DataAlatUkur::with('uttp');

        // Handle status filter
        if ($request->has('status')) {
            if ($request->status === 'Valid') {
                $query->whereDate('tanggal_exp', '>=', now());
            } elseif ($request->status === 'Kadaluarsa') {
                $query->whereDate('tanggal_exp', '<', now());
            }
        }

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('uttp', function($q) use ($searchTerm) {
                $q->where('no_registrasi', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_usaha', 'like', "%{$searchTerm}%")
                  ->orWhere('jenis_alat', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_alat', 'like', "%{$searchTerm}%")
                  ->orWhere('merk_type', 'like', "%{$searchTerm}%")
                  ->orWhere('nomor_seri', 'like', "%{$searchTerm}%");
            });
        }

        $alatUkur = $query->orderBy('created_at', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        return view('admin.kabid.metrologi.directory_alat_ukur', compact('alatUkur'));
    }
    
    public function showPersuratanMetrologiKadis(Request $request)
    {
        $query = suratBalasan::with('suratMetrologi.user')
            ->where('status_kepalaBidang', 'Disetujui');

        // Handle status filter
        if ($request->filled('status')) {
            $query->where('status_kadis', $request->status);
        }

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('surat_keluar_metrologi.id_surat_balasan', 'like', "%{$searchTerm}%")
                  ->orWhereHas('suratMetrologi', function($q) use ($searchTerm) {
                      $q->where('alamat_alat', 'like', "%{$searchTerm}%")
                        ->orWhere('jenis_surat', 'like', "%{$searchTerm}%")
                        ->orWhereHas('user', function($q) use ($searchTerm) {
                            $q->where('nama', 'like', "%{$searchTerm}%")
                              ->orWhere('id_user', 'like', "%{$searchTerm}%");
                        });
                  });
            });
        }

        $suratList = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        // Get statistics for letters visible to kepala dinas
        $totalSurat = suratBalasan::where('status_kepalaBidang', 'Disetujui')->count();
        $totalSuratDisetujui = suratBalasan::where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Disetujui')
            ->count();
        $totalSuratDitolak = suratBalasan::where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Ditolak')
            ->count();
        $totalSuratMenunggu = suratBalasan::where('status_kepalaBidang', 'Disetujui')
            ->where('status_kadis', 'Menunggu')
            ->count();

        return view('admin.kepalaDinas.metrologi', compact(
            'suratList',
            'totalSurat',
            'totalSuratDisetujui',
            'totalSuratDitolak',
            'totalSuratMenunggu'
        ));
    }

    public function getJumlahSuratAdmin()
    {
        // Total surat yang sudah diproses (Diterima + Ditolak + Menunggu)
        $totalSuratMasuk = DB::table('surat_metrologi')
            ->whereIn('status_admin', ['Diterima', 'Ditolak', 'Menunggu', 'Diproses', 'Menunggu Persetujuan', 'Selesai', 'Butuh Revisi'])
            ->count();
        
        // Surat yang sudah diproses (diterima/ditolak)
        $totalSuratDiterima = DB::table('surat_metrologi')
            ->where('status_admin', 'Diterima')
            ->count();
            
        $totalSuratDitolak = DB::table('surat_metrologi')
            ->where('status_admin', 'Ditolak')
            ->count();
            
        $totalSuratMenunggu = DB::table('surat_metrologi')
            ->where('status_admin', 'Menunggu')
            ->count();

        // Data untuk pie chart (menggunakan status_surat_masuk)
        $pieChartData = [
            'menunggu' => DB::table('surat_metrologi')->where('status_surat_masuk', 'Menunggu')->count(),
            'disetujui' => DB::table('surat_metrologi')->where('status_surat_masuk', 'Disetujui')->count(),
            'ditolak' => DB::table('surat_metrologi')->where('status_surat_masuk', 'Ditolak')->count()
        ];

        // Data untuk box status surat masuk
        $totalSuratMasukDisetujui = DB::table('surat_metrologi')
            ->where('status_surat_masuk', 'Disetujui')
            ->count();

        // Surat terbaru untuk ditampilkan di dashboard
        $suratTerbaru = suratMetrologi::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Statistik bulanan
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalSuratMasukBulanIni = DB::table('surat_metrologi')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        return [
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratMasukBulanIni' => $totalSuratMasukBulanIni,
            'totalSuratDiterima' => $totalSuratDiterima,
            'totalSuratDitolak' => $totalSuratDitolak,
            'totalSuratMenunggu' => $totalSuratMenunggu,
            'suratTerbaru' => $suratTerbaru,
            'pieChartData' => $pieChartData,
            'totalSuratMasukDisetujui' => $totalSuratMasukDisetujui
        ];
    }
}
