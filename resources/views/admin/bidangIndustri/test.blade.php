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
use Illuminate\Support\Facades\Auth;
use App\Models\DataIkm;
use App\Models\SertifikasiHalal;
use App\Exports\DataIkmExport;
use Maatwebsite\Excel\Facades\Excel;;

use Illuminate\Support\Facades\Validator;

use App\Models\Pengeluaran;
use App\Models\Persediaan;
use App\Models\Karyawan;
use App\Models\BentukPengelolaanLimbah;
use App\Models\Pendapatan;
use App\Models\PersentasePemilik;
use App\Models\Produksi;
use App\Models\Listrik;
use App\Models\PenggunaanAir;
use App\Models\PenggunaanBahanBakar;
use App\Models\PemakaianBahan;
use App\Models\MesinProduksi;





class AdminIndustriController extends Controller
{
    public function showDashboard()
    {

        // Ambil data surat industri
        $rekapSurat = $this->getSuratIndustriData();
        $dataSurat = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_industri', 'surat_keterangan_industri'])
            ->orderBy('created_at', 'desc')
            ->get();


        // Definisikan range tanggal sebulan terakhir
        $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');

        // Kirim semua data ke view
        return view('admin.bidangIndustri.dashboardAdmin', [
            'dataSurat' => $dataSurat,
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],

        ]);
    }

    private function getSuratIndustriData()
    {
        $jenis = [
            'surat_rekomendasi_industri',
            'surat_keterangan_industri',
            'dan_lainnya_industri',
        ];

        return [
            'totalSuratIndustri' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->count(),
            'totalSuratTerverifikasi' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'diterima')->count(),
            'totalSuratDitolak' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'ditolak')->count(),
            'totalSuratDraft' => DB::table('form_permohonan')->whereIn('jenis_surat', $jenis)->where('status', 'draft')->count(),
        ];
    }

    public function detailSuratt($id)
    {
        $data = PermohonanSurat::where('id_permohonan', $id)->first();
        $dokumen = DocumentUser::where('id_permohonan', $id)->first();
        $user = DB::table('user')->where('id_user', $data->id_user)->first();

        return view('admin.bidangIndustri.detailPermohonan', [
            'data' => $data,
            'dokumen' => $dokumen,
            'user' => $user,
        ]);
    }

    public function viewDokumen($id, $type)
    {
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

    public function tolakk(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_pengirim' => 'required|string',
            'alasan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Cari permohonan berdasarkan ID
        $permohonan = PermohonanSurat::findOrFail($id);

        // Set status menjadi 'ditolak'
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

            // Kembalikan response yang mengarah langsung ke file PDF menggunakan response()->file()
            return response()->file(storage_path("app/public/surat/{$filename}"));
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            dd($e->getMessage());
        }
    }

    public function simpanRekomendasi(Request $request, $id)
    {
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
            return response()->file(storage_path("app/public/surat/{$filename}"));
        } catch (ValidationException $e) {
            dd($e->errors()); // Menampilkan semua error validasi dalam bentuk array
        }
    }

    public function simpanketerangan(Request $request, $id)
    {

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

            // Kembalikan response yang mengarah langsung ke file PDF menggunakan response()->file()
            return response()->file(storage_path("app/public/surat/{$filename}"));
        } catch (ValidationException $e) {
            dd($e->errors()); // Menampilkan semua error validasi dalam bentuk array
        }
        return view('admin.bidangIndustri.dashboardAdmin');
    }

    public function showDataIKM()
    {
        $dataIkm = DataIkm::with([
            'pemakaianBahan',
            'penggunaanAir',
            'pengeluaran',
            'penggunaanBahanBakar',
            'listrik',
            'mesinProduksi',
            'produksi',
            'persediaan',
            'pendapatan',
            'modal',
            'bentukPengelolaanLimbah'
        ])->get();


        return view('admin.bidangIndustri.dataIKM', compact('dataIkm'));
    }

    public function editIKM($id)
    {
        $ikm = \App\Models\DataIkm::findOrFail($id);
        return view('admin.bidangindustri.editIKM', compact('ikm'));
    }

    public function detailIKM($id)
    {
        $ikm = DataIkm::with([
            'karyawan',
            'persentasePemilik',
            'pemakaianBahan',
            'penggunaanAir',
            'pengeluaran',
            'penggunaanBahanBakar',
            'listrik',
            'mesinProduksi',
            'produksi',
            'persediaan',
            'pendapatan',
            'modal',
            'bentukPengelolaanLimbah',
        ])->findOrFail($id);

        return view('admin.bidangIndustri.detailIKM', compact('ikm'));
    }

    public function updateIKM(Request $request)
    {
        $ikm = DataIkm::find($request->id_ikm);

        if (!$ikm) {
            return back()->withErrors(['msg' => 'Data IKM tidak ditemukan.']);
        }

        $ikm->update($request->only([
            'nama_ikm',
            'nama_pemilik',
            'jenis_kelamin',
            'kecamatan',
            'kelurahan',
            'alamat',
            'luas',
            'komoditi',
            'jenis_industri',
            'nib',
            'no_telp',
            'tenaga_kerja'
        ]));

        return back()->with('success', 'Data IKM berhasil diperbarui!');
    }


    public function updatePengeluaran(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pengeluaran,id_pengeluaran',
            'upah_gaji' => 'nullable|numeric',
            'pengeluaran_industri_distribusi' => 'nullable|numeric',
            'pengeluaran_rnd' => 'nullable|numeric',
            'pengeluaran_tanah' => 'nullable|numeric',
            'pengeluaran_gedung' => 'nullable|numeric',
            'pengeluaran_mesin' => 'nullable|numeric',
            'lainnya' => 'nullable|numeric',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($request->id);
        $pengeluaran->update($request->except('id'));

        return redirect()->back()->with('success', 'Data pengeluaran berhasil diperbarui.');
    }


    public function updatePersediaan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:persediaan,id_persediaan',
            'jenis_persediaan' => 'required|string',
            'awal' => 'required|numeric',
            'akhir' => 'required|numeric',
        ]);

        $persediaan = Persediaan::findOrFail($request->id);
        $persediaan->update($request->only(['jenis_persediaan', 'awal', 'akhir']));

        return redirect()->back()->with('success', 'Data persediaan berhasil diperbarui.');
    }


    public function updateKaryawan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:karyawan,id_karyawan',
            'tenaga_kerja_tetap' => 'nullable|integer|min:0',
            'tenaga_kerja_tidak_tetap' => 'nullable|integer|min:0',
            'tenaga_kerja_laki_laki' => 'nullable|integer|min:0',
            'tenaga_kerja_perempuan' => 'nullable|integer|min:0',
            'sd' => 'nullable|integer|min:0',
            'smp' => 'nullable|integer|min:0',
            'sma_smk' => 'nullable|integer|min:0',
            'd1_d3' => 'nullable|integer|min:0',
            's1_d4' => 'nullable|integer|min:0',
            's2' => 'nullable|integer|min:0',
            's3' => 'nullable|integer|min:0',
        ]);

        $karyawan = Karyawan::findOrFail($request->id);
        $karyawan->update($request->except('id'));

        return redirect()->back()->with('success', 'Data tenaga kerja berhasil diperbarui.');
    }


    public function updateLimbah(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bentuk_pengelolaan_limbah,id_limbah',
            'jenis_limbah' => 'nullable|string',
            'jumlah_limbah' => 'nullable|numeric',
            'jenis_limbah_b3' => 'nullable|string',
            'jumlah_limbah_b3' => 'nullable|numeric',
            'tps_limbah_b3' => 'nullable|string',
            'pihak_berizin' => 'nullable|string',
            'internal_industri' => 'nullable|string',
            'parameter_limbah_cair' => 'nullable|string',
            'jumlah_limbah_cair' => 'nullable|numeric',
        ]);

        $limbah = BentukPengelolaanLimbah::findOrFail($request->id);
        $limbah->update($request->except('id'));

        return redirect()->back()->with('success', 'Data pengelolaan limbah berhasil diperbarui.');
    }


    public function updatePendapatan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pendapatan,id_pendapatan',
            'sumber' => 'required|string',
            'nilai' => 'required|numeric',
        ]);

        $pendapatan = Pendapatan::findOrFail($request->id);
        $pendapatan->update($request->only(['sumber', 'nilai']));

        return redirect()->back()->with('success', 'Data pendapatan berhasil diperbarui.');
    }


    public function updatePersentase(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:persentase_pemilik,id_persentase',
            'pemerintah_pusat' => 'required|numeric|min:0|max:100',
            'pemerintah_daerah' => 'required|numeric|min:0|max:100',
            'swasta_nasional' => 'required|numeric|min:0|max:100',
            'asing' => 'required|numeric|min:0|max:100',
        ]);

        $persentase = PersentasePemilik::findOrFail($request->id);
        $persentase->update($request->except('id'));

        return redirect()->back()->with('success', 'Data persentase kepemilikan berhasil diperbarui.');
    }


    public function updateProduksi(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:produksi,id_produksi',
            'jenis_produksi' => 'required|string',
            'kbli' => 'nullable|string',
            'kode_hs' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'banyaknya' => 'required|numeric',
            'nilai' => 'required|numeric',
            'satuan' => 'required|string',
            'presentase_produk_ekspor' => 'nullable|numeric',
            'negara_tujuan_ekspor' => 'nullable|string',
            'kapasitas_terpasang_per_tahun' => 'nullable|numeric',
        ]);

        $produksi = Produksi::findOrFail($request->id);
        $produksi->update($request->except('id'));

        return redirect()->back()->with('success', 'Data produksi berhasil diperbarui.');
    }


    public function updateListrik(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:listrik,id_listrik',
            'sumber' => 'required|string',
            'banyaknya' => 'required|numeric',
            'nilai' => 'required|numeric',
            'peruntukkan' => 'required|string',
        ]);

        $listrik = Listrik::findOrFail($request->id);
        $listrik->update($request->only(['sumber', 'banyaknya', 'nilai', 'peruntukkan']));

        return redirect()->back()->with('success', 'Data penggunaan listrik berhasil diperbarui.');
    }

    public function updatePenggunaanAir(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:penggunaan_air,id_air',
            'sumber_air' => 'required|string',
            'banyaknya_penggunaan_m3' => 'required|numeric',
            'biaya' => 'required|numeric',
        ]);

        $air = PenggunaanAir::findOrFail($request->id);
        $air->update($validated);

        return redirect()->back()->with('success', 'Data penggunaan air berhasil diperbarui.');
    }


    public function updatePemakaianBahan(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:pemakaian_bahan,id_pemakaian_bahan',
            'nama_bahan' => 'required|string',
            'jenis_bahan' => 'required|string',
            'spesifikasi' => 'nullable|string',
            'kode_hs' => 'nullable|string',
            'satuan_standar' => 'required|string',
            'jumlah_dalam_negeri' => 'required|numeric',
            'nilai_dalam_negeri' => 'required|numeric',
            'jumlah_impor' => 'required|numeric',
            'nilai_impor' => 'required|numeric',
            'negara_asal_impor' => 'nullable|string',
        ]);

        $bahan = PemakaianBahan::findOrFail($request->id);
        $bahan->update($validated);

        return redirect()->back()->with('success', 'Data pemakaian bahan berhasil diperbarui.');
    }



    public function updateBahanBakar(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:penggunaan_bahan_bakar,id_bahan_bakar',
            'jenis_bahan_bakar' => 'required|string',
            'satuan_standar' => 'required|string',
            'banyaknya_proses_produksi' => 'required|numeric',
            'nilai_proses_produksi' => 'required|numeric',
            'banyaknya_pembangkit_tenaga_listrik' => 'required|numeric',
            'nilai_pembangkit_tenaga_listrik' => 'required|numeric',
        ]);

        $bahanBakar = PenggunaanBahanBakar::findOrFail($request->id);
        $bahanBakar->update($validated);

        return redirect()->back()->with('success', 'Data bahan bakar berhasil diperbarui.');
    }

    public function updateMesinProduksi(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:mesin_produksi,id_mesin',
            'jenis_mesin' => 'required|string',
            'nama_mesin' => 'required|string',
            'merk_type' => 'required|string',
            'teknologi' => 'nullable|string',
            'negara_pembuat' => 'nullable|string',
            'tahun_perolehan' => 'required|numeric',
            'tahun_pembuatan' => 'required|numeric',
            'jumlah_unit' => 'required|numeric',
        ]);

        $mesin = MesinProduksi::where('id_mesin', $request->id)->firstOrFail();
        $mesin->update($validated);

        return redirect()->back()->with('success', 'Data mesin produksi berhasil diperbarui.');
    }






    public function destroyIKM($id)
    {
        \App\Models\DataIkm::destroy($id);
        return redirect()->route('dataIKM')->with('success', 'Data berhasil dihapus.');
    }


    public function ShowformIKM()
    {
        $json = file_get_contents(public_path('assets/data/wilayah.json'));
        $wilayah = json_decode($json, true);

        return view('admin.bidangIndustri.formIKM', compact('wilayah'));
    }

    public function exportIKM(Request $request)
    {
        $jenis = $request->input('jenis', []);
        $kecamatan = $request->input('kecamatan');
        $investasi = $request->input('investasi', []);


        return Excel::download(new DataIkmExport($jenis, $kecamatan, $investasi), 'data_ikm.xlsx');
    }


    public function storeDataIKM(Request $request)
    {
        Log::info('MASUK STORE IKM', $request->all());


        $validate = function (array $rules) use ($request) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
            return $validator->validated();
        };

        $validatedDataIKM = $validate([
            'nama_ikm' => 'required|string|max:255',
            'luas' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'komoditi' => 'required|string|max:255',
            'jenis_industri' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nib' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'tenaga_kerja' => 'required|integer|min:0',
        ]);

        if ($validatedDataIKM instanceof \Illuminate\Http\JsonResponse) return $validatedDataIKM;

        $validatedPersentasePemilik = $validate([
            'pemerintah_pusat' => 'required|numeric|min:0|max:100',
            'pemerintah_daerah' => 'required|numeric|min:0|max:100',
            'swasta_nasional' => 'required|numeric|min:0|max:100',
            'asing' => 'required|numeric|min:0|max:100',
        ]);
        if ($validatedPersentasePemilik instanceof \Illuminate\Http\JsonResponse) return $validatedPersentasePemilik;

        $totalPersentase =
            (float) $request->pemerintah_pusat +
            (float) $request->pemerintah_daerah +
            (float) $request->swasta_nasional +
            (float) $request->asing;

        if (round($totalPersentase, 2) !== 100.00) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_pemilik' => 'Total persentase kepemilikan harus 100%.'
                ]
            ]);
        }

        $validatedKaryawan = $validate([
            // Status Tenaga Kerja
            'tenaga_kerja_tetap' => 'required|integer|min:0',
            'tenaga_kerja_tidak_tetap' => 'required|integer|min:0',

            // Gender
            'tenaga_kerja_laki_laki' => 'required|integer|min:0',
            'tenaga_kerja_perempuan' => 'required|integer|min:0',

            // Pendidikan
            'sd' => 'required|integer|min:0',
            'smp' => 'required|integer|min:0',
            'sma_smk' => 'required|integer|min:0',
            'd1_d3' => 'required|integer|min:0',
            's1_d4' => 'required|integer|min:0',
            's2' => 'required|integer|min:0',
            's3' => 'required|integer|min:0',
        ]);
        if ($validatedKaryawan instanceof \Illuminate\Http\JsonResponse) return $validatedKaryawan;

        // 🔎 Cek konsistensi tenaga kerja
        $total = (int) $request->tenaga_kerja;
        $cek = [
            (int) ($request->tenaga_kerja_tetap ?? 0) + (int) ($request->tenaga_kerja_tidak_tetap ?? 0),
            (int) ($request->tenaga_kerja_laki_laki ?? 0) + (int) ($request->tenaga_kerja_perempuan ?? 0),
            (int) ($request->sd ?? 0) + (int) ($request->smp ?? 0) + (int) ($request->sma_smk ?? 0) + (int) ($request->d1_d3 ?? 0) +
                (int) ($request->s1_d4 ?? 0) + (int) ($request->s2 ?? 0) + (int) ($request->s3 ?? 0),
        ];
        if (in_array(false, array_map(fn($x) => $x === $total, $cek), true)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_karyawan' => 'Jumlah tenaga kerja tidak konsisten. Pastikan total status, gender, dan pendidikan sama dengan total.'
                ]
            ]);
        }

        $validatedPemakaianBahan = $validate([
            'nama_bahan' => 'required|array',
            'nama_bahan.*' => 'required|string|max:255',

            'jenis_bahan' => 'required|array',
            'jenis_bahan.*' => 'required|in:Bahan Baku,Bahan Penolong',

            'spesifikasi' => 'required|array',
            'spesifikasi.*' => 'required|string|max:255',

            'kode_hs' => 'required|array',
            'kode_hs.*' => 'required|string|max:255',

            'satuan_standar_bahan' => 'required|array',
            'satuan_standar_bahan.*' => 'required|string|in:kg,ton,liter,ml,m,m2,m3,pcs,drum,nm3',

            'jumlah_dalam_negeri' => 'required|array',
            'jumlah_dalam_negeri.*' => 'required|integer|min:0',

            'nilai_dalam_negeri' => 'required|array',
            'nilai_dalam_negeri.*' => 'required|numeric|min:0',

            'jumlah_impor' => 'required|array',
            'jumlah_impor.*' => 'required|integer|min:0',

            'nilai_impor' => 'required|array',
            'nilai_impor.*' => 'required|numeric|min:0',

            'negara_asal_impor' => 'required|array',
            'negara_asal_impor.*' => 'required|string|max:255',
        ]);
        if ($validatedPemakaianBahan instanceof \Illuminate\Http\JsonResponse) return $validatedPemakaianBahan;

        $bahanFields = [
            'nama_bahan',
            'jenis_bahan',
            'spesifikasi',
            'kode_hs',
            'satuan_standar_bahan',
            'jumlah_dalam_negeri',
            'nilai_dalam_negeri',
            'jumlah_impor',
            'nilai_impor',
            'negara_asal_impor'
        ];

        $panjangPertama = count($request->nama_bahan);
        $semuaSama = collect($bahanFields)->every(function ($field) use ($request, $panjangPertama) {
            return is_array($request->$field) && count($request->$field) === $panjangPertama;
        });

        if (!$semuaSama) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_bahan' => 'Jumlah entri pada kolom pemakaian bahan tidak konsisten. Pastikan semua kolom memiliki jumlah baris yang sama.'
                ]
            ]);
        }

        $validatedPenggunaanAir = $validate([
            'sumber_air' => 'required|string|in:air_permukaan,air_tanah,perusahaan_penyedia_air,air_daur_ulang',
            'banyaknya_penggunaan_m3' => 'required|numeric|min:0.01',
            'biaya' => 'required|numeric|min:0',
        ]);


        $validatedPengeluaran = $validate([
            'upah_gaji' => 'required|numeric|min:0',
            'pengeluaran_industri_distribusi' => 'required|numeric|min:0',
            'pengeluaran_rnd' => 'required|numeric|min:0',
            'pengeluaran_tanah' => 'required|numeric|min:0',
            'pengeluaran_gedung' => 'required|numeric|min:0',
            'pengeluaran_mesin' => 'required|numeric|min:0',
            'lainnya' => 'required|numeric|min:0',
        ]);
        if ($validatedPengeluaran instanceof \Illuminate\Http\JsonResponse) return $validatedPengeluaran;

        $validatedPenggunaanBahanBakar = $validate([
            'jenis_bahan_bakar' => 'required|array',
            'jenis_bahan_bakar.*' => 'required|string|in:bensin,solar_hsd_ado,batubara,briket_batubara,gas_dari_pgn,gas_bukan_dari_pgn,cng,lpg,pelumas',

            'satuan_standar' => 'required|array',
            'satuan_standar.*' => 'required|string|in:liter,ton,mmbtu,kg',

            'banyaknya_proses_produksi' => 'required|array',
            'banyaknya_proses_produksi.*' => 'required|numeric|min:0',

            'nilai_proses_produksi' => 'required|array',
            'nilai_proses_produksi.*' => 'required|numeric|min:0',

            'banyaknya_ptl' => 'required|array',
            'banyaknya_ptl.*' => 'required|numeric|min:0',

            'nilai_ptl' => 'required|array',
            'nilai_ptl.*' => 'required|numeric|min:0',
        ]);
        if ($validatedPenggunaanBahanBakar instanceof \Illuminate\Http\JsonResponse) return $validatedPenggunaanBahanBakar;

        $bakarFields = [
            'jenis_bahan_bakar',
            'satuan_standar',
            'banyaknya_proses_produksi',
            'nilai_proses_produksi',
            'banyaknya_ptl',
            'nilai_ptl'
        ];

        $jumlahData = count($request->jenis_bahan_bakar);
        $semuaKonsisten = collect($bakarFields)->every(function ($field) use ($request, $jumlahData) {
            return is_array($request->$field) && count($request->$field) === $jumlahData;
        });

        if (!$semuaKonsisten) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_bahan_bakar' => 'Mohon lengkapi semua kolom data bahan bakar untuk setiap baris. Setiap entri harus terisi secara lengkap.'
                ]
            ]);
        }

        $validatedListrik = $validate([
            'sumber_listrik' => 'required|string|in:pln,non_pln,pembangkit_sendiri',
            'banyaknya_penggunaan_listrik' => 'required|numeric|min:0',
            'nilai_penggunaan_listrik' => 'required|numeric|min:0',
            'peruntukkan_listrik' => 'required|string|max:255',
        ]);
        if ($validatedListrik instanceof \Illuminate\Http\JsonResponse) return $validatedListrik;

        if (
            (float) $request->banyaknya_penggunaan_listrik > 0 &&
            (float) $request->nilai_penggunaan_listrik === 0.0 &&
            $request->sumber_listrik !== 'pembangkit_sendiri'
        ) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_listrik' => 'Jika terdapat penggunaan listrik, nilai tagihan tidak boleh nol kecuali menggunakan pembangkit sendiri.'
                ]
            ]);
        }

        $validatedMesinProduksi = $validate([
            'jenis_mesin' => 'required|array',
            'jenis_mesin.*' => 'required|string|in:Mesin,Peralatan',

            'nama_mesin' => 'required|array',
            'nama_mesin.*' => 'required|string|max:255',

            'merk_type' => 'required|array',
            'merk_type.*' => 'required|string|max:255',

            'teknologi' => 'required|array',
            'teknologi.*' => 'required|string|max:255',

            'negara_pembuat' => 'required|array',
            'negara_pembuat.*' => 'required|string|max:255',

            'tahun_perolehan' => 'required|array',
            'tahun_perolehan.*' => 'required|integer|min:1900|max:' . date('Y'),

            'tahun_pembuatan' => 'required|array',
            'tahun_pembuatan.*' => 'required|integer|min:1900|max:' . date('Y'),

            'jumlah_unit' => 'required|array',
            'jumlah_unit.*' => 'required|integer|min:1',
        ]);
        if ($validatedMesinProduksi instanceof \Illuminate\Http\JsonResponse) return $validatedMesinProduksi;
        $mesinFields = [
            'jenis_mesin',
            'nama_mesin',
            'merk_type',
            'teknologi',
            'negara_pembuat',
            'tahun_perolehan',
            'tahun_pembuatan',
            'jumlah_unit'
        ];

        $panjangPertama = count($request->jenis_mesin);
        $semuaSama = collect($mesinFields)->every(function ($field) use ($request, $panjangPertama) {
            return is_array($request->$field) && count($request->$field) === $panjangPertama;
        });

        if (!$semuaSama) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_mesin' => 'Jumlah entri pada kolom mesin tidak konsisten. Pastikan semua kolom mesin memiliki jumlah baris yang sama.'
                ]
            ]);
        }

        $validatedProduksi = $validate([
            'jenis_produksi' => 'required|string|max:255',
            'kbli' => 'required|string|max:255',
            'produksi_kode_hs' => 'required|string|max:255',
            'produksi_spesifikasi' => 'required|string|max:255',
            'jumlah_produksi' => 'required|numeric|min:0',
            'nilai_produksi' => 'required|numeric|min:0',
            'satuan' => 'required|string|in:kg,bungkus,biji,ton,buah,liter,galon,dos,balok,meter,set,lusin,potong,lembar,m3,tabung,unit',
            'persentase_ekspor' => 'required|numeric|min:0|max:100',
            'negara_ekspor' => 'nullable|string|max:255',
            'kapasitas_tahun' => 'required|integer|min:0',
        ]);
        if ($validatedProduksi instanceof \Illuminate\Http\JsonResponse) return $validatedProduksi;

        if (
            (float) $request->persentase_ekspor > 0 &&
            empty($request->negara_ekspor)
        ) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'konsistensi_produksi' => 'Anda mengisi ekspor, tapi belum menyebutkan negara tujuan. Mohon isi negara ekspor jika ada kegiatan ekspor.'
                ]
            ]);
        }


        $validatedPersediaan = $validate([
            'jenis_persediaan' => 'required|string|in:persediaan_bahan,setengah_jadi,barang_jadi',
            'awal' => 'required|numeric|min:0',
            'akhir' => 'required|numeric|min:0',
        ]);
        if ($validatedPersediaan instanceof \Illuminate\Http\JsonResponse) return $validatedPersediaan;

        $validatedPendapatan = $validate([
            'sumber' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0',
        ]);
        if ($validatedPendapatan instanceof \Illuminate\Http\JsonResponse) return $validatedPendapatan;

        $validatedModal = $validate([
            'jenis_barang' => 'required|array',
            'jenis_barang.*' => 'required|string|in:tanah,gedung,mesin dan perlengkapan,kendaraan,software/database',

            'pembelian_penambahan_perbaikan' => 'required|array',
            'pembelian_penambahan_perbaikan.*' => 'required|numeric|min:0',

            'pengurangan_barang_modal' => 'required|array',
            'pengurangan_barang_modal.*' => 'required|numeric|min:0',

            'penyusutan_barang' => 'required|array',
            'penyusutan_barang.*' => 'required|numeric|min:0',

            'nilai_taksiran' => 'required|array',
            'nilai_taksiran.*' => 'required|numeric|min:0',
        ]);
        if ($validatedModal instanceof \Illuminate\Http\JsonResponse) return $validatedModal;

        $validatedBentukPengelolaan = $validate([
            'jenis_limbah' => 'required|string|max:255',
            'jumlah_limbah' => 'required|numeric|min:0',

            'jenis_limbah_b3' => 'required|string|max:255',
            'jumlah_limbah_b3' => 'required|numeric|min:0',
            'tps_limbah_b3' => 'nullable|string|max:255',

            'pihak_berizin' => 'nullable|string|max:255',
            'internal_industri' => 'nullable|string|max:255',

            'parameter_limbah_cair' => 'required|string|in:debit_inlet,debit_outlet,cod_inlet,cod_outlet,sludge_removed',
            'jumlah_limbah_cair' => 'required|numeric|min:0',
        ]);
        if ($validatedBentukPengelolaan instanceof \Illuminate\Http\JsonResponse) return $validatedBentukPengelolaan;

        DB::beginTransaction();

        try {
            if ($request->filled('id')) {
                $ikm = \App\Models\DataIKM::find($request->id);
                if ($ikm) {
                    // 🔴 Hapus semua relasi lama untuk mencegah duplikasi saat edit
                    $ikm->karyawan()?->delete();
                    $ikm->persentasePemilik()?->delete();
                    $ikm->pemakaianBahan()->delete();
                    $ikm->penggunaanAir()?->delete();
                    $ikm->pengeluaran()?->delete();
                    $ikm->penggunaanBahanBakar()->delete();
                    $ikm->listrik()?->delete();
                    $ikm->mesinProduksi()->delete();
                    $ikm->produksi()->delete();
                    $ikm->persediaan()->delete();
                    $ikm->pendapatan()->delete();
                    $ikm->modal()->delete();
                    $ikm->bentukPengelolaanLimbah()?->delete();

                    $ikm->update($validatedDataIKM);
                }
            } else {
                $ikm = \App\Models\DataIKM::create($validatedDataIKM);
            }

            if (!isset($ikm) || !$ikm->id) {
                throw new \Exception("Gagal menyimpan Data IKM");
            }

            $idIkm = $ikm->id;

            // ✅ Simpan semua relasi
            $this->savePersentasePemilik($idIkm, $validatedPersentasePemilik);
            $this->saveKaryawan($idIkm, $validatedKaryawan);
            $this->savePemakaianBahan($idIkm, $validatedPemakaianBahan);
            $this->savePenggunaanAir($idIkm, $validatedPenggunaanAir);
            $this->savePengeluaran($idIkm, $validatedPengeluaran);
            $this->savePenggunaanBahanBakar($idIkm, $validatedPenggunaanBahanBakar);
            $this->saveListrik($idIkm, $validatedListrik);
            $this->saveMesinProduksi($idIkm, $validatedMesinProduksi);
            $this->saveProduksi($idIkm, $validatedProduksi);
            $this->savePersediaan($idIkm, $validatedPersediaan);
            $this->savePendapatan($idIkm, $validatedPendapatan);
            $this->saveModal($idIkm, $validatedModal);
            $this->saveBentukPengelolaan($idIkm, $validatedBentukPengelolaan);

            // ✅ Hitung level terakhir dan simpan
            $ikm->level = $ikm->hitungLevel();
            $ikm->save();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => [
                    'msg' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }


    protected function saveDataIKM(array $data)
    {
        return \App\Models\DataIKM::create($data);
    }

    protected function savePersentasePemilik(int $idIkm, array $data)
    {
        return \App\Models\PersentasePemilik::create([
            'id_ikm' => $idIkm,
            'pemerintah_pusat' => $data['pemerintah_pusat'],
            'pemerintah_daerah' => $data['pemerintah_daerah'],
            'swasta_nasional' => $data['swasta_nasional'],
            'asing' => $data['asing'],
        ]);
    }

    protected function saveKaryawan(int $idIkm, array $data)
    {
        \App\Models\Karyawan::where('id_ikm', $idIkm)->delete();
        return \App\Models\Karyawan::create([
            'id_ikm' => $idIkm,

            'tenaga_kerja_tetap' => $data['tenaga_kerja_tetap'],
            'tenaga_kerja_tidak_tetap' => $data['tenaga_kerja_tidak_tetap'],
            'tenaga_kerja_laki_laki' => $data['tenaga_kerja_laki_laki'],
            'tenaga_kerja_perempuan' => $data['tenaga_kerja_perempuan'],

            'sd' => $data['sd'],
            'smp' => $data['smp'],
            'sma_smk' => $data['sma_smk'],
            'd1_d3' => $data['d1_d3'],
            's1_d4' => $data['s1_d4'],
            's2' => $data['s2'],
            's3' => $data['s3'],
        ]);
    }


    protected function savePemakaianBahan(int $idIkm, array $data)
    {
        $count = count($data['nama_bahan']);
        $records = [];

        for ($i = 0; $i < $count; $i++) {
            $records[] = [
                'id_ikm' => $idIkm,
                'nama_bahan' => $data['nama_bahan'][$i],
                'jenis_bahan' => $data['jenis_bahan'][$i],
                'spesifikasi' => $data['spesifikasi'][$i],
                'kode_hs' => $data['kode_hs'][$i],
                'satuan_standar' => $data['satuan_standar_bahan'][$i],
                'jumlah_dalam_negeri' => $data['jumlah_dalam_negeri'][$i],
                'nilai_dalam_negeri' => $data['nilai_dalam_negeri'][$i],
                'jumlah_impor' => $data['jumlah_impor'][$i],
                'nilai_impor' => $data['nilai_impor'][$i],
                'negara_asal_impor' => $data['negara_asal_impor'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return DB::table('pemakaian_bahan')->insert($records);
    }

    protected function savePenggunaanAir(int $idIkm, array $data)
    {
        return DB::table('penggunaan_air')->insert([
            'id_ikm' => $idIkm,
            'sumber_air' => $data['sumber_air'],
            'banyaknya_penggunaan_m3' => $data['banyaknya_penggunaan_m3'],
            'biaya' => $data['biaya'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function savePengeluaran(int $idIkm, array $data)
    {
        return DB::table('pengeluaran')->insert([
            'id_ikm' => $idIkm,
            'upah_gaji' => $data['upah_gaji'],
            'pengeluaran_industri_distribusi' => $data['pengeluaran_industri_distribusi'],
            'pengeluaran_rnd' => $data['pengeluaran_rnd'],
            'pengeluaran_tanah' => $data['pengeluaran_tanah'],
            'pengeluaran_gedung' => $data['pengeluaran_gedung'],
            'pengeluaran_mesin' => $data['pengeluaran_mesin'],
            'lainnya' => $data['lainnya'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function savePenggunaanBahanBakar(int $idIkm, array $data)
    {
        $count = count($data['jenis_bahan_bakar']);
        $records = [];

        for ($i = 0; $i < $count; $i++) {
            $records[] = [
                'id_ikm' => $idIkm,
                'jenis_bahan_bakar' => $data['jenis_bahan_bakar'][$i],
                'satuan_standar' => $data['satuan_standar'][$i],
                'banyaknya_proses_produksi' => (float) $data['banyaknya_proses_produksi'][$i],
                'nilai_proses_produksi' => (int) $data['nilai_proses_produksi'][$i],
                'banyaknya_pembangkit_tenaga_listrik' => (float) $data['banyaknya_ptl'][$i],
                'nilai_pembangkit_tenaga_listrik' => (int) $data['nilai_ptl'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return DB::table('penggunaan_bahan_bakar')->insert($records);
    }

    protected function saveListrik(int $idIkm, array $data)
    {
        return DB::table('listrik')->insert([
            'id_ikm' => $idIkm,
            'sumber' => $data['sumber_listrik'],
            'banyaknya' => (float) $data['banyaknya_penggunaan_listrik'],
            'nilai' => (int) $data['nilai_penggunaan_listrik'],
            'peruntukkan' => $data['peruntukkan_listrik'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function saveMesinProduksi(int $idIkm, array $data)
    {
        $count = count($data['jenis_mesin']);
        $records = [];

        for ($i = 0; $i < $count; $i++) {
            $records[] = [
                'id_ikm' => $idIkm,
                'jenis_mesin' => $data['jenis_mesin'][$i],
                'nama_mesin' => $data['nama_mesin'][$i],
                'merk_type' => $data['merk_type'][$i],
                'teknologi' => $data['teknologi'][$i],
                'negara_pembuat' => $data['negara_pembuat'][$i],
                'tahun_perolehan' => $data['tahun_perolehan'][$i],
                'tahun_pembuatan' => $data['tahun_pembuatan'][$i],
                'jumlah_unit' => $data['jumlah_unit'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return DB::table('mesin_produksi')->insert($records);
    }

    protected function saveProduksi(int $idIkm, array $data)
    {
        return DB::table('produksi')->insert([
            'id_ikm' => $idIkm,
            'jenis_produksi' => $data['jenis_produksi'],
            'kbli' => $data['kbli'],
            'kode_hs' => $data['produksi_kode_hs'],
            'spesifikasi' => $data['produksi_spesifikasi'],
            'banyaknya' => (int) $data['jumlah_produksi'],
            'nilai' => (int) $data['nilai_produksi'],
            'satuan' => $data['satuan'],
            'presentase_produk_ekspor' => (float) $data['persentase_ekspor'],
            'negara_tujuan_ekspor' => $data['negara_ekspor'] ?? null,
            'kapasitas_terpasang_per_tahun' => (int) $data['kapasitas_tahun'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function savePersediaan(int $idIkm, array $data)
    {
        return DB::table('persediaan')->insert([
            'id_ikm' => $idIkm,
            'jenis_persediaan' => $data['jenis_persediaan'],
            'awal' => (int) $data['awal'],
            'akhir' => (int) $data['akhir'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function savePendapatan(int $idIkm, array $data)
    {
        return DB::table('pendapatan')->insert([
            'id_ikm' => $idIkm,
            'nilai' => $data['nilai'],
            'sumber' => $data['sumber'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function saveModal(int $idIkm, array $data)
    {
        $count = count($data['jenis_barang']);
        $records = [];

        for ($i = 0; $i < $count; $i++) {
            $records[] = [
                'id_ikm' => $idIkm,
                'jenis_barang' => $data['jenis_barang'][$i],
                'pembelian_penambahan_perbaikan' => (int) $data['pembelian_penambahan_perbaikan'][$i],
                'pengurangan_barang_modal' => (int) $data['pengurangan_barang_modal'][$i],
                'penyusutan_barang' => (int) $data['penyusutan_barang'][$i],
                'nilai_taksiran' => (int) $data['nilai_taksiran'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return DB::table('modal')->insert($records);
    }

    protected function saveBentukPengelolaan(int $idIkm, array $data)
    {
        return DB::table('bentuk_pengelolaan_limbah')->insert([
            'id_ikm' => $idIkm,
            'jenis_limbah' => $data['jenis_limbah'],
            'jumlah_limbah' => (float) $data['jumlah_limbah'],
            'jenis_limbah_b3' => $data['jenis_limbah_b3'],
            'jumlah_limbah_b3' => (float) $data['jumlah_limbah_b3'],
            'tps_limbah_b3' => $data['tps_limbah_b3'] ?? null,
            'pihak_berizin' => $data['pihak_berizin'] ?? null,
            'internal_industri' => $data['internal_industri'] ?? null,
            'parameter_limbah_cair' => $data['parameter_limbah_cair'],
            'jumlah_limbah_cair' => (float) $data['jumlah_limbah_cair'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    public function showHalal()
    {
        $data = SertifikasiHalal::all();
        return view('admin.bidangIndustri.Halal', compact('data'));
    }

    public function dataHalal()
    {
        return view('user.bidangIndustri.halal');
    }

    public function kelolaSuratt()
    {
        $rekapSurat = $this->getSuratIndustriData();
        $dataSurat = PermohonanSurat::with('user')
            ->whereIn('jenis_surat', ['surat_rekomendasi_industri', 'surat_keterangan_industri'])
            ->whereIn('status', ['menunggu', 'diterima', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.bidangIndustri.kelolaSurat', [
            'dataSurat' => $dataSurat,
            'totalSuratIndustri' => $rekapSurat['totalSuratIndustri'],
            'totalSuratTerverifikasi' => $rekapSurat['totalSuratTerverifikasi'],
            'totalSuratDitolak' => $rekapSurat['totalSuratDitolak'],
            'totalSuratDraft' => $rekapSurat['totalSuratDraft'],
        ]);
    }

    //UNTUK USER INDUSTRI

    public function formPermohonan()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }

        $idUser = session('id_user');

        // Ambil draft permohonan
        $draft = DB::table('form_permohonan')
            ->where('id_user', $idUser)
            ->where('status', 'disimpan')
            ->first();

        $dokumen = null;

        if ($draft) {
            // Ambil dokumen user kalau ada draft
            $dokumen = DB::table('document_user')
                ->where('id_permohonan', $draft->id_permohonan)
                ->first();
        }

        return view('user.bidangIndustri.formPermohonan', [
            'draft' => $draft,
            'dokumen' => $dokumen
        ]);
    }

    public function riwayatSuratt()
    {
        if (!auth()->guard('user')->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }
        $userId = Auth::guard('user')->id();
        $query = PermohonanSurat::where('id_user', $userId)
            ->whereIn('status', ['menunggu', 'diterima', 'ditolak']);

        if ($searchTerm = request('search')) {
            $search = strtolower(trim($searchTerm));

            $mapping = [
                'surat rekomendasi' => 'surat_rekomendasi_industri',
                'rekomendasi' => 'surat_rekomendasi_industri',
                'rek' => 'surat_rekomendasi_industri',
                'surat keterangan' => 'surat_keterangan_industri',
                'keterangan' => 'surat_keterangan_industri',
                'ket' => 'surat_keterangan_industri',
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

        return view('user.bidangIndustri.riwayatSurat', compact('riwayatSurat'));
    }

    // public function ajukanPermohonann(Request $request)
    // {
    //     // Validasi input
    //     $validated = $request->validate([
    //         'jenis_surat' => 'required|in:surat_rekomendasi_industri,surat_keterangan_industri,dan_lainnya_industri',
    //         'kecamatan' => 'required|string',
    //         'kelurahan' => 'required|string',
    //         'titik_koordinat' => 'required|string',
    //         'foto_usaha' => 'required|image|mimes:jpeg,png,jpg|max:10240',
    //         'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:10240',
    //         'dokumen_nib' => 'required|mimes:pdf|max:10240',
    //         'npwp' => 'required|mimes:pdf,jpg,jpeg,png|max:10240',
    //         'akta_perusahaan' => 'required|mimes:pdf|max:10240',
    //         'surat' => 'required|file|mimes:pdf,doc,docx|max:10240',
    //     ]);

    //     try {

    //         $idUser = session('id_user');

    //         // Cek apakah ada draft
    //         $draft = DB::table('form_permohonan')
    //             ->where('id_user', $idUser)
    //             ->where('status', 'draft')
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if($draft) {

    //             // Jika ada draft, update data & simpan file
    //             $fotoUsahaPath = $request->file('foto_usaha')->store('DokumentUser', 'public');
    //             $fotoKTPPath = $request->file('foto_ktp')->store('DokumentUser', 'public');
    //             $dokumenNibPath = $request->file('dokumen_nib')->store('DokumentUser', 'public');
    //             $npwpPath = $request->file('npwp')->store('DokumentUser', 'public');
    //             $aktaPerusahaanPath = $request->file('akta_perusahaan')->store('DokumentUser', 'public');
    //             $fileSuratPath = $request->file('surat')->store('DokumentUser', 'public');

    //             // Simpan ke tabel form_permohonan
    //             DB::table('form_permohonan')
    //                 ->where('id_permohonan', $draft->id_permohonan)
    //                 ->update([
    //                     'kecamatan' => $request->kecamatan,
    //                     'kelurahan' => $request->kelurahan,
    //                     'tgl_pengajuan' => now()->toDateString(),
    //                     'jenis_surat' => $request->jenis_surat,
    //                     'titik_koordinat' => $request->titik_koordinat,
    //                     'file_surat' => $fileSuratPath,
    //                     'status' => 'menunggu',
    //                     'updated_at' => now(),
    //                 ]);

    //             // Simpan ke tabel document_user
    //             DB::table('document_user')
    //                 ->where('id_permohonan', $draft)
    //                 ->update([
    //                 'npwp' => $npwpPath,
    //                 'akta_perusahaan' => $aktaPerusahaanPath,
    //                 'foto_ktp' => $fotoKTPPath,
    //                 'foto_usaha' => $fotoUsahaPath,
    //                 'dokument_nib' => $dokumenNibPath,
    //                 'updated_at' => now(),
    //             ]);

    //     } else {
    //         // Kalau tidak ada draft, buat permohonan baru

    //         $fotoUsahaPath = $request->file('foto_usaha')->store('DokumentUser', 'public');
    //         $fotoKTPPath = $request->file('foto_ktp')->store('DokumentUser', 'public');
    //         $dokumenNibPath = $request->file('dokumen_nib')->store('DokumentUser', 'public');
    //         $npwpPath = $request->file('npwp')->store('DokumentUser', 'public');
    //         $aktaPerusahaanPath = $request->file('akta_perusahaan')->store('DokumentUser', 'public');
    //         $fileSuratPath = $request->file('surat')->store('DokumentUser', 'public');

    //         $idPermohonan = Str::uuid()->toString();

    //         DB::table('form_permohonan')->insert([
    //             'id_permohonan' => $idPermohonan,
    //             'id_user' => $idUser,
    //             'kecamatan' => $request->kecamatan,
    //             'kelurahan' => $request->kelurahan,
    //             'tgl_pengajuan' => now()->toDateString(),
    //             'jenis_surat' => $request->jenis_surat,
    //             'titik_koordinat' => $request->titik_koordinat,
    //             'file_surat' => $fileSuratPath,
    //             'status' => 'menunggu',
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         DB::table('document_user')->insert([
    //             'id_permohonan' => $idPermohonan,
    //             'npwp' => $npwpPath,
    //             'akta_perusahaan' => $aktaPerusahaanPath,
    //             'foto_ktp' => $fotoKTPPath,
    //             'foto_usaha' => $fotoUsahaPath,
    //             'dokument_nib' => $dokumenNibPath,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //     }

    //     return redirect()->route('bidangIndustri.riwayatSurat')
    //         ->with('success', 'Pengajuan surat berhasil diajukan.');
    //     } catch (Exception $e) {
    //         Log::error('Gagal mengajukan surat: ' . $e->getMessage());
    //         return redirect()->back()->withInput()->with('error', $e->getMessage()); // hanya untuk dev
    //     }
    // }

    public function ajukanPermohonann(Request $request)
    {
        // Generate UUID untuk id_permohonan
        $idPermohonan = Str::uuid()->toString();

        $idUser = session('id_user');

        // Ambil draft terakhir user
        $draft = DB::table('form_permohonan')
            ->where('id_user', $idUser)
            ->where('status', 'disimpan')
            ->orderBy('created_at', 'desc')
            ->first();

        $dokumen = $draft ? DB::table('document_user')->where('id_permohonan', $draft->id_permohonan)->first() : null;

        // Validasi dinamis
        $rules = [
            'jenis_surat' => 'required|in:surat_rekomendasi_industri,surat_keterangan_industri',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'titik_koordinat' => 'required|string',
            'foto_usaha' => ($dokumen && $dokumen->foto_usaha) ? 'nullable|image|mimes:jpeg,png,jpg|max:512' : 'required|image|mimes:jpeg,png,jpg|max:512',
            'foto_ktp' => ($dokumen && $dokumen->foto_ktp) ? 'nullable|image|mimes:jpeg,png,jpg|max:512' : 'required|image|mimes:jpeg,png,jpg|max:512',
            'dokumen_nib' => ($dokumen && $dokumen->dokument_nib) ? 'nullable|mimes:pdf|max:512' : 'required|mimes:pdf|max:512',
            'npwp' => ($dokumen && $dokumen->npwp) ? 'nullable|mimes:pdf,jpg,jpeg,png|max:512' : 'required|mimes:pdf,jpg,jpeg,png|max:512',
            'akta_perusahaan' => ($dokumen && $dokumen->akta_perusahaan) ? 'nullable|mimes:pdf|max:512' : 'required|mimes:pdf|max:512',
            'surat' => ($draft && $draft->file_surat) ? 'nullable|file|mimes:pdf,doc,docx|max:512' : 'required|file|mimes:pdf,doc,docx|max:512',
        ];

        $messages = [
            'jenis_surat.required' => 'Jenis surat wajib diisi.',
            'jenis_surat.in' => 'Jenis surat tidak valid.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kelurahan.required' => 'Kelurahan wajib diisi.',
            'titik_koordinat.required' => 'Titik koordinat wajib diisi.',
            'foto_usaha.required' => 'Foto usaha wajib diunggah.',
            'foto_usaha.image' => 'Foto usaha harus berupa gambar.',
            'foto_usaha.mimes' => 'Foto usaha harus berformat jpeg, png, atau jpg.',
            'foto_usaha.max' => 'Ukuran foto usaha tidak boleh lebih dari 512 kilobyte.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.image' => 'Foto KTP harus berupa gambar.',
            'foto_ktp.mimes' => 'Foto KTP harus berformat jpeg, png, atau jpg.',
            'foto_ktp.max' => 'Ukuran foto KTP tidak boleh lebih dari 512 KILOBYTE.',
            'dokumen_nib.required' => 'Dokumen NIB wajib diunggah.',
            'dokumen_nib.mimes' => 'Dokumen NIB harus berformat PDF.',
            'dokumen_nib.max' => 'Ukuran dokumen NIB tidak boleh lebih dari 512 KILOBYTE.',
            'npwp.required' => 'Dokumen NPWP wajib diunggah.',
            'npwp.mimes' => 'NPWP harus berformat PDF atau gambar.',
            'npwp.max' => 'Ukuran dokumen NPWP tidak boleh lebih dari 512 KILOBYTE.',
            'akta_perusahaan.required' => 'Akta perusahaan wajib diunggah.',
            'akta_perusahaan.mimes' => 'Akta perusahaan harus berformat PDF.',
            'akta_perusahaan.max' => 'Ukuran akta perusahaan tidak boleh lebih dari 512 KILOBYTE.',
            'surat.required' => 'File surat wajib diunggah.',
            'surat.mimes' => 'File surat harus berformat PDF, DOC, atau DOCX.',
            'surat.max' => 'Ukuran file surat tidak boleh lebih dari 512 KILOBYTE.',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            // Update file hanya jika user upload ulang
            $fotoUsahaPath = $request->hasFile('foto_usaha') ? $request->file('foto_usaha')->store('DokumentUser', 'public') : $dokumen->foto_usaha;
            $fotoKTPPath = $request->hasFile('foto_ktp') ? $request->file('foto_ktp')->store('DokumentUser', 'public') : $dokumen->foto_ktp;
            $dokumenNibPath = $request->hasFile('dokumen_nib') ? $request->file('dokumen_nib')->store('DokumentUser', 'public') : $dokumen->dokument_nib;
            $npwpPath = $request->hasFile('npwp') ? $request->file('npwp')->store('DokumentUser', 'public') : $dokumen->npwp;
            $aktaPerusahaanPath = $request->hasFile('akta_perusahaan') ? $request->file('akta_perusahaan')->store('DokumentUser', 'public') : $dokumen->akta_perusahaan;
            $fileSuratPath = $request->hasFile('surat') ? $request->file('surat')->store('DokumentUser', 'public') : $draft->file_surat;

            // Kalau tidak ada draft → insert baru
            if (!$draft) {
                DB::table('form_permohonan')->insert([
                    'id_permohonan' => $idPermohonan,
                    'id_user' => $idUser,
                    'jenis_surat' => $request->jenis_surat,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'titik_koordinat' => $request->titik_koordinat,
                    'file_surat' => $fileSuratPath,
                    'status' => 'menunggu',
                    'tgl_pengajuan' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('document_user')->insert([
                    'id_permohonan' => $idPermohonan,
                    'foto_usaha' => $fotoUsahaPath,
                    'foto_ktp' => $fotoKTPPath,
                    'dokument_nib' => $dokumenNibPath,
                    'npwp' => $npwpPath,
                    'akta_perusahaan' => $aktaPerusahaanPath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Update form_permohonan
                DB::table('form_permohonan')->where('id_permohonan', $draft->id_permohonan)->update([
                    'jenis_surat' => $request->jenis_surat,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'titik_koordinat' => $request->titik_koordinat,
                    'file_surat' => $fileSuratPath,
                    'status' => 'menunggu',
                    'tgl_pengajuan' => now(),
                    'updated_at' => now(),
                ]);

                // Update dokumen
                DB::table('document_user')->where('id_permohonan', $draft->id_permohonan)->update([
                    'foto_usaha' => $fotoUsahaPath,
                    'foto_ktp' => $fotoKTPPath,
                    'dokument_nib' => $dokumenNibPath,
                    'npwp' => $npwpPath,
                    'akta_perusahaan' => $aktaPerusahaanPath,
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('bidangIndustri.riwayatSurat')->with('success', 'Pengajuan surat berhasil diajukan.');
        } catch (Exception $e) {
            Log::error("Gagal mengajukan permohonan: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function viewSuratBalasan($id)
    {
        $file = DB::table('form_permohonan')->where('id_permohonan', $id)->value('file_surat');

        if (!$file || !Storage::disk('public')->exists($file)) {
            return abort(404, 'Surat balasan tidak ditemukan.');
        }

        return response()->file(storage_path("app/public/{$file}"));
    }

    public function downloadSuratBalasan($id)
    {
        $file = DB::table('form_permohonan')->where('id_permohonan', $id)->value('file_surat');

        if (!$file || !Storage::disk('public')->exists($file)) {
            return abort(404, 'Surat balasan tidak ditemukan.');
        }

        return response()->download(storage_path("app/public/{$file}"));
    }

    public function draftPermohonann(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_surat' => 'required|in:surat_rekomendasi_industri,surat_keterangan_industri,dan_lainnya_industri',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'titik_koordinat' => 'required|string',
            'foto_usaha' => 'required|image|mimes:jpeg,png,jpg|max:512',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:512',
            'dokumen_nib' => 'required|mimes:pdf|max:512',
            'npwp' => 'required|mimes:pdf,jpg,jpeg,png|max:512',
            'akta_perusahaan' => 'required|mimes:pdf|max:512',
            'surat' => 'required|file|mimes:pdf,doc,docx|max:512',
        ]);

        try {
            // Simpan file satu per satu
            $fotoUsahaPath = $request->file('foto_usaha')->store('DokumentUser', 'public');
            $fotoKTPPath = $request->file('foto_ktp')->store('DokumentUser', 'public');
            $dokumenNibPath = $request->file('dokumen_nib')->store('DokumentUser', 'public');
            $npwpPath = $request->file('npwp')->store('DokumentUser', 'public');
            $aktaPerusahaanPath = $request->file('akta_perusahaan')->store('DokumentUser', 'public');
            $fileSuratPath = $request->file('surat')->store('DokumentUser', 'public');

            // Buat id_permohonan unik
            $idPermohonan = Str::uuid()->toString();

            // Ambil id_user dari session
            $idUser = session('id_user');

            // Simpan ke tabel form_permohonan
            DB::table('form_permohonan')->insert([
                'id_permohonan' => $idPermohonan,  // Masukkan UUID yang baru dibuat
                'id_user' => $idUser,  // Ambil id_user dari session
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'tgl_pengajuan' => now()->toDateString(),
                'jenis_surat' => $request->jenis_surat,
                'titik_koordinat' => $request->titik_koordinat,
                'file_surat' => $fileSuratPath,
                'status' => 'disimpan',
                'created_at' => now(),
            ]);

            // Simpan ke tabel document_user
            DB::table('document_user')->insert([
                'id_permohonan' => $idPermohonan,  // Masukkan id_permohonan yang sama ke document_user
                'npwp' => $npwpPath,
                'akta_perusahaan' => $aktaPerusahaanPath,
                'foto_ktp' => $fotoKTPPath,
                'foto_usaha' => $fotoUsahaPath,
                'dokument_nib' => $dokumenNibPath,
                'created_at' => now(),
            ]);

            //     return redirect()->route('bidangIndustri.riwayatSurat')
            //         ->with('success', 'Pengajuan surat berhasil diajukan.');
        } catch (Exception $e) {
            Log::error('Gagal mengajukan surat: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage()); // hanya untuk dev
        }
    }

    public function showSurat()
    {
        return view('admin.bidangIndustri.suratBalasan');
    }
}
