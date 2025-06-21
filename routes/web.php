<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\authController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMetrologiController;
use App\Http\Controllers\AdminIndustriController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DirectoryBookController;
use App\Http\Controllers\DataIKMController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PersuratanController;
use App\Http\Controllers\dashboardPerdaganganController;
use App\Http\Controllers\PelaporanPenyaluranController;
use App\Http\Controllers\SobatHargaController;
use App\Http\Controllers\KabidPerdaganganController;
use App\Http\Middleware\UserAuthMiddleware;
use App\Http\Middleware\RoleCheckMiddleware;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\KabidIndustriController;
use App\Http\Controllers\UserHalalController;
use App\Http\Controllers\HalalController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\ForumDiskusiController;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\KadisController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Mail\RegisterVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/verifikasi-akun', function (Request $request) {
    $user = User::where('verifikasi_token', $request->token)->first();

    if (!$user) {
        $status = 'Token tidak valid atau sudah digunakan.';
    } elseif ($user->is_verified) {
        $status = 'Akun Anda sudah diverifikasi sebelumnya.';
    } else {
        $user->is_verified = true;
        $user->verifikasi_token = null;
        $user->save();
        $status = 'Akun Anda berhasil diverifikasi. Silahkan login';
    }

    return view('pages.auth.verification', ['status' => $status]);
});

// Controller untuk halaman utama (homepage)
Route::get('/', [homeController::class, 'index'])->name('Home');
Route::get('/about', [homeController::class, 'showAboutPage'])->name('about');
Route::get('/faq', [homeController::class, 'showFaqPage'])->name('faq');
Route::get('/harga-pasar/{kategori}', [SobatHargaController::class, 'index'])->name('harga-pasar.kategori');
Route::get('/sobat-harga/{kategori}', [SobatHargaController::class, 'index'])->name('sobatHarga.kategori');
Route::get('/berita/{id}', [homeController::class, 'show'])->name('berita.utama');

// Controller untuk authentication
Route::get('/login', [authController::class, 'showFormLogin'])->name('login');
Route::post('/login', [authController::class, 'submitFormLogin'])->name('login.submit');
Route::get('/register', [authController::class, 'showFormRegister'])->name('register');
Route::post('/register', [authController::class, 'submitRegister'])->name('register.submit');
Route::get('/forgot-password', [authController::class, 'showforgotPassword'])->name('forgot.password');
Route::get('/change-password', [authController::class, 'showChangePassword'])->name('change.password');
Route::post('/logout', [authController::class, 'logout'])->name('logout');
Route::get('/lupa-password', [LupaPasswordController::class, 'showForm'])->name('password.request');
Route::post('/lupa-password', [LupaPasswordController::class, 'sendLink'])->name('password.email');

Route::get('/reset-password/{token}', [LupaPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LupaPasswordController::class, 'resetPassword'])->name('password.update');


// guest
Route::get('/harga-pasar/{kategori}', [SobatHargaController::class, 'index'])->name('harga-pasar.kategori');
Route::get('/sobat-harga/{kategori}', [SobatHargaController::class, 'index'])->name('sobatHarga.kategori');
Route::get('/', [homeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'showAboutPage'])->name('about');
Route::get('/berita/{id}', [homeController::class, 'show'])->name('berita.utama');
Route::get('/user/profil', [DashboardController::class, 'showProfile'])->name('profile');
Route::put('/user/profil', [DashboardController::class, 'updateProfile'])->name('profile.update');
Route::post('/user/profil', [DashboardController::class, 'updateProfile'])->name('profile.update');

//untuk download dan notif
Route::get('/tes-kirim-notifikasi', [DirectoryBookController::class, 'periksaKadaluarsa']);
Route::get('/uttp/download', [DirectoryBookController::class, 'downloadUttp'])->name('uttp.download');

// user Login
Route::middleware(['auth.role:user'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profil', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/forgotpass', [authController::class, 'showForgotPassword'])->name('forgotpass');
    Route::get('/resetpass', [authController::class, 'showChangePassword'])->name('resetpass');
    Route::get('/verify-old-password', [LupaPasswordController::class, 'showVerifyForm'])->name('password.verifyOldForm'); 
    Route::post('/verify-old-password', [LupaPasswordController::class, 'checkOldPassword'])->name('password.checkOld');
    Route::get('/new-password', [LupaPasswordController::class, 'resetPass'])->name('password.resetPass');
    Route::post('/new-password', [LupaPasswordController::class, 'updateNewPassword'])->name('password.updateNew');

    Route::get('/profile/edit', [homeController::class, 'editProfile'])->name('edit.profile');
    Route::put('/profile/update', [homeController::class, 'updateProfile'])->name('profile.update');

    //pengaduan
    Route::post('/forum-chat/send', [ForumDiskusiController::class, 'kirimPesan'])->name('forum.kirim');
    Route::get('/forum-chat/load', [ForumDiskusiController::class, 'ambilPesan'])->name('forum.ambil');
    Route::get('/forum-chat', [ForumDiskusiController::class, 'index'])->name('forum.chat');

    //pelaporan
    Route::get('/pelaporan', [PelaporanController::class, 'index'])->name('pelaporan');
    Route::get('/pelaporan-penyaluran', [PelaporanController::class, 'pelaporanPenyaluran'])->name('pelaporan-penyaluran');
    Route::get('/form-permohonan-distributor', [PelaporanController::class, 'formDistributor'])->name('bidangPerdagangan.formDistributor');
    Route::post('/form-permohonan-distributor', [PelaporanController::class, 'submitDistributor'])->name('bidangPerdagangan.submitDistributor');
    Route::get('/verifikasi-pengajuan', [PelaporanController::class, 'verifikasiPengajuan'])->name('cekpengajuan');
    Route::get('/input-data-toko', [PelaporanController::class, 'showForm'])->name('pelaporan.showInputForm');
    Route::post('/input-data-toko', [PelaporanController::class, 'inputDataToko'])->name('pelaporan.inputDataToko');
    Route::get('/input-data-distribusi/{id_toko}', [PelaporanController::class, 'showDataDistribusi'])->name('pelaporan.showDataDistribusi');
    Route::post('/input-data-distribusi', [PelaporanController::class, 'inputDataDistribusi'])->name('pelaporan.inputDataDistribusi');
    Route::delete('/toko/{id}', [PelaporanController::class, 'destroy'])->name('toko.destroy');
    Route::post('/pengaduan-distributor', [PelaporanController::class, 'storePengaduanDistributor'])->name('pelaporan.pengaduan.store');

    //perdagangan
    Route::get('/bidang-perdagangan/form-permohonan', [dashboardPerdaganganController::class, 'formPermohonan'])->name('bidangPerdagangan.formPermohonan');
    Route::get('/bidang-perdagangan/riwayat-surat', [dashboardPerdaganganController::class, 'riwayatSurat'])->name('bidangPerdagangan.riwayatSurat');
    Route::post('/bidang-perdagangan/ajukan-permohonan', [dashboardPerdaganganController::class, 'ajukanPermohonan'])->name('ajukanPermohonan_perdagangan');

    // Metrologi
    Route::get('/administrasi-metrologi', [PersuratanController::class, 'showAdministrasiMetrologi'])->name('administrasi-metrologi');
    Route::post('/store-surat', [PersuratanController::class, 'storeSuratMetrologi'])->name('proses-surat-metrologi');
    Route::get('/lihat-dokumen/{id}', [PersuratanController::class, 'showDokumenMetrologi'])->name('lihat-dokumen');
    Route::get('/directory-book-metrologi', [DirectoryBookController::class, 'showDirectoryUserMetrologi'])->name('directory-metrologi');
    Route::get('/alat-user/{id}', [DirectoryBookController::class, 'alatUser'])->name('alat.user');
    Route::post('/alat-ukur/detail', [DirectoryBookController::class, 'getDetail'])->name('alat.detail.user');

    // Industri
    Route::get('/bidang-industri/form-permohonan', [AdminIndustriController::class, 'formPermohonan'])->name('bidangIndustri.formPermohonan');
    Route::get('/bidang-industri/riwayat-surat', [AdminIndustriController::class, 'riwayatSuratt'])->name('bidangIndustri.riwayatSurat');
    Route::post('/bidang-industri/ajukan-permohonan', [AdminIndustriController::class, 'ajukanPermohonann'])->name('ajukan.Permohonan');
    Route::get('/bidang-industri/data-sertifikat-halal', [UserHalalController::class, 'index'])->name('halal.user');
    Route::post('/bidang-industri/draft-permohonan', [AdminIndustriController::class, 'draftPermohonann'])->name('bidangIndustri.draftPermohonan');
});

// Admin Perdagangan
Route::middleware(['check.role:admin_perdagangan'])->group(function () {
    Route::get('/dashboard-perdagangan', [dashboardPerdaganganController::class, 'index'])->name('dashboard.perdagangan');
    // Pelaporan
    Route::get('/review-pengajuan', [PelaporanController::class, 'reviewPengajuan']);
    Route::get('/lihat-laporan-distribusi-pupuk', [dashboardPerdaganganController::class, 'laporanPupuk'])->name('lihat.laporan.distribusi');
    Route::get('/lihat-laporan-distribusi-pupuk/edit-laporan/{id_toko}', [dashboardPerdaganganController::class, 'EditlaporanPupuk'])->name('edit.laporan.distribusi');
    Route::get('/lihat-laporan-distribusi-pupuk/cari-laporan', [dashboardPerdaganganController::class, 'CarilaporanPupuk'])->name('admin.editLaporanPupuk');
    Route::put('/lihat-laporan-distribusi-pupuk/edit-laporan/update', [dashboardPerdaganganController::class, 'updateStokAwal'])->name('admin.updateStokAwal');
    Route::post('/lihat-laporan-distribusi-pupuk/update-penyaluran', [dashboardPerdaganganController::class, 'updatePenyaluran'])->name('admin.updatePenyaluran');
    Route::get('/admin/pengaduan-distributor', [PelaporanController::class, 'indexPengaduan'])->name('admin.pengaduan.index');
    Route::patch('/admin/pengaduan-distributor/{id}/selesai', [PelaporanController::class, 'tandaiSelesai'])->name('admin.pengaduan.selesai');

    // sobat Harga
    Route::get('/tambah-barang', [dashboardPerdaganganController::class, 'formTambahBarang'])->name('dashboard-perdagangan.form-tambah-barang');
    Route::post('/tambah-barang', [dashboardPerdaganganController::class, 'storeBarang'])->name('dashboard-perdagangan.tambah-barang');
    Route::get('/update-harga', [dashboardPerdaganganController::class, 'formUpdateHarga'])->name('updateHarga.store');
    Route::post('/update-harga', [dashboardPerdaganganController::class, 'update'])->name('updateHarga.update');
    Route::get('/get-barang-by-kategori/{id}', [dashboardPerdaganganController::class, 'getByKategori']);
    Route::get('/hapus-barang', [dashboardPerdaganganController::class, 'deleteBarang'])->name('dashboard-perdagangan.hapus-barang');
    Route::delete('/dashboard-perdagangan/barang/{id}', [dashboardPerdaganganController::class, 'destroy'])->name('barang.destroy');
    // Persuratan
    Route::get('/kelola-surat', [dashboardPerdaganganController::class, 'kelolaSurat'])->name('perdagangan.kelolaSurat');
    Route::get('/detail-surat/{id_permohonan}', [dashboardPerdaganganController::class, 'detailSurat'])
        ->where('id_permohonan', '[0-9a-fA-F\-]+')
        ->name('perdagangan.detailSurat');
    Route::put('/permohonan/{id}/tolak', [dashboardPerdaganganController::class, 'tolak'])->name('permohonan.tolak');
    Route::put('/permohonan/{id}/keterangan', [dashboardPerdaganganController::class, 'simpanketerangan'])->name('permohonan.keterangan');
    Route::put('/permohonan/{id}/rekomendasi', [dashboardPerdaganganController::class, 'simpanRekomendasi'])->name('permohonan.rekomendasi');
    Route::get('/detail-surat/{id}/view-{type}', [dashboardPerdaganganController::class, 'viewDokumen'])
        ->where('type', 'NIB|NPWP|KTP|AKTA|SURAT|USAHA')
        ->name('dokumen.view');
});

//Admin Industri
Route::middleware(['check.role:admin_industri'])->group(function () {
     // Dashboard
    Route::get('/admin/industri', [AdminIndustriController::class, 'showDashboard'])->name('dashboard.industri');
    Route::get('/admin/surat-industri', [AdminIndustriController::class, 'kelolaSuratt'])->name('kelolaSurat.industri');
    Route::get('/admin/detail-surat/{id_permohonan}', [AdminIndustriController::class, 'detailSuratt'])
        ->where('id_permohonan', '[0-9a-fA-F\-]+')
        ->name('industri.detailSurat');
    Route::put('/admin/permohonan/{id}/tolak', [AdminIndustriController::class, 'tolakk'])->name('permohonan.tolakI');
    Route::put('/admin/permohonan/{id}/keterangan', [AdminIndustriController::class, 'simpanketerangan'])->name('permohonan.keteranganI');
    Route::put('/admin/permohonan/{id}/rekomendasi', [AdminIndustriController::class, 'simpanRekomendasi'])->name('permohonan.rekomendasiI');
    Route::get('/admin/detail-surat/{id}/view-{type}', [AdminIndustriController::class, 'viewDokumenn'])
        ->where('type', 'NIB|NPWP|KTP|AKTA|SURAT|USAHA')
        ->name('dokumen.viewi');
    Route::put('/admin/industri/sertifikat-halal/{halal}', [HalalController::class, 'update'])->name('admin.industri.halal.update');
    Route::get('/admin/industri/sertifikat-halal', [HalalController::class, 'index'])->name('admin.industri.halal');
    Route::post('/admin/industri/sertifikat-halal/store', [HalalController::class, 'store'])->name('admin.industri.halal.store');
    Route::put('/admin/industri/sertifikat-halal/{id}/edit', [HalalController::class, 'edit'])->name('admin.industri.halal.edit');
    Route::delete('/admin/industri/sertifikat-halal/{id}', [HalalController::class, 'destroy'])->name('admin.industri.halal.destroy');

    // Data IKM
    Route::get('/data-IKM', [AdminIndustriController::class, 'showdataIKM'])->name('dataIKM');
    Route::get('/form-IKM', [AdminIndustriController::class, 'ShowformIKM'])->name('formIKM');
    Route::post('data-IKM/store', [AdminIndustriController::class, 'storeDataIKM'])->name('dataIKM.store');
    Route::get('data-IKM/{id}/edit', [AdminIndustriController::class, 'editIKM'])->name('editIKM');
    Route::get('data-ikm/{id}/detail', [AdminIndustriController::class, 'detailIKM'])->name('detailIKM');
    Route::delete('data-IKM/{id}', [AdminIndustriController::class, 'destroyIKM'])->name('destroyIKM');
    Route::get('/data-IKM/export', [AdminIndustriController::class, 'exportIKM'])->name('exportIKM');
    Route::post('/data-IKM/update', [AdminIndustriController::class, 'updateIKM'])->name('updateIKM');
    Route::post('data-IKM/pengeluaran/update', [AdminIndustriController::class, 'updatePengeluaran'])->name('updatePengeluaran');
    Route::post('data-IKM/persediaan/update', [AdminIndustriController::class, 'updatePersediaan'])->name('updatePersediaan');
    Route::post('/data-IKM/karyawan/update', [AdminIndustriController::class, 'updateKaryawan'])->name('updateKaryawan');
    Route::post('/data-IKM/limbah/update', [AdminIndustriController::class, 'updateLimbah'])->name('updateLimbah');
    Route::post('/data-IKM/pendapatan/update', [AdminIndustriController::class, 'updatePendapatan'])->name('updatePendapatan');
    Route::post('/data-IKM/persentase/update', [AdminIndustriController::class, 'updatePersentase'])->name('updatePersentase');
    Route::post('/data-IKM/produksi/update', [AdminIndustriController::class, 'updateProduksi'])->name('updateProduksi');
    Route::post('/data-IKM/penggunaan-listrik/update', [AdminIndustriController::class, 'updateListrik'])->name('updateListrik');
    Route::post('/data-IKM/penggunaan-air/update', [AdminIndustriController::class, 'updatePenggunaanAir'])->name('updatePenggunaanAir');
    Route::post('/data-IKM/pemakaian-bahan/update', [AdminIndustriController::class, 'updatePemakaianBahan'])->name('updatePemakaianBahan');
    Route::post('/data-IKM/bahan-bakar/update', [AdminIndustriController::class, 'updateBahanBakar'])->name('updateBahanBakar');
    Route::post('/data-IKM/mesin-produksi/update', [AdminIndustriController::class, 'updateMesinProduksi'])->name('updateMesinProduksi');
    Route::post('/data-IKM/modal/update', [AdminIndustriController::class, 'updateModal'])->name('updateModal');
});

//Admin Metrologi
Route::middleware(['check.role:admin_metrologi'])->group(function () {
    Route::get('/admin/metrologi', [DashboardMetrologiController::class, 'index'])->name('dashboard-admin-metrologi');
    Route::get('/admin/management-uttp-metrologi', [DirectoryBookController::class, 'showDirectoryAdminMetrologi'])->name('management-uttp-metrologi');
    Route::get('/kabid/metrologi/directory-uttp', [DirectoryBookController::class, 'showDirectoryKabidMetrologi'])->name('directory-uttp-kabid');
    Route::post('/uttp/store-alat', [DirectoryBookController::class, 'storeAlatUkur'])->name('store-uttp');
    Route::delete('/uttp/{id}', [DirectoryBookController::class, 'destroy'])->name('delete-uttp');
    Route::delete('/admin/uttp/{id}', [DirectoryBookController::class, 'destroy'])->name('uttp.destroy');
    Route::patch('/admin/uttp/update/{id}', [DirectoryBookController::class, 'update'])->name('update-uttp');
    Route::get('/admin/users/search', [DirectoryBookController::class, 'searchUsers'])->name('search-users');
    Route::put('/admin/surat/{encoded_id}/tolak', [PersuratanController::class, 'tolakSurat'])->name('surat.tolak');
    Route::get('/admin/persuratan-metrologi', [DashboardMetrologiController::class, 'showAdministrasi'])->name('persuratan-metrologi');
    Route::put('/surat/terima/{id}', [PersuratanController::class, 'terimaSurat'])->name('surat.terima');
    Route::put('/surat/terima/{encoded_id}', [PersuratanController::class, 'terimaKabid'])->name('terimaKabid');
    Route::put('/surat/tolak/{encoded_id}', [PersuratanController::class, 'tolakKabid'])->name('tolakKabid');
    Route::get('/surat/{id}/keterangan', [PersuratanController::class, 'showkirimKeterangan'])->name('create-keterangan');
    Route::get('/surat/{id}/balasan', [PersuratanController::class, 'showcreateSuratBalasan'])->name('create-surat-balasan');
    Route::post('/admin/surat/{id}/balasan', [PersuratanController::class, 'createSuratBalasan'])->name('proces-surat-balasan');
    Route::post('/check-nomor-surat-balasan', [PersuratanController::class, 'checkNomorSuratBalasan'])->name('check-nomor-surat-balasan');
    Route::get('/admin/surat/{id}/edit-balasan', [PersuratanController::class, 'editBalasan'])->name('edit-surat-balasan');
    Route::put('/admin/surat/{id}/update-balasan', [PersuratanController::class, 'updateBalasan'])->name('update-surat-balasan');
    Route::put('/admin/surat/{id}/selesai', [PersuratanController::class, 'tandaiSelesai'])->name('surat.selesai');
    Route::post('/uttp/detail', [DirectoryBookController::class, 'getDetail'])->name('uttp.detail.post');
});

//Admin master
Route::middleware(['check.role:master_admin'])->group(function () {
    Route::get('/admin/master', [DashboardController::class, 'dashboardMaster'])->name('dashboard-master');
    #distribusi
    Route::get('/review-distributor', [PelaporanController::class, 'reviewPengajuanDistributor'])->name('review.pengajuan');
    Route::post('/distributor/{id_distributor}/terima', [PelaporanController::class, 'setujui'])->name('distributor.setujui');
    Route::post('/distributor/{id_distributor}/tolak', [PelaporanController::class, 'tolak'])->name('distributor.tolak');
    Route::get('/lihat-laporan', [PelaporanController::class, 'lihatLaporan'])->name('lihat.laporan');
    Route::get('/tambah-barang-distribusi', [PelaporanController::class, 'tambahBarangDistribusi'])->name('tambah.barang-distribusi');
    Route::delete('/distributor/{id_distributor}/hapus', [PelaporanController::class, 'hapus'])->name('distributor.hapus');
    #kelola berita
    Route::get('/admin/kelola-pengguna', [DashboardController::class, 'kelolaAdmin'])->name('kelola.admin');
    Route::post('/admin/kelola-pengguna', [DashboardController::class, 'tambahpengguna'])->name('tambah.pengguna');
    Route::get('/admin/kelola-berita', [BeritaController::class, 'show'])->name('kelola.berita');
    Route::post('/admin/kelola-berita', [BeritaController::class, 'tambahberita'])->name('tambah.berita');
    Route::put('/admin/{id_berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/admin/{id_berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/berita/{id}/edit', [homeController::class, 'edit'])->name('berita.edit');   
    #Kelola FAQ
    Route::get('/admin/kelola-faq', [FAQController::class, 'index'])->name('faq-controller');
    Route::post('/admin/faq/store', [FAQController::class, 'store'])->name('faq-store');
    Route::put('/admin/faq/{faq}', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/admin/faq/{id}', [FAQController::class, 'destroy'])->name('faq-destroy');
    // Manajement Pengguna
    Route::get('/admin/manajemen-pengguna', [UserManagementController::class, 'index'])->name('manajemen.pengguna');
    Route::get('/admin/manajemen-pengguna/tambah', [UserManagementController::class, 'create'])->name('manajemen.pengguna.create');
    Route::post('/admin/manajemen-pengguna', [UserManagementController::class, 'store'])->name('manajemen.pengguna.store');
    Route::get('/admin/manajemen-pengguna/{id}/edit', [UserManagementController::class, 'edit'])->name('manajemen.pengguna.edit');
    Route::put('/admin/manajemen-pengguna/{id}', [UserManagementController::class, 'update'])->name('manajemen.pengguna.update');
    Route::delete('/admin/manajemen-pengguna/{id}', [UserManagementController::class, 'destroy'])->name('manajemen.pengguna.destroy'); 
    // Manajement admin
    Route::get('/admin/manajemen-admin', [AdminManagementController::class, 'index'])->name('manajemen.admin');
    Route::get('/admin/manajemen-admin/tambah', [AdminManagementController::class, 'create'])->name('manajemen.admin.create');
    Route::post('/admin/manajemen-admin', [AdminManagementController::class, 'store'])->name('manajemen.admin.store');
    Route::delete('/admin/manajemen-admin/{id}', [AdminManagementController::class, 'destroy'])->name('manajemen.admin.destroy');
    Route::get('/admin/manajemen-pengguna/disdag/{id}/edit', [AdminManagementController::class, 'editDisdag'])->name('manajemen.admin.edit');
    Route::put('/admin/manajemen-pengguna/disdag/{id}', [AdminManagementController::class, 'updateDisdag'])->name('manajemen.admin.update');
    Route::get('/admin/permohonan', [DashboardController::class, 'daftarPermohonan'])->name('admin.daftarPermohonan');
    Route::get('/admin/permohonan/{id}/{bidang}', [DashboardController::class, 'detailPermohonan'])->name('admin.detailPermohonan');
    Route::get('/admin/permohonan/{id}/{bidang}/balasan', [DashboardController::class, 'downloadBalasan'])->name('admin.downloadBalasan');
    // Kelola Pengaduan
    Route::get('/admin/forum-pengaduan', [ForumDiskusiController::class, 'adminForm'])->name('forum.admin');
    Route::get('/forum/load', [ForumDiskusiController::class, 'load']);
    Route::post('/kirim-pesan', [ForumDiskusiController::class, 'send']);
    Route::delete('/forum-diskusi/{id}', [ForumDiskusiController::class, 'destroy'])->name('forum-diskusi.destroy');
});

//kabid Perdagangan
Route::middleware(['check.role:kabid_perdagangan'])->group(function () {
    Route::get('/kabid-perdagangan/dashboard', [KabidPerdaganganController::class, 'dashboardKabid'])->name('kabid.perdagangan');
    Route::get('/kabid-perdagangan/distribusi-pupuk', [KabidPerdaganganController::class, 'distribusiPupuk'])->name('distribusi.pupuk');
    Route::get('/kabid-perdagangan/analisis-pasar', [KabidPerdaganganController::class, 'analisisPasar'])->name('analisis.pasar');
    Route::put('/kabid-perdagangan/surat/{id}/setujui', [KabidPerdaganganController::class, 'setujui'])->name('suratPerdagangan.setujui');
});

//kabid Industri
Route::middleware(['check.role:kabid_industri'])->group(function () {
    Route::get('/kabid-industri/dashboard', [KabidIndustriController::class, 'dashboardKabid'])->name('kabid.industri');
    Route::get('/kabid-industri/data-IKM', [KabidIndustriController::class, 'DataIKM'])->name('kabid.dataIKM');
    Route::get('/kabid-industri/sertifikat-halal', [KabidIndustriController::class, 'sertifikatHalal'])->name('kabid.halal');
    Route::get('/kabid-industri/surat', [KabidIndustriController::class, 'verifSurat'])->name('kabid.suratI');
    Route::put('/kabid-industri/surat/{id}/setujui', [KabidIndustriController::class, 'setujuiI'])->name('kabid.setujuiSurat');
});

// Kabid Metrologi
Route::middleware(['check.role:kabid_metrologi'])->group(function () {
    Route::get('/kabid/metrologi', [DashboardMetrologiController::class, 'showKabid'])->name('dashboard-kabid-metrologi');
    Route::get('/kabid/administrasi/metrologi', [DashboardMetrologiController::class, 'showAdministrasiKabid'])->name('administrasi-kabid-metrologi');
    Route::get('/kabid/uttp/metrologi', [DashboardMetrologiController::class, 'showUttp'])->name('informasi-uttp');
    Route::post('/surat/terima/{encoded_id}', [PersuratanController::class, 'terimaKabid'])->name('terimaKabid');
    Route::post('/surat/tolak/{encoded_id}', [PersuratanController::class, 'tolakKabid'])->name('tolakKabid');
    Route::post('/kabid/metrologi/detail', [DirectoryBookController::class, 'getDetail'])->name('kabid.detail');
});

// Kepala Dinas
Route::middleware(['check.role:kepala_dinas'])->group(function () {
    Route::get('/kadis/dashboard', [KadisController::class, 'index'])->name('dashboard-kadis');
    Route::get('/kadis/metrologi', [DashboardMetrologiController::class, 'showKadisMetro'])->name('kadis-metro');
    Route::get('/kadis/persuratan', [DashboardMetrologiController::class, 'showPersuratanKadis'])->name('persuratan-kadis');
    Route::get('/kadis/persuratan/metrologi', [DashboardMetrologiController::class, 'showPersuratanMetrologiKadis'])->name('surat-metrologi-kadis');
    Route::post('/kadis/surat/{encoded_id}/setujui', [PersuratanController::class, 'setujuiKadis'])->name('setujuiKadis');
    Route::post('/kadis/surat/{encoded_id}/tolak', [PersuratanController::class, 'tolakKadis'])->name('tolakKadis');
    Route::get('/kepala-dinas/surat-perdagangan', [SobatHargaController::class, 'suratPerdagangan'])->name('kepalaDinas.suratPerdagangan');
    Route::put('/kadis-perdagangan/surat/{id}/setujui', [KabidPerdaganganController::class, 'setujui'])->name('kadissuratPerdagangan.setujui');
    Route::get('/kepala-dinas/perdagangan', [SobatHargaController::class, 'perdagangan'])->name('kepalaDinas.perdagangan');
    Route::get('/kadis/metrologi', [DashboardMetrologiController::class, 'showKadisMetro'])->name('kadis-metro');
    Route::get('/kadis/industri', [KabidIndustriController::class, 'KadisIndustri'])->name('kadis.industri');
    Route::get('/kadis/industri/surat', [KabidIndustriController::class, 'SuratKadis'])->name('kadis.industri.surat');
    Route::put('/kadis/industri/surat/{id}/setujui', [KabidIndustriController::class, 'kadisSetujui'])->name('kadis.setujuiSurat');
});
