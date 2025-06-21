<?php

namespace App\Http\Controllers;
use App\Models\Berita;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;;

class homeController extends Controller
{
    // Menampilkan halaman utama dengan daftar berita
    public function index()
    {
        $daftarBerita = Berita::orderBy('tanggal', 'desc')->get();
        return view('pages.home', compact('daftarBerita'));
    }


    public function show($judul)
    {
        $judulDecoded = urldecode($judul);
        $berita = Berita::where('judul', $judulDecoded)->firstOrFail();
        return view('pages.halamanBerita', compact('berita'));
    }

    public function showAboutPage()
    {
        return view('pages.aboutUs');
    }

    public function showFaqPage()
    {
        $faqs = Faq::all(); 
        return view('pages.faq', compact('faqs'));
    }

    public function showHalal()
    {
        return view('user.bidangIndustri.halal');
    }

    public function editProfile()
    {
    // Ambil data user (jika perlu)
    $userId = auth()->guard('user')->id();
    $user = \App\Models\User::find($userId);

    // Tampilkan halaman edit profil
    return view('component.profile', compact('user'));
    }

    public function updateProfile(Request $request)
{
    $userId = auth()->guard('user')->id();
    $user = \App\Models\User::find($userId);

    $request->validate([
           'nama' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/u'
            ],
            'email' => 'required|email|max:255',
            'telp' => 'nullable|string|max:20',
            'nik' => 'required|digits:16',
            'nib' => 'nullable|alpha_num|min:10|max:20',
            'alamat_lengkap' => 'nullable|string|max:500',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512', // max 512 KB (0.5MB)
        ]);

        // Update fields
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->telp = $request->telp;
        $user->nik = $request->nik;
        $user->nib = $request->nib;
        $user->alamat_lengkap = $request->alamat_lengkap;
        $user->jenis_kelamin = $request->jenis_kelamin;

        // Upload avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists('foto_profil/' . $user->avatar)) {
                Storage::disk('public')->delete('foto_profil/' . $user->avatar);
            }

            // Simpan avatar baru
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('foto_profil', $filename, 'public');

            // Simpan nama file ke database
            $user->avatar = $filename;
        }

        $user->save();
        return redirect()->route('edit.profile')->with('success', 'Profil berhasil diperbarui!');

}


}
