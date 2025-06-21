<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;
use App\Models\PermohonanSurat;
use App\Models\Barang;
use App\Models\DocumentUser;
use App\Models\IndexKategori;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\IndexHarga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\StokOpname;
use App\Models\Toko;
use App\Models\Berita;
use Illuminate\Support\Facades\Log;

class dashboardPerdaganganController extends Controller{
    public function index(Request $request)
    {
        // Ambil data surat perdagangan
        $rekapSurat = $this->getSuratPerdaganganData();
        $dataSurat = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan'])
            ->where('status', '!=', 'disimpan')
            ->whereIn('status', ['menunggu', 'ditolak', 'diterima']) // hanya status ini yang ditampilkan
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar harga barang terbaru (tanpa filter waktu)
        $daftarHarga = DB::table('index_harga')
            ->join('barang', 'index_harga.id_barang', '=', 'barang.id_barang')
            ->join('index_kategori', 'index_harga.id_index_kategori', '=', 'index_kategori.id_index_kategori')
            ->select(
                'barang.nama_barang',
                'index_kategori.nama_kategori as kategori_barang',
                'index_harga.harga as harga_satuan',
                'index_harga.updated_at',   
                'index_harga.tanggal'
            )
            ->orderBy('index_harga.updated_at', 'desc')
            ->get();

        // Ambil daftar lokasi unik untuk dropdown
        $daftar_lokasi = DB::table('index_harga')->select('lokasi')->distinct()->pluck('lokasi');
        $lokasi = $request->input('lokasi', 'Pasar Sumpang');

        // Definisikan range tanggal sebulan terakhir
        $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');

        // Ambil data harga per pasar sebulan terakhir
        $dataSumpang = DB::table('index_harga')
            ->where('lokasi', 'Pasar Sumpang')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get(['tanggal', 'harga']);

        $dataLakessi = DB::table('index_harga')
            ->where('lokasi', 'Pasar Lakessi')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get(['tanggal', 'harga']);

        // Gabungkan semua tanggal unik dari kedua pasar
        $tanggalSumpang = $dataSumpang->pluck('tanggal')->toArray();
        $tanggalLakessi = $dataLakessi->pluck('tanggal')->toArray();
        $allTanggal = array_unique(array_merge($tanggalSumpang, $tanggalLakessi));
        sort($allTanggal);

        // Label untuk grafik (format tanggal user-friendly)
        $labels = array_map(function ($tgl) {
        return Carbon::parse($tgl)->translatedFormat('d M');
        }, $allTanggal);

        // Buat array harga sesuai label, isi null jika tidak ada data di tanggal tersebut
        $hargaSumpang = [];
        foreach ($allTanggal as $tgl) {
            $item = $dataSumpang->firstWhere('tanggal', $tgl);
            $hargaSumpang[] = $item ? (int) $item->harga : null;
        }

        $hargaLakessi = [];
        foreach ($allTanggal as $tgl) {
            $item = $dataLakessi->firstWhere('tanggal', $tgl);
            $hargaLakessi[] = $item ? (int) $item->harga : null;
        }

        // Hitung data ringkasan dari gabungan harga kedua pasar (exclude null)
        $hargaGabungan = array_filter(array_merge($hargaSumpang, $hargaLakessi));

        if (count($hargaGabungan) > 0) {
            $minHarga = min($hargaGabungan);
            $maxHarga = max($hargaGabungan);
            $avgHarga = array_sum($hargaGabungan) / count($hargaGabungan);

            $terendah = number_format($minHarga, 0, ',', '.');
            $tertinggi = number_format($maxHarga, 0, ',', '.');
            $rata_rata = number_format($avgHarga, 0, ',', '.');
            $volatilitas = round((($maxHarga - $minHarga) / ($avgHarga ?: 1)) * 100, 1) . '%';
        } else {
            $terendah = '0';
            $rata_rata = '0';
            $tertinggi = '0';
            $volatilitas = '0%';
        }

        // Tambahkan ini di awal sebelum return view
        $tahunIni = Carbon::now()->year;

        $pupukTahunan = DB::table('stok_opname')
            ->selectRaw('
                SUM(CASE WHEN UPPER(nama_barang) = "UREA" THEN penyaluran ELSE 0 END) as urea,
                SUM(CASE WHEN UPPER(nama_barang) = "NPK" THEN penyaluran ELSE 0 END) as npk,
                SUM(CASE WHEN UPPER(nama_barang) = "NPK-FK" THEN penyaluran ELSE 0 END) as npk_fk
            ')
            ->whereYear('tanggal', $tahunIni)
            ->first();
        $beritaTerbaru = Berita::latest()->take(10)->get();
        // Kirim semua data ke view
        return view('admin.bidangPerdagangan.dashboardPerdagangan', [
            'dataSurat' => $dataSurat,
            'pupukTahunan' => $pupukTahunan,
            'daftarHarga' => $daftarHarga,
            'totalSuratPerdagangan' => $rekapSurat['totalSuratPerdagangan'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'beritaTerbaru' => $beritaTerbaru,
            'labels' => $labels,
            'hargaSumpang' => $hargaSumpang,
            'hargaLakessi' => $hargaLakessi,
            'terendah' => $terendah,
            'rata_rata' => $rata_rata,
            'tertinggi' => $tertinggi,
            'volatilitas' => $volatilitas,
            'daftar_lokasi' => $daftar_lokasi,
            'lokasi' => $lokasi,
        ]);
    }

    private function getSuratPerdaganganData(){
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
            ->count(),

        ];
    }

    public function kelolaSurat(Request $request){
        $rekapSurat = $this->getSuratPerdaganganData();
        $dataSurat = PermohonanSurat::with('user')
            ->where('status', '!=', 'disimpan')
            ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan'])
            ->whereIn('status', ['menunggu', 'ditolak', 'diterima'])
            ->orderBy('created_at', 'desc')
            ->get();

        $query = PermohonanSurat::with('user')
        ->where('status', '!=', 'disimpan')
        ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan'])
        ->whereIn('status', ['menunggu', 'ditolak', 'diterima']);

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

    $dataSurat = $query->orderBy('created_at', 'desc')->get();

        return view('admin.bidangPerdagangan.kelolaSurat', [
            'dataSurat' => $dataSurat,
            'totalSuratPerdagangan' => $rekapSurat['totalSuratPerdagangan'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
        ]);
    }

    public function detailSurat($id){
        $data = PermohonanSurat::where('id_permohonan', $id)->first();
        $dokumen = DocumentUser::where('id_permohonan', $id)->first();
        $user = DB::table('user')->where('id_user', $data->id_user)->first();

        return view('admin.bidangPerdagangan.detailPermohonan', [
            'data' => $data,
            'dokumen' => $dokumen,
            'user' => $user,
        ]);
    }

    public function viewDokumen($id, $type){
        $dokumen = DB::table('document_user')->where('id_permohonan', $id)->first();

        if (!$dokumen) {
            return abort(404, 'Dokumen tidak ditemukan.');
        }

        $filePath = match (strtoupper($type)) {
            'NIB' => $dokumen->dokument_nib ?? null,
            'NPWP' => $dokumen->npwp ?? null,
            'KTP' => $dokumen->foto_ktp ?? null,
            'AKTA' => $dokumen->akta_perusahaan ?? null,
            'USAHA' => $dokumen->foto_usaha ?? null,
            'SURAT' => DB::table('form_permohonan')->where('id_permohonan', $id)->value('file_surat'),
            default => null,
        };

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return abort(404, 'File tidak ditemukan.');
        }

        return response()->file(storage_path("app/public/{$filePath}"));
    }

    public function formTambahBarang(){
        $kategori = IndexKategori::all();
        return view('admin.bidangPerdagangan.tambahBarang', compact('kategori'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'kategori_lama' => 'nullable|string',
            'kategori_baru' => 'nullable|string',
        ]);

        $idKategori = null;

        if ($request->kategori_lama === 'tambah_baru' && $request->filled('kategori_baru')) {
            $kategoriBaru = IndexKategori::create([
                'nama_kategori' => $request->kategori_baru,
            ]);
            $idKategori = $kategoriBaru->id_index_kategori;
        } elseif (is_numeric($request->kategori_lama)) {
            $kategoriLama = IndexKategori::find($request->kategori_lama);
            if ($kategoriLama) {
                $idKategori = $kategoriLama->id_index_kategori;
            }
        }

        if (!$idKategori) {
            return back()->withErrors(['kategori' => 'Kategori tidak valid.'])->withInput();
        }

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'id_index_kategori' => $idKategori,
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function formUpdateHarga(){
        $kategoris = IndexKategori::orderBy('nama_kategori')->get();
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('admin.bidangPerdagangan.updateHarga', compact('kategoris', 'barangs'));
    }
    public function update(Request $request){
        $request->validate([
            'id_index_kategori' => 'required|exists:index_kategori,id_index_kategori',
            'id_barang' => 'required|exists:barang,id_barang',
            'harga' => 'required|numeric',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
        ]);

        IndexHarga::create([
            'id_index_kategori' => $request->id_index_kategori,
            'id_barang' => $request->id_barang,
            'harga' => $request->harga,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Harga barang berhasil diperbarui.');
    }

    public function getByKategori($id){
        $barangs = Barang::where('id_index_kategori', $id)->get(['id_barang', 'nama_barang']);
        return response()->json($barangs);
    }

    public function deleteBarang(){
        $barangs = Barang::with('kategori')->get(); // eager load kategori
        return view('admin.bidangPerdagangan.hapusBarang', compact('barangs'));
    }

    public function destroy($id){
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }

    public function laporanPupuk(Request $request){
        $bulanTahun = $request->input('bulan_tahun');
        $tahunInput = $request->input('tahun');

        $bulan = null;
        $tahun = null;

        $data = [];
        $pieData = [];
        $lineChartLabels = [];
        $lineChartData = [
            'UREA' => [],
            'NPK' => [],
            'NPK-FK' => [],
        ];

        if ($bulanTahun) {
            [$tahun, $bulan] = explode('-', $bulanTahun);
        } elseif ($tahunInput) {
            $tahun = $tahunInput;
        } else {
            // Default ke bulan dan tahun saat ini
            $bulan = now()->month;
            $tahun = now()->year;
        }

        $query = StokOpname::with('toko');

        if ($bulan && $tahun) {
            // Data 1 bulan
            $query->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun);
        } elseif ($tahun) {
            // Data 1 tahun penuh
            $query->whereYear('tanggal', $tahun);
        }

        $stokOpnames = $query->get();

        foreach ($stokOpnames as $record) {
            $toko = $record->toko->nama_toko ?? 'Tidak diketahui';
            $barang = strtoupper($record->nama_barang);
            $idToko = $record->toko->id_toko ?? null; // ambil id_toko
        
            if (!isset($data[$toko])) {
                $data[$toko] = [
                    'id_toko' => $idToko,
                    'pupuk' => [],
                ];
            }

            // Data Tabel
            if (!isset($data[$toko][$barang])) {
                $data[$toko][$barang] = [
                    'stok_awal' => 0,
                    'penyaluran' => 0,
                    'stok_akhir' => 0,
                ];
            }

            $data[$toko][$barang]['stok_awal'] += $record->stok_awal;
            $data[$toko][$barang]['penyaluran'] += $record->penyaluran;
            $data[$toko][$barang]['stok_akhir'] += $record->stok_akhir;

            // Data Pie Chart
            if (!isset($pieData[$barang])) {
                $pieData[$barang] = 0;
            }
            $pieData[$barang] += $record->penyaluran;
        }

        // Data Line Chart
        foreach ($data as $toko => $pupuk) {
            $lineChartLabels[] = $toko;
            foreach (['UREA', 'NPK', 'NPK-FK'] as $jenis) {
                $lineChartData[$jenis][] = $pupuk[$jenis]['penyaluran'] ?? 0;
            }
        }

        return view('admin.bidangPerdagangan.lihatLaporan', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'pieData' => $pieData,
            'lineChartLabels' => $lineChartLabels,
            'lineChartData' => $lineChartData,
            'message' => ''
        ]);
    }

    public function formPermohonan(Request $request)
    {
        $idUser = auth()->guard('user')->id();
        $draftId = $request->query('draft_id');

        // Ambil semua draft user (list untuk dropdown)
        $drafts = DB::table('form_permohonan')
            ->where('id_user', $idUser)
            ->where('status', 'disimpan')
            ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan'])
            ->orderBy('created_at', 'desc')
            ->get();

        $draft = null;

        // Ambil data lengkap jika draft dipilih
        if ($draftId) {
            $draft = DB::table('form_permohonan as f')
                ->leftJoin('document_user as d', 'f.id_permohonan', '=', 'd.id_permohonan')
                ->where('f.id_user', $idUser)
                ->where('f.id_permohonan', $draftId)
                ->where('f.status', 'disimpan')
                ->select('f.*', 'd.npwp', 'd.akta_perusahaan', 'd.foto_ktp', 'd.foto_usaha', 'd.dokument_nib')
                ->first();
        }

        // Ambil list kelurahan unik (jika masih dibutuhkan)
        $listKelurahan = DB::table('form_permohonan')
            ->select('kelurahan')
            ->distinct()
            ->whereNotNull('kelurahan')
            ->orderBy('kelurahan')
            ->pluck('kelurahan');

        return view('user.bidangPerdagangan.formPermohonan', compact('drafts', 'draft', 'listKelurahan'));
    }

    public function riwayatSurat(){
        if (!auth()->guard('user')->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }
        $userId = Auth::guard('user')->id();

        $query = PermohonanSurat::where('id_user', $userId)
            ->whereIn('status', ['menunggu', 'ditolak', 'diterima']) // hanya status ini yang ditampilkan
            ->whereIn('jenis_surat', ['surat_rekomendasi_perdagangan', 'surat_keterangan_perdagangan']);

        if ($searchTerm = request('search')) {
            $search = strtolower(trim($searchTerm));

            $mapping = [
                'surat rekomendasi' => 'surat_rekomendasi_perdagangan',
                'rekomendasi' => 'surat_rekomendasi_perdagangan',
                'rek' => 'surat_rekomendasi_perdagangan',
                'surat keterangan' => 'surat_keterangan_perdagangan',
                'keterangan' => 'surat_keterangan_perdagangan',
                'ket' => 'surat_keterangan_perdagangan',
            ];

            $matchedJenis = null;
            foreach ($mapping as $key => $value) {
                if (str_contains($search, $key)) {
                    $matchedJenis = $value;
                    break;
                }
            }

            $query->where(function ($q) use ($search, $matchedJenis) {
                if ($matchedJenis) {
                    $q->where('jenis_surat', $matchedJenis);
                } else {
                    $q->whereRaw('LOWER(status) LIKE ?', ["%$search%"])
                    ->orWhereRaw('DATE_FORMAT(tgl_pengajuan, "%d-%m-%Y") LIKE ?', ["%$search%"]);
                }
            });
        }

        $riwayatSurat = $query->latest()->get();

        return view('user.bidangPerdagangan.riwayatSurat', compact('riwayatSurat'));
    }


    public function tolak(Request $request, $id){
        $request->validate([
            'nama_pengirim' => 'required|string',
            'alasan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $permohonan = PermohonanSurat::findOrFail($id);

        $permohonan->status = 'ditolak';

        // Generate PDF
        try {
            // Buat PDF dari view blade// Tambahkan ini sebelum generate PDF
            ini_set('max_execution_time', 300); // 300 detik = 5 menit

            $pdf = Pdf::loadView('SuratBalasan.surat-penolakan', [
                'nama_pengirim' => $request->nama_pengirim,
                'alasan' => $request->alasan,
                'tanggal' => $request->tanggal
            ]);;


            // Nama file unik
            $filename = 'penolakan-' . Str::uuid() . '.pdf';
            // Simpan ke folder 'public/surat' di storage
            Storage::disk('public')->put("surat/{$filename}", $pdf->output());

            // Update kolom 'file_balasan' dengan path file yang baru disimpan
            $permohonan->file_balasan = "surat/{$filename}";

            // Simpan perubahan ke database (update status dan file_balasan)
            $permohonan->save();

            return redirect()
                ->route('perdagangan.detailSurat', ['id_permohonan' => $id])
                ->with('success', 'Surat berhasil disimpan dan diunggah.');
        } catch (Exception $e) {
            // Log error jika terjadi masalah
            dd($e->getMessage());
        }
    }

    public function simpanRekomendasi(Request $request, $id){
        
        set_time_limit(300); // waktu dalam detik

        // Validasi input
        $request->validate([
            'nomor_surat'       => 'required|string',
            'tanggal_surat'     => 'required|date',
            'nama_pengirim'     => 'required|string',
            'nik'               => 'required|string',
            'warga_negara'      => 'required|string',
            'pekerjaan'         => 'required|string',
            'alamat_rumah'      => 'required|string',
            'nama_usaha'        => 'required|string',
            'bentuk_usaha'      => 'required|string',
            'jenis_perusahaan'  => 'required|string',
            'luas_ruangan'      => 'required|string',
            'isi'      => 'required|string',
            'alamat_usaha'      => 'required|string',
        ]);

        // Cari permohonan berdasarkan ID
        $permohonan = PermohonanSurat::findOrFail($id);

        try {

            // Generate PDF dari view blade
            $pdf = Pdf::loadView('SuratBalasan.surat-rekomendasi', [
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'nama_pengirim' => $request->nama_pengirim,
                'nik' => $request->nik,
                'warga_negara' => $request->warga_negara,
                'pekerjaan' => $request->pekerjaan,
                'alamat_rumah' => $request->alamat_rumah,
                'nama_usaha' => $request->nama_usaha,
                'bentuk_usaha' => $request->bentuk_usaha,
                'jenis_perusahaan' => $request->jenis_perusahaan,
                'luas_ruangan' => $request->luas_ruangan,
                'alamat_usaha' => $request->alamat_usaha,
                'isi' => $request->isi,
                'status' => $permohonan->status, // Kirim status ke view
            ]);

            // Nama file unik
            $filename = 'rekomendasi-' . Str::uuid() . '.pdf';
            // Simpan ke folder 'public/surat' di storage
            Storage::disk('public')->put("surat/{$filename}", $pdf->output());

            // Update kolom 'file_balasan' dengan path file yang baru disimpan
            $permohonan->file_balasan = "surat/{$filename}";

            // Simpan perubahan ke database (update status dan file_balasan)
            $permohonan->save();

            // Kembalikan response yang mengarah langsung ke file PDF menggunakan response()->file()
            return redirect()
                ->route('perdagangan.detailSurat', ['id_permohonan' => $id])
                ->with('success', 'Surat berhasil disimpan dan diunggah.');
        } catch (ValidationException $e) {
            dd($e->errors()); // Menampilkan semua error validasi dalam bentuk array
        }
    }

    public function simpanketerangan(Request $request, $id){

        // Validasi input
        $request->validate([
            'tanggal_surat'     => 'required|date',
            'nama_pengirim'     => 'required|string',
            'jabatan'           => 'required|string',
            'nama_penerima'     => 'required|string',
            'tampat_lahir'      => 'required|string',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|string',
            'agama'             => 'required|string',
            'alamat_lengkap'    => 'required|string',
            'isi'               => 'required|string',
            'status_pernikahan' => 'required|string',
        ]);

        // Cari permohonan berdasarkan ID
        $permohonan = PermohonanSurat::findOrFail($id);

        try {

            // Generate PDF dari view blade
            $pdf = Pdf::loadView('SuratBalasan.surat-keterangan', [
                'tanggal_surat'     => $request->tanggal_surat,
                'nama_pengirim'     => $request->nama_pengirim,
                'jabatan'           => $request->jabatan,
                'nama_penerima'     => $request->nama_penerima,
                'tampat_lahir'      => $request->tampat_lahir,
                'tanggal_lahir'     => $request->tanggal_lahir,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'agama'             => $request->agama,
                'alamat_lengkap'    => $request->alamat_lengkap,
                'isi'               => $request->isi,
                'status_pernikahan' => $request->status_pernikahan,
            ]);

            // Nama file unik
            $filename = 'rekomendasi-' . Str::uuid() . '.pdf';
            // Simpan ke folder 'public/surat' di storage
            Storage::disk('public')->put("surat/{$filename}", $pdf->output());

            // Update kolom 'file_balasan' dengan path file yang baru disimpan
            $permohonan->file_balasan = "surat/{$filename}";

            // Simpan perubahan ke database (update status dan file_balasan)
            $permohonan->save();

            return redirect()
                ->route('perdagangan.detailSurat', ['id_permohonan' => $id])
                ->with('success', 'Surat berhasil disimpan dan diunggah.');
        } catch (ValidationException $e) {
            dd($e->errors()); // Menampilkan semua error validasi dalam bentuk array
        }
    }

    public function ajukanPermohonan(Request $request){
        $idUser = session('id_user');
        $status = $request->input('submit_action'); // 'ajukan' atau 'simpan'

        // Ambil draft yang ada dengan status 'disimpan'
        $draft = PermohonanSurat::where('id_user', $idUser)->where('status', 'disimpan')->first();

        // Validasi form - untuk status 'ajukan' wajib isi semua file, untuk 'disimpan' boleh kosong
        $rules = [
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'jenis_surat' => 'required|string',
            'titik_koordinat' => 'nullable|string',
        ];

        if ($status === 'ajukan') {
            // Jika tidak ada file baru, tapi file lama juga kosong => error
            $rules['foto_usaha'] = ($draft && optional($draft->document)->foto_usaha) ? 'nullable|image|mimes:jpeg,png,jpg|max:512' : 'required|image|mimes:jpeg,png,jpg|max:512';
            $rules['foto_ktp'] = ($draft && optional($draft->document)->foto_ktp) ? 'nullable|image|mimes:jpeg,png,jpg|max:512' : 'required|image|mimes:jpeg,png,jpg|max:512';
            $rules['dokument_nib'] = ($draft && optional($draft->document)->dokument_nib) ? 'nullable|mimes:pdf|max:512' : 'required|mimes:pdf|max:512';
            $rules['npwp'] = ($draft && optional($draft->document)->npwp) ? 'nullable|mimes:pdf,jpg,jpeg,png|max:512' : 'required|mimes:pdf,jpg,jpeg,png|max:512';
            $rules['akta_perusahaan'] = ($draft && optional($draft->document)->akta_perusahaan) ? 'nullable|mimes:pdf|max:512' : 'required|mimes:pdf|max:512';
            $rules['surat'] = ($draft && $draft->file_surat) ? 'nullable|file|mimes:pdf,doc,docx|max:512' : 'required|file|mimes:pdf,doc,docx|max:512';
        } else {
            // Jika simpan draft, file boleh tidak ada
            $rules['foto_usaha'] = 'nullable|image|mimes:jpeg,png,jpg|max:512';
            $rules['foto_ktp'] = 'nullable|image|mimes:jpeg,png,jpg|max:512';
            $rules['dokument_nib'] = 'nullable|mimes:pdf|max:512';
            $rules['npwp'] = 'nullable|mimes:pdf,jpg,jpeg,png|max:512';
            $rules['akta_perusahaan'] = 'nullable|mimes:pdf|max:512';
            $rules['surat'] = 'nullable|file|mimes:pdf,doc,docx|max:512';
        }

        $request->validate($rules);

        // Fungsi upload file (replace file lama jika ada)
        $uploadFile = function ($field, $oldPath = null) use ($request) {
            if ($request->hasFile($field)) {
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                return $request->file($field)->store('DokumentUser', 'public');
            }
            return $oldPath;
        };


        DB::beginTransaction();

        try {
            if ($draft) {
                // Update draft yang sudah ada
                $draft->update([
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'jenis_surat' => $request->jenis_surat,
                    'tgl_pengajuan' => now()->toDateString(),
                    'titik_koordinat' => $request->titik_koordinat,
                    'status' => $status === 'ajukan' ? 'menunggu' : 'disimpan',
                    'file_surat' => $uploadFile('surat', $draft->file_surat),
                    'updated_at' => now(),
                ]);
            } else {
                // Buat baru
                $draft = PermohonanSurat::create([
                    'id_permohonan' => (string) Str::uuid(),
                    'id_user' => $idUser,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'jenis_surat' => $request->jenis_surat,
                    'titik_koordinat' => $request->titik_koordinat,
                    'status' => $status === 'ajukan' ? 'menunggu' : 'disimpan',
                    'file_surat' => $uploadFile('surat'),
                    'tgl_pengajuan' => now()->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Handle DocumentUser (dokumen tambahan)
            $document = $draft->document;

            if ($document) {
                $document->update([
                    'foto_usaha' => $uploadFile('foto_usaha', $document->foto_usaha),
                    'foto_ktp' => $uploadFile('foto_ktp', $document->foto_ktp),
                    'dokument_nib' => $uploadFile('dokument_nib', $document->dokument_nib),
                    'npwp' => $uploadFile('npwp', $document->npwp),
                    'akta_perusahaan' => $uploadFile('akta_perusahaan', $document->akta_perusahaan),
                ]);
            } else {
                DocumentUser::create([
                    'id_permohonan' => $draft->id_permohonan,
                    'foto_usaha' => $uploadFile('foto_usaha'),
                    'foto_ktp' => $uploadFile('foto_ktp'),
                    'dokument_nib' => $uploadFile('dokument_nib'),
                    'npwp' => $uploadFile('npwp'),
                    'akta_perusahaan' => $uploadFile('akta_perusahaan'),
                ]);
            }

            DB::commit();

            $pesan = $status === 'ajukan' ? 'Permohonan berhasil diajukan.' : 'Draft berhasil disimpan.';

            // Tentukan rute berdasarkan status
            $route = $status === 'ajukan' ? 'bidangPerdagangan.riwayatSurat' : 'bidangPerdagangan.formPermohonan';

            return redirect()->route($route)->with('success', $pesan);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function updateStokAwal(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'id_stok_opname' => 'required|exists:stok_opname,id_stok_opname',
            'stok_awal' => 'required|integer|min:0',
        ]);

        try {
            // Log input untuk debugging
            Log::info('Permintaan update stok_awal:', $request->all());

            // Ambil data stok_opname berdasarkan ID
            $stok = StokOpname::find($request->id_stok_opname);

            if (!$stok) {
                Log::warning('Data stok_opname tidak ditemukan. ID: ' . $request->id_stok_opname);
                return back()->with('error', 'Data tidak ditemukan.');
            }

            // Update stok_awal dan stok_akhir (dihitung otomatis)
            $stok->stok_awal = $request->stok_awal;
            $stok->stok_akhir = $request->stok_awal - $stok->penyaluran;
            $stok->save();

            Log::info('Stok berhasil diperbarui untuk ID: ' . $stok->id_stok_opname);
            return back()->with('success', 'Stok berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal update stok: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
    public function updatePenyaluran(Request $request)
    {
        $request->validate([
            'id_stok_opname' => 'required|exists:stok_opname,id_stok_opname',
            'penyaluran' => 'required|integer|min:0',
        ]);

        $stok = StokOpname::findOrFail($request->id_stok_opname);
        $stok->penyaluran = $request->penyaluran;

        // Perhitungan ulang stok_akhir
        $stok->stok_akhir = $stok->stok_awal - $stok->penyaluran;

        $stok->save();

        return back()->with('success', 'Data penyaluran berhasil diperbarui dan stok akhir dihitung ulang.');
    }

    public function EditlaporanPupuk($id_toko, Request $request)
    {
        $toko = Toko::findOrFail($id_toko);
        $jumlah = null;

        if ($request->has(['jenis_pupuk', 'tahun', 'bulan', 'minggu'])) {
            // Hitung rentang tanggal untuk minggu ke-n
            $tanggalAwal = Carbon::create($request->tahun, $request->bulan, 1)->startOfMonth();
            $tanggalMulai = $tanggalAwal->copy()->addDays(($request->minggu - 1) * 7);
            $tanggalAkhir = $tanggalMulai->copy()->addDays(6);

            // Ambil data dari stok_opname
            $laporan = StokOpname::where('id_toko', $id_toko)
                ->where('nama_barang', strtoupper($request->jenis_pupuk))
                ->whereDate('tanggal', '>=', $tanggalMulai)
                ->whereDate('tanggal', '<=', $tanggalAkhir)
                ->first();

            // Ambil jumlah penyaluran atau 0 jika tidak ada
            $jumlah = $laporan->penyaluran ?? 0;
        }

        return view('admin.bidangPerdagangan.edit', compact('toko', 'jumlah'));
    }

    public function CarilaporanPupuk(Request $request)
    {
        $id_toko = $request->id_toko;
        $nama_barang = $request->nama_barang;

        if (!$id_toko) {
            return back()->with('error', 'ID Toko tidak ditemukan');
        }

        $toko = Toko::findOrFail($id_toko);
        $jumlah = null;
        $stokAwal = collect();

        if ($request->has(['nama_barang', 'tahun', 'bulan', 'minggu'])) {
            $tanggalAwal = Carbon::create($request->tahun, $request->bulan, 1)->startOfMonth();
            $tanggalMulai = $tanggalAwal->copy()->addDays(($request->minggu - 1) * 7);
            $tanggalAkhir = $tanggalMulai->copy()->addDays(6);

            $stokAwal = StokOpname::select('id_stok_opname', 'tanggal', 'stok_awal')
                ->where('id_toko', $id_toko)
                ->where('nama_barang', strtoupper($nama_barang))
                ->whereDate('tanggal', '>=', $tanggalMulai)
                ->whereDate('tanggal', '<=', $tanggalAkhir)
                ->get();

            $penyaluran = StokOpname::where('id_toko', $id_toko)
                ->where('nama_barang', strtoupper($nama_barang))
                ->whereDate('tanggal', '>=', $tanggalMulai)
                ->whereDate('tanggal', '<=', $tanggalAkhir)
                ->first(); // hanya satu input penyaluran per minggu
            }

        return view('admin.bidangPerdagangan.edit', compact('toko', 'jumlah', 'stokAwal', 'penyaluran'))
            ->with('filter', $request->all());
    }
}