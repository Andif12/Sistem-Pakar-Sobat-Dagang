<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
            // Ambil id_user dari session
        $idUser = $request->session()->get('id_user');

        if (!$idUser) {
            // Jika tidak ada id_user di session, redirect ke halaman login atau halaman lain
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data user dari database berdasarkan id_user
        $user = User::find($idUser);

        if (!$user) {
            // Jika user tidak ditemukan, redirect ke login juga atau bisa tampilkan halaman error
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        // Kirim data user ke view 'user.dashboard'
        return view('user.dashboard', ['user' => $user]);
    }

    public function profile()
    {
        return view('component.profile');
    }

    public function kelolaAdmin()
    {
        // Mendapatkan semua data pengguna
        $users = User::all();
        
        // Mengirimkan data $users ke view 'admin.adminSuper.kelolaAdmin'
        return view('admin.adminSuper.kelolaAdmin', compact('users'));
    }


    // Proses update data profil
    // public function updateProfile(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'kabupaten' => 'required|string',
    //         'kecamatan' => 'nullable|string',
    //         'kelurahan' => 'nullable|string',
    //         'alamat_lengkap' => 'nullable|string',
    //         'email' => 'required|email',
    //         'telp' => 'nullable|string|max:20',
    //         'nib' => 'nullable|string|max:30',
    //         'nik' => 'nullable|string|max:16',
    //         'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
    //     ]);

    //     $user = Auth::user();
    //     $user->fill([
    //         'nama' => $request->input('nama'),
    //         'kabupaten' => $request->input('kabupaten'),
    //         'kecamatan' => $request->input('kecamatan'),
    //         'kelurahan' => $request->input('kelurahan'),
    //         'alamat_lengkap' => $request->input('alamat_lengkap'),
    //         'email' => $request->input('email'),
    //         'telp' => $request->input('telp'),
    //         'nib' => $request->input('nib'),
    //         'nik' => $request->input('nik'),
    //         'jenis_kelamin' => $request->input('jenis_kelamin'),
    //     ]);
        
    //     if ($user->save()) {
    //         return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    //     } else {
    //         return redirect()->route('profile')->with('error', 'Gagal memperbarui profil.');
    //     }
    // }  
    
    // Menambah pengguna baru
    public function tambahPengguna(Request $request)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Validasi email unik
            'password' => 'required|string|min:8|confirmed', // Validasi password dan konfirmasi password
            'role' => 'required|string|in:admin,user', // Validasi role (hanya admin atau user)
        ]);

        // Menyimpan pengguna baru ke dalam database
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password sebelum disimpan
            'role' => $request->role,
        ]);

        // Redirect setelah berhasil menambahkan pengguna
        return redirect()->route('kelola.pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Mengupdate data pengguna
    public function update(Request $request, $id_pengguna)
    {
        // Validasi input yang diterima dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string|in:admin,user', // Validasi role
        ]);

        $user = User::findOrFail($id_pengguna);

        // Mengupdate data pengguna
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('kelola.pengguna')->with('success', 'Pengguna berhasil diupdate');
    }

    // Menghapus pengguna
    public function destroy($id_pengguna)
    {
        $user = User::findOrFail($id_pengguna);
        $user->delete();

        return redirect()->route('kelola.pengguna')->with('success', 'Pengguna berhasil dihapus');
    }

    public function dashboardMaster()    {
        $totalDistributor = DB::table('distributor')
            ->where('status', 'diterima')
            ->count();
        $totalPengaduan = DB::table('forum_diskusi')
            ->whereNotNull('id_user')
            ->count();
        $totalPengguna = DB::table('user')->count();
        $totalKomoditas = DB::table('data_ikm')->count();

        $totalPermohonan = DB::table('form_permohonan')
            ->where('status', '!=', 'disimpan')
            ->count() 
            + DB::table('surat_metrologi')->count();

        $permohonanPerdagangan = DB::table('form_permohonan')
        ->where('form_permohonan.status', '!=', 'disimpan')
        ->join('user', 'form_permohonan.id_user', '=', 'user.id_user')
        ->select(
            DB::raw('DATE_FORMAT(form_permohonan.tgl_pengajuan, "%d-%m-%Y") as tanggal'),
            'user.nama as nama_pengirim',
            DB::raw('CASE
                WHEN form_permohonan.jenis_surat LIKE "%perdagangan%" THEN "Perdagangan"
                WHEN form_permohonan.jenis_surat LIKE "%industri%" THEN "Industri"
                ELSE "Perdagangan"
            END as bidang_terkait'),
            DB::raw('CASE
                WHEN form_permohonan.status = "menunggu" THEN "Menunggu"
                WHEN form_permohonan.status = "diterima" THEN "Disetujui"
                WHEN form_permohonan.status = "ditolak" THEN "Ditolak"
                ELSE form_permohonan.status
            END as status')
        );

        $permohonanMetrologi = DB::table('surat_metrologi')
            ->join('user', 'surat_metrologi.user_id', '=', 'user.id_user')
            ->select(
                DB::raw('DATE_FORMAT(surat_metrologi.created_at, "%d-%m-%Y") as tanggal'),
                'user.nama as nama_pengirim',
                DB::raw('"Metrologi" as bidang_terkait'),
                'surat_metrologi.status_surat_masuk as status'
            );

        $unionQuery = $permohonanPerdagangan->unionAll($permohonanMetrologi);

        $permohonan = DB::table(DB::raw("({$unionQuery->toSql()}) as sub"))
            ->mergeBindings($permohonanPerdagangan)
            ->orderByRaw('STR_TO_DATE(tanggal, "%d-%m-%Y") desc')
            ->get();

        $countsPerMonth = [];

        foreach ($permohonan as $item) {
            // parsing tanggal "dd-mm-yyyy" ke Carbon
            $date = Carbon::createFromFormat('d-m-Y', $item->tanggal);
            $month = $date->format('Y-m'); // contoh "2025-05"

            if (!isset($countsPerMonth[$month])) {
                $countsPerMonth[$month] = 0;
            }
            $countsPerMonth[$month]++;
        }

        // Sortir berdasarkan bulan ascending
        ksort($countsPerMonth);

        // Pisahkan keys dan values jadi array untuk Chart.js
        $labelsPermohonan = array_keys($countsPerMonth);
        $dataPermohonan = array_values($countsPerMonth);


        // Inisialisasi status akhir
        $statusCounts = [
            'Menunggu' => 0,
            'Disetujui' => 0,
            'Ditolak' => 0,
        ];

        // Ambil status dari surat_metrologi
        $metrologi = DB::table('surat_metrologi')
            ->select('status_surat_masuk', DB::raw('count(*) as total'))
            ->whereIn('status_surat_masuk', ['Menunggu', 'Disetujui', 'Ditolak'])
            ->groupBy('status_surat_masuk')
            ->pluck('total', 'status_surat_masuk');

        foreach ($metrologi as $status => $total) {
            $statusCounts[$status] += $total;
        }

        // Mapping status dari form_permohonan ke format standar
        $statusMap = [
            'menunggu' => 'Menunggu',
            'diterima' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        $form_permohonan = DB::table('form_permohonan')
            ->select('status', DB::raw('count(*) as total'))
            ->whereIn('status', ['menunggu', 'diterima', 'ditolak'])
            ->groupBy('status')
            ->pluck('total', 'status');

        foreach ($form_permohonan as $status => $total) {
            if (isset($statusMap[$status])) {
                $mappedStatus = $statusMap[$status];
                $statusCounts[$mappedStatus] += $total;
            }
        }


        return view('admin.adminSuper.dashboardMaster', compact(
            'totalDistributor',
            'totalPengaduan',
            'totalPengguna',
            'totalKomoditas',
            'totalPermohonan',
            'permohonan',
            'statusCounts',
            'labelsPermohonan',
            'dataPermohonan'
        ));
    }
    

    public function detailPermohonan($id, $bidang)
    {
        // Decode the ID parameter
        $decodedId = base64_decode($id);
        
        if ($bidang === 'metrologi') {
            $permohonan = DB::table('surat_metrologi')
                ->join('user', 'surat_metrologi.user_id', '=', 'user.id_user')
                ->leftJoin('surat_keluar_metrologi', 'surat_metrologi.id_surat', '=', 'surat_keluar_metrologi.id_surat')
                ->where('surat_metrologi.id_surat', $decodedId)
                ->select(
                    'surat_metrologi.*',
                    'user.nama as nama_pengirim',
                    'surat_keluar_metrologi.path_dokumen as file_balasan',
                    'surat_keluar_metrologi.isi_surat as isi_balasan'
                )
                ->first();
        } else {
            $permohonan = DB::table('form_permohonan')
                ->join('user', 'form_permohonan.id_user', '=', 'user.id_user')
                ->where('form_permohonan.id_permohonan', $decodedId)
                ->select('form_permohonan.*', 'user.nama as nama_pengirim')
                ->first();
        }

        if (!$permohonan) {
            abort(404);
        }

        return view('admin.adminSuper.detailPermohonan', compact('permohonan', 'bidang'));
    }

    public function downloadBalasan($id, $bidang)
    {
        if ($bidang === 'metrologi') {
            $balasan = DB::table('surat_keluar_metrologi')
                ->where('id_surat', $id)
                ->first();

            if (!$balasan || !$balasan->path_dokumen) {
                abort(404);
            }

            return Storage::disk('public')->download($balasan->path_dokumen);
        } else {
            $balasan = DB::table('form_permohonan')
                ->where('id_permohonan', $id)
                ->first();

            if (!$balasan || !$balasan->file_balasan) {
                abort(404);
            }

            return Storage::disk('public')->download($balasan->file_balasan);
        }
    }

    public function daftarPermohonan()
    {
        // Get permohonan data from both tables
        $permohonanPerdagangan = DB::table('form_permohonan')
            ->where('status', '!=', 'disimpan')
            ->join('user', 'form_permohonan.id_user', '=', 'user.id_user')
            ->select(
                DB::raw('DATE_FORMAT(form_permohonan.tgl_pengajuan, "%d-%m-%Y") as tanggal'),
                'form_permohonan.tgl_pengajuan as raw_date',
                'user.nama as nama_pengirim',
                'form_permohonan.id_permohonan as id',
                'form_permohonan.jenis_surat', // ✅ Tambahkan ini
                DB::raw('CASE 
                    WHEN form_permohonan.jenis_surat LIKE "%perdagangan%" THEN "Perdagangan"
                    WHEN form_permohonan.jenis_surat LIKE "%industri%" THEN "Industri"
                    ELSE "Perdagangan"
                END as bidang_terkait'),
                DB::raw('CASE 
                    WHEN form_permohonan.status = "menunggu" THEN "Menunggu"
                    WHEN form_permohonan.status = "diterima" THEN "Disetujui"
                    WHEN form_permohonan.status = "ditolak" THEN "Ditolak"
                    WHEN form_permohonan.status = "selesai" THEN "Selesai"
                    ELSE form_permohonan.status
                END as status'),
                'form_permohonan.file_balasan'
            );

        $permohonanMetrologi = DB::table('surat_metrologi')
            ->join('user', 'surat_metrologi.user_id', '=', 'user.id_user')
            ->leftJoin('surat_keluar_metrologi', 'surat_metrologi.id_surat', '=', 'surat_keluar_metrologi.id_surat')
            ->select(
                DB::raw('DATE_FORMAT(surat_metrologi.created_at, "%d-%m-%Y") as tanggal'),
                'surat_metrologi.created_at as raw_date',
                'user.nama as nama_pengirim',
                'surat_metrologi.id_surat as id',
                'surat_metrologi.jenis_surat', // ✅ Tambahkan ini
                DB::raw('"Metrologi" as bidang_terkait'),
                DB::raw('CASE 
                    WHEN surat_metrologi.status_surat_masuk = "menunggu" THEN "Menunggu"
                    WHEN surat_metrologi.status_surat_masuk = "disetujui" THEN "Disetujui"
                    WHEN surat_metrologi.status_surat_masuk = "ditolak" THEN "Ditolak"
                    WHEN surat_metrologi.status_surat_masuk = "diproses" THEN "Diproses"
                    WHEN surat_metrologi.status_surat_masuk = "menunggu_persetujuan" THEN "Menunggu"
                    WHEN surat_metrologi.status_surat_masuk = "butuh_revisi" THEN "Butuh Revisi"
                    ELSE surat_metrologi.status_surat_masuk
                END as status'),
                'surat_keluar_metrologi.path_dokumen as file_balasan'
            );

            $unionQuery = $permohonanPerdagangan->unionAll($permohonanMetrologi);

        // Combine and order by raw date, limit to 17 entries
        $permohonan = DB::table(DB::raw("({$unionQuery->toSql()}) as sub"))
            ->mergeBindings($permohonanPerdagangan)
            ->orderByRaw('STR_TO_DATE(tanggal, "%d-%m-%Y") desc')
            ->get();

        foreach ($permohonan as $item) {
            // parsing tanggal "dd-mm-yyyy" ke Carbon
            $date = Carbon::createFromFormat('d-m-Y', $item->tanggal);
            $month = $date->format('Y-m'); // contoh "2025-05"

            if (!isset($countsPerMonth[$month])) {
                $countsPerMonth[$month] = 0;
            }
            $countsPerMonth[$month]++;
        }
        
        return view('admin.adminSuper.daftarPermohonan', compact('permohonan'));
    }
}