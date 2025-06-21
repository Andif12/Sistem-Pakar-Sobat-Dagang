<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;
use App\Models\PermohonanSurat;
use App\Models\DocumentUser;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use App\Models\DataIkm;
use App\Models\SertifikasiHalal;

class KabidIndustriController extends Controller
{

    private function getSuratIndustriData()
    {
        $jenis = [
            'surat_rekomendasi_industri',
            'surat_keterangan_industri',
            'dan_lainnya_industri',
        ];

        return [
            'totalSuratIndustri' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)
            ->where('status', '!=', 'disimpan') // hanya hitung status selain disimpan
            ->count(),
            'totalSuratTerverifikasi' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'diterima')->count(),
            'totalSuratDitolak' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'ditolak')->count(),
            'totalSuratDraft' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'draft')->count(),
        ];
    }
    
    public function dashboardKabid(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
       
        $rekapSurat = $this->getSuratIndustriData();
        $suratMasuk = PermohonanSurat::orderBy('created_at', 'desc')->get();

        $statusCounts = [
            'diterima' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'diterima')->count(),
            'ditolak' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'ditolak')->count(),
            'menunggu' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'menunggu')->count(),
        ];

        // total investasi
        $totalInvestasi = DataIkm::sum('level');

        // akumulasi IKM
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $akumulasiIKM = DataIkm::whereYear('created_at', $tahunIni)
            ->whereMonth('created_at', '<=', $bulanIni)
            ->count();

        // IKM tahun ke Tahun
        $pertumbuhanIkm = DataIkm::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('YEAR(created_at)'))
        ->orderBy('tahun')
        ->get();

        // Total semua industri
        $totalIndustri = DataIkm::count();

        // Data jumlah per jenis industri
        $sebaranJenisIndustri = DataIkm::select(
                'jenis_industri',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('jenis_industri')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Jumlah total halal & grafik pertumbuhan halal
        $totalHalal = SertifikasiHalal::count();

        $pertumbuhanHalal = SertifikasiHalal::select(
            DB::raw('YEAR(tanggal_sah) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('YEAR(tanggal_sah)'))
        ->orderBy('tahun')
        ->get();

        // Jumlah IKM berdasarkan Investasi
        $levelInvestasi = DataIkm::selectRaw("
            CASE 
                WHEN level < 100000000 THEN 'Kecil'
                WHEN level >= 100000000 THEN 'Menengah'
            END as kategori,
            COUNT(*) as jumlah
        ")
        ->groupBy('kategori')
        ->pluck('jumlah', 'kategori')
        ->toArray();

        $labels = ['Kecil', 'Menengah'];
        $data = [
            'Kecil' => $levelInvestasi['Kecil'] ?? 0,
            'Menengah' => $levelInvestasi['Menengah'] ?? 0
        ];

        $levelIKM = array_sum($levelInvestasi);

        return view('admin.kabid.industri.industri', [
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],
            'totalHalal' => $totalHalal,
            'pertumbuhanHalal' => $pertumbuhanHalal,
            'totalInvestasi' => $totalInvestasi,
            'akumulasiIKM' => $akumulasiIKM,
            'pertumbuhanIkm' => $pertumbuhanIkm,
            'totalIndustri' => $totalIndustri,
            'sebaranJenisIndustri' => $sebaranJenisIndustri,
            'levelIKM' => $levelIKM,
            'labels' => $labels,
            'data' => $data,
            'levelInvestasi' => $levelInvestasi 
        ]);
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'id_user', 'id_user');
    }

    public function verifSurat(Request $request)
    {
        $rekapSurat = $this->getSuratIndustriData();
        $query = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_industri', 'surat_keterangan_industri'])
            ->whereIn('status', ['menunggu', 'diterima', 'ditolak']);
        
        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->whereRaw('LOWER(nama) LIKE ?', ["%$search%"]);
                })
                ->orWhereRaw('LOWER(jenis_surat) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(status) LIKE ?', ["%$search%"]);
            });
        }

        $suratMasuk = $query->orderBy('created_at', 'desc')->get();
        

        return view('admin.kabid.industri.verifSurat', [
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],
            'suratMasuk' => $suratMasuk,
        ]);
    }

    public function setujuiI($id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);

        // Ubah status menjadi 'diterima'
        $permohonan->status = 'diterima';
        $permohonan->save();

        return redirect()->back()->with('success', 'Surat berhasil disetujui dan status diperbarui.');
    }

    public function DataIKM()
    {
        $dataIkm = DataIkm::all();
        return view('admin.kabid.industri.dataIKM', compact('dataIkm'));
    }

    public function sertifikatHalal()
    {
        $data = SertifikasiHalal::orderBy('tanggal_sah', 'desc')->get()->map(function ($item) {
            return [
                'id_halal' => $item->id_halal,
                'nama_usaha' => $item->nama_usaha,
                'no_sertifikasi_halal' => $item->no_sertifikasi_halal,
                'tanggal_sah' => $item->tanggal_sah
                    ? Carbon::parse($item->tanggal_sah)->format('Y-m-d')
                    : null,
                'tanggal_exp' => $item->tanggal_exp
                    ? Carbon::parse($item->tanggal_exp)->format('Y-m-d')
                    : null,

                'tanggal_sah_formatted' => $item->tanggal_sah
                    ? Carbon::parse($item->tanggal_sah)->translatedFormat('d F Y')
                    : '-',
                'tanggal_exp_formatted' => $item->tanggal_exp
                    ? Carbon::parse($item->tanggal_exp)->translatedFormat('d F Y')
                    : '-',

                'alamat' => $item->alamat,
                'status' => $item->status,
                'sertifikat' => $item->sertifikat,
            ];
        });

        return view('admin.kabid.industri.sertifikathalal', compact('data'));
    }

    //KADIS

    public function KadisIndustri (Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
       
        $rekapSurat = $this->getSuratIndustriData();
        $suratMasuk = PermohonanSurat::orderBy('created_at', 'desc')->get();

        $statusCounts = [
            'diterima' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'diterima')->count(),
            'ditolak' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'ditolak')->count(),
            'menunggu' => PermohonanSurat::whereYear('created_at', $tahun)->where('status', 'menunggu')->count(),
        ];

        // total investasi
        $totalInvestasi = DataIkm::sum('level');

        // akumulasi IKM
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $akumulasiIKM = DataIkm::whereYear('created_at', $tahunIni)
            ->whereMonth('created_at', '<=', $bulanIni)
            ->count();

        // IKM tahun ke Tahun
        $pertumbuhanIkm = DataIkm::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('YEAR(created_at)'))
        ->orderBy('tahun')
        ->get();

        // Total semua industri
        $totalIndustri = DataIkm::count();

        // Data jumlah per jenis industri
        $sebaranJenisIndustri = DataIkm::select(
                'jenis_industri',
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('jenis_industri')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Jumlah total halal & grafik pertumbuhan halal
        $totalHalal = SertifikasiHalal::count();

        $pertumbuhanHalal = SertifikasiHalal::select(
            DB::raw('YEAR(tanggal_sah) as tahun'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('YEAR(tanggal_sah)'))
        ->orderBy('tahun')
        ->get();

        // Jumlah IKM berdasarkan Investasi
        $levelInvestasi = DataIkm::selectRaw("
            CASE 
                WHEN level < 100000000 THEN 'Kecil'
                WHEN level >= 100000000 THEN 'Menengah'
            END as kategori,
            COUNT(*) as jumlah
        ")
        ->groupBy('kategori')
        ->pluck('jumlah', 'kategori')
        ->toArray();

        $labels = ['Kecil', 'Menengah'];
        $data = [
            'Kecil' => $levelInvestasi['Kecil'] ?? 0,
            'Menengah' => $levelInvestasi['Menengah'] ?? 0
        ];

        $levelIKM = array_sum($levelInvestasi);

        return view('admin.kepalaDinas.industri', [
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],
            'totalHalal' => $totalHalal,
            'pertumbuhanHalal' => $pertumbuhanHalal,
            'totalInvestasi' => $totalInvestasi,
            'akumulasiIKM' => $akumulasiIKM,
            'pertumbuhanIkm' => $pertumbuhanIkm,
            'totalIndustri' => $totalIndustri,
            'sebaranJenisIndustri' => $sebaranJenisIndustri,
            'levelIKM' => $levelIKM,
            'labels' => $labels,
            'data' => $data,
            'levelInvestasi' => $levelInvestasi, 
        ]);
    }

    public function SuratKadis(Request $request)
    {
        $rekapSurat = $this->getSuratIndustriData();
        $query = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_industri', 'surat_keterangan_industri'])
            ->whereIn('status', ['menunggu', 'diterima', 'ditolak']);
        
        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->whereRaw('LOWER(nama) LIKE ?', ["%$search%"]);
                })
                ->orWhereRaw('LOWER(jenis_surat) LIKE ?', ["%$search%"])
                ->orWhereRaw('LOWER(status) LIKE ?', ["%$search%"]);
            });
        }

        $suratMasuk = $query->orderBy('created_at', 'desc')->get();

        return view('admin.kepalaDinas.suratIndustri', [
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],
            'suratMasuk' => $suratMasuk,
        ]);
    }

    public function kadisSetujui($id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);

        // Ubah status menjadi 'diterima'
        $permohonan->status = 'diterima';
        $permohonan->save();

        return redirect()->back()->with('success', 'Surat berhasil disetujui dan status diperbarui.');
    }
}
