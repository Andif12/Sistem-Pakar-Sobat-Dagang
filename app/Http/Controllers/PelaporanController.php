<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Models\RencanaKebutuhanDistributor;
use App\Models\Toko;
use Carbon\Carbon;
use App\Models\StokOpname;
use App\Models\PengaduanDistributor;
use Illuminate\Support\Facades\Auth;

class PelaporanController extends Controller
{
    public function pelaporanPenyaluran()
    {
        return view('user.bidangPerdagangan.pelaporan_penyaluran');
    }

    public function index(Request $request)
    {
        $userId = session('id_user');
        $distributor = Distributor::where('id_user', $userId)->first();

        if (!$distributor) return redirect()->route('pelaporan-penyaluran');
        if ($distributor->status === 'menunggu' || $distributor->status === 'ditolak') {
            return redirect()->route('cekpengajuan');
        }
        $tokoview = Toko::where('id_distributor', $distributor->id_distributor)->get();
        $tokos = Toko::where('id_distributor', $distributor->id_distributor)->paginate(3);

        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $tokoId = $request->input('toko');

        $query = StokOpname::where('id_distributor', $distributor->id_distributor)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if (!empty($tokoId)) {
            $query->where('id_toko', $tokoId);
        }

        $stokOpnames = $query->get();

        $dataByMinggu = [];
        $mingguBelumTerisi = []; // Menampung info minggu kosong per barang

        foreach ($stokOpnames as $record) {
            $day = \Carbon\Carbon::parse($record->tanggal)->day;
            $minggu = match (true) {
                $day >= 1 && $day <= 7 => 1,
                $day >= 8 && $day <= 14 => 2,
                $day >= 15 && $day <= 21 => 3,
                default => 4,
            };

            $nama_barang = $record->nama_barang;

            $dataByMinggu[$nama_barang]['minggu_' . $minggu] = [
                'stok_awal' => $record->stok_awal,
                'penyaluran' => $record->penyaluran,
                'stok_akhir' => $record->stok_akhir,
            ];
        }

        foreach ($dataByMinggu as $nama_barang => &$mingguData) {
            for ($i = 1; $i <= 4; $i++) {
                $key = 'minggu_' . $i;
                if (!isset($mingguData[$key])) {
                    $mingguData[$key] = ['stok_awal' => '-', 'penyaluran' => '-', 'stok_akhir' => '-'];
                    $mingguBelumTerisi[$nama_barang][] = $i; // Simpan minggu yang kosong
                }
            }
            ksort($mingguData);
        }
        $user = Auth::guard('user')->user();
        // dd(Auth::guard('user')->user());

        return view('user.bidangPerdagangan.pelaporan', [
            'tokoview' => $tokoview,
            'tokos' => $tokos,
            'dataByMinggu' => $dataByMinggu,
            'mingguBelumTerisi' => $mingguBelumTerisi,
            'user' => $user,
        ]);
    }

    public function verifikasiPengajuan()
    {
        // Ambil id_user dari session
        $id_user = Session::get('id_user');

        // Ambil data status dari tabel distributor
        $distributor = DB::table('distributor')
                        ->where('id_user', $id_user)
                        ->orderByDesc('created_at') // kalau ada lebih dari 1 data
                        ->first();

        // Jika tidak ditemukan
        if (!$distributor) {
            return redirect()->back()->with('error', 'Data distributor tidak ditemukan.');
        }

        // Kirim status ke blade
        $status = strtolower($distributor->status); // jadi 'menunggu', 'diterima', atau 'ditolak'
        return view('user.bidangPerdagangan.verifikasiPengajuan', compact('status'));
    }

    public function formDistributor()
    {
        return view('user.bidangPerdagangan.daftarDistributor');
    }

    public function submitDistributor(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'dokumen_nib' => 'required|file|mimes:pdf|max:51200',
            ]);

            // Ambil ID pengguna dari session
            $userId = session('id_user');

            if (!$userId) {
                return redirect()->back()->with('error', 'User tidak ditemukan dalam sesi.');
            }

            // Upload file
            $file = $request->file('dokumen_nib');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('nib_dokumen', $fileName, 'public');

            // Perbarui data jika id_user sudah ada, atau buat baru jika belum
            Distributor::updateOrCreate(
                ['id_user' => $userId], // Kondisi
                ['nib' => $path, 'status' => 'Menunggu'] // Data yang akan diupdate/ditambahkan
            );

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reviewPengajuanDistributor()
{
    $distributor = Distributor::with('user')->latest()->get(); // mengambil semua data termasuk user
    return view('admin.adminSuper.reviewPengajuanDistributor', compact('distributor'));
}


    public function indexDistributor()
    {
        $distributor = Distributor::with('user')->latest()->get();
        return view('admin.distributor.index', compact('distributor'));
    }

    public function verifikasiDistributor(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:Disetujui,Ditolak',
    ]);

    $distributor = Distributor::findOrFail($id);
    $distributor->status = $request->status;
    $distributor->save();

    return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function lihatLaporan()
    {
        return view('admin.adminSuper.lihatLaporan');
    }

    public function tambahBarangDistribusi()
    {
        return view('admin.adminSuper.tambahBarangDistribusi');
    }
    public function setujui($id_distributor)
    {
        $distributor = Distributor::findOrFail($id_distributor);
        $distributor->status = 'diterima';
        $distributor->save();

        return redirect()->back()->with('success', 'Distributor disetujui.');
    }

    public function tolak($id_distributor)
    {
        $distributor = Distributor::findOrFail($id_distributor);
        $distributor->status = 'ditolak';
        $distributor->save();

        return redirect()->back()->with('success', 'Distributor ditolak.');
    }
    public function hapus($id_distributor)
    {
        DB::table('distributor')->where('id_distributor', $id_distributor)->delete();

        return redirect()->back()->with('success', 'Distributor berhasil dihapus.');
    }

    public function inputDataToko(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'no_register' => 'required|string|max:100',
            'rencana_kebutuhan' => 'required|numeric',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ]);

        try {
            DB::beginTransaction();

            // Ambil id_user dari session
            $id_user = session('id_user');
            if (!$id_user) {
                return back()->with('error', 'User belum login.');
            }

            // Cari distributor berdasarkan id_user
            $distributor = \App\Models\Distributor::where('id_user', $id_user)->first();

            if (!$distributor) {
                return back()->with('error', 'Distributor untuk user ini tidak ditemukan.');
            }

            // Simpan ke rencana_kebutuhan_distributor
            $rencana = RencanaKebutuhanDistributor::create([
                'jumlah' => $request->input('rencana_kebutuhan'),
                'tahun' => $request->input('tahun'),
                'id_barang_pelaporan' => null,
            ]);

            // Simpan ke tabel toko dengan foreign key ke rencana kebutuhan dan distributor
            Toko::create([
                'id_rancangan' => $rencana->id_rancangan,
                'id_distributor' => $distributor->id_distributor,
                'nama_toko' => $request->input('nama_toko'),
                'kecamatan' => $request->input('kecamatan'),
                'no_register' => $request->input('no_register'),
            ]);

            DB::commit();
            return back()->with('success', 'Data toko dan rencana kebutuhan berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function showForm()    {
        return view('user.bidangPerdagangan.inputDataToko');
    }
    public function inputDataDistribusi(Request $request)
    {
        $userId = session('id_user');
        $distributor = Distributor::where('id_user', $userId)->first();

        if (!$distributor) {
            return redirect()->back()->with('error', 'Distributor tidak ditemukan.');
        }

        $request->validate([
            'id_toko' => 'required|exists:toko,id_toko',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer|min:0',
            'penyaluran' => 'required|integer|min:0',
            'tanggal_input' => 'required|date',
        ]);

        $tanggalInput = Carbon::parse($request->tanggal_input);
        $mingguInput = $this->getMingguKe($tanggalInput);

        // Ambil semua entri sebelumnya (bulan yang sama) untuk kombinasi distributor + toko + barang
        $entriesThisMonth = StokOpname::where('id_distributor', $distributor->id_distributor)
            ->where('id_toko', $request->id_toko)
            ->where('nama_barang', $request->nama_barang)
            ->whereYear('tanggal', $tanggalInput->year)
            ->whereMonth('tanggal', $tanggalInput->month)
            ->get();

        // Hitung minggu keberapa saja yang sudah diinput
        $mingguSudahDiisi = $entriesThisMonth->map(function ($entry) {
            return $this->getMingguKe($entry->tanggal);
        })->unique()->sort()->values();

        if ($mingguSudahDiisi->isEmpty()) {
            // Pertama kali input: hanya boleh minggu ke-1
            if ($mingguInput !== 1) {
                return redirect()->route('pelaporan.showDataDistribusi', ['id_toko' => $request->id_toko])
                    ->with('error', 'Input data pertama hanya diizinkan pada minggu ke-1 (tanggal 1–7). Tanggal yang Anda pilih: ' . $tanggalInput->format('d M Y'));
            }
        } else {
            $mingguTerakhir = $mingguSudahDiisi->last();

            if ($mingguSudahDiisi->contains($mingguInput)) {
                return redirect()->route('pelaporan.showDataDistribusi', ['id_toko' => $request->id_toko])
                    ->with('error', "Anda sudah mengisi data distribusi untuk minggu ke-{$mingguInput} bulan ini.");
            }

            if ($mingguInput > $mingguTerakhir + 1) {
                return redirect()->route('pelaporan.showDataDistribusi', ['id_toko' => $request->id_toko])
                    ->with('error', "Anda belum mengisi data distribusi untuk minggu ke-" . ($mingguTerakhir + 1) . ". Harap lengkapi terlebih dahulu.");
            }
        }

        // Perhitungan stok
        $stokAwal = $request->stok;
        $penyaluran = $request->penyaluran;
        $stokAkhir = $stokAwal - $penyaluran;

        // Simpan ke database
        StokOpname::create([
            'id_distributor' => $distributor->id_distributor,
            'id_toko' => $request->id_toko,
            'stok_awal' => $stokAwal,
            'penyaluran' => $penyaluran,
            'stok_akhir' => $stokAkhir,
            'tanggal' => $tanggalInput->toDateString(),
            'nama_barang' => $request->nama_barang,
        ]);

        return redirect()->route('pelaporan.showDataDistribusi', ['id_toko' => $request->id_toko])
            ->with('success', 'Data distribusi berhasil ditambahkan.');
    }

// Fungsi untuk menentukan minggu keberapa berdasarkan tanggal
    private function getMingguKe($tanggal)
    {
        $day = Carbon::parse($tanggal)->day;

        if ($day >= 1 && $day <= 7) {
            return 1;
        } elseif ($day >= 8 && $day <= 14) {
            return 2;
        } elseif ($day >= 15 && $day <= 21) {
            return 3;
        } else {
            return 4;
        }
    }

    public function storePengaduanDistributor(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);
        
        $userId = Auth::guard('user')->id();

        PengaduanDistributor::create([
            'user_id' => $userId,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Pengaduan distributor berhasil dikirim.');
}

    public function showDataDistribusi($id_toko)
    {
        // Cari data toko berdasarkan id
        $toko = Toko::findOrFail($id_toko);

        // Kirim data toko ke view form input data distribusi
        return view('user.bidangPerdagangan.inputDataDistribusi', [
            'toko' => $toko
        ]);
    }

    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);
        $toko->delete();

        return redirect()->back()->with('success', 'Toko berhasil dihapus.');
    }

    public function indexPengaduan(){
        $pengaduan = \App\Models\PengaduanDistributor::with('user')->latest()->get();
        return view('admin.bidangPerdagangan.pengaduanDistributor', compact('pengaduan'));
    }

    public function tandaiSelesai($id){
        $pengaduan = \App\Models\PengaduanDistributor::findOrFail($id);
        $pengaduan->status = 'selesai';
        $pengaduan->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

}