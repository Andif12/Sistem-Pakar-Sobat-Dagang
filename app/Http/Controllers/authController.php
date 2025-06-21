<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Disdag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterVerificationMail;

class authController extends Controller
{
    public function showFormLogin()
    {
        return view('pages.auth.login');
    }

    public function showFormRegister()
    {
        $json = file_get_contents(public_path('assets/data/wilayah.json'));
        $wilayah = json_decode($json, true);
        return view('pages.auth.register', compact('wilayah'));
    }

    public function submitFormLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->username;

        // 1. Coba login disdag via NIP
        $disdag = Disdag::where('nip', $identifier)->first();
        if ($disdag && Hash::check($request->password, $disdag->password)) {
            Auth::guard('disdag')->login($disdag);
            session(['id_disdag' => $disdag->id_disdag]); // Simpan ID ke session
            
            switch ($disdag->role) {
                case 'master_admin':
                    return redirect()->intended('/admin/master');
                case 'admin_perdagangan':
                    return redirect()->intended(route('dashboard.perdagangan'));
                case 'admin_industri':
                    return redirect()->intended(route('dashboard.industri'));
                case 'admin_metrologi':
                    return redirect()->intended(route('dashboard-admin-metrologi'));
                case 'kabid_perdagangan':
                    return redirect()->intended(route('kabid.perdagangan'));
                case 'kabid_industri':
                    return redirect()->intended(route('kabid.industri'));
                case 'kabid_metrologi':
                    return redirect()->intended(route('dashboard-kabid-metrologi'));
                case 'kepala_dinas':
                    return redirect()->intended(route('dashboard-kadis'));
                default:
                    return redirect('/dashboard');
            }
        }


        // 2. Jika tidak ditemukan di disdag, coba login sebagai user
        $user = User::where('nik', $identifier)->orWhere('nib', $identifier)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Cek apakah akun sudah diverifikasi
            if ($user->is_verified != 1) {
                return back()->withErrors([
                    'identifier' => 'Akun Anda belum diverifikasi. Silakan cek email untuk verifikasi.',
                ]);
            }

            Auth::guard('user')->login($user);
            session(['id_user' => $user->id_user]);

            return redirect()->intended(route('user.dashboard'));
        }

        return redirect()->route('login')->withErrors(['login_error' => 'Username atau password salah']);
    }

    public function submitRegister(Request $request)
    {
        Log::info('Data registrasi yang diterima:', $request->all());

        try {
            $messages = [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'nama.max' => 'Nama maksimal 255 karakter.',

                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in' => 'Jenis kelamin harus "Laki-laki" atau "Perempuan".',

                'kabupaten.required' => 'Kabupaten wajib diisi.',
                'kabupaten.string' => 'Kabupaten harus berupa teks.',
                'kabupaten.max' => 'Kabupaten maksimal 255 karakter.',

                'kecamatan.required' => 'Kecamatan wajib diisi.',
                'kecamatan.string' => 'Kecamatan harus berupa teks.',
                'kecamatan.max' => 'Kecamatan maksimal 255 karakter.',

                'kelurahan.required' => 'Kelurahan wajib diisi.',
                'kelurahan.string' => 'Kelurahan harus berupa teks.',
                'kelurahan.max' => 'Kelurahan maksimal 255 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.string' => 'Email harus berupa teks.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',
                'email.unique' => 'Email sudah terdaftar.',

                'telp.required' => 'Nomor telepon wajib diisi.',
                'telp.string' => 'Nomor telepon harus berupa teks.',
                'telp.max' => 'Nomor telepon maksimal 15 karakter.',

                'password.required' => 'Password wajib diisi.',
                'password.string' => 'Password harus berupa teks.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',

                'alamat_lengkap.required' => 'Alamat lengkap wajib diisi.',
                'alamat_lengkap.string' => 'Alamat lengkap harus berupa teks.',

                'nik.required' => 'NIK wajib diisi.',
                'nik.unique' => 'NIK sudah terdaftar.',
                'nik.regex' => 'NIK harus berupa 16 digit angka.',

                'nib.alpha_num' => 'NIB hanya boleh terdiri dari huruf dan angka tanpa spasi atau simbol.',
                'nib.min' => 'NIB minimal 10 karakter.',
                'nib.max' => 'NIB maksimal 20 karakter.',
            ];
                $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'kabupaten' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:user,email',
                'telp' => 'required|string|max:15',
                'password' => 'required|string|min:8|confirmed',
                'alamat_lengkap' => 'required|string',
                'nik' => ['required', 'unique:user,nik', 'regex:/^\d{16}$/'],
                'nib' => 'nullable|alpha_num|min:10|max:20',
            ], $messages);

            Log::info('Validasi berhasil, data valid:', $validated);

            $token = Str::random(64);

            $user = new User;
            $user->nama = $validated['nama']; 
            $user->jenis_kelamin = $validated['jenis_kelamin'];
            $user->kabupaten = $validated['kabupaten'];
            $user->kecamatan = $validated['kecamatan'];
            $user->kelurahan = $validated['kelurahan'];
            $user->email = $validated['email'];
            $user->telp = $validated['telp'];
            $user->password = Hash::make($validated['password']);
            $user->alamat_lengkap = $validated['alamat_lengkap'];
            $user->nik = $validated['nik'];
            $user->nib = $validated['nib'];
            $user->verifikasi_token = $token;
            $user->is_verified = false;

            Log::info('Mencoba menyimpan user ke database');
            $user->save();

            Log::info('User berhasil disimpan dengan ID: ' . $user->id_user);

            // Kirim email verifikasi
            Log::info('Mengirim email verifikasi ke: ' . $user->email);
            Mail::to($user->email)->send(new RegisterVerificationMail($user));

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Error saat registrasi: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->withInput()->withErrors(['general' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showforgotPassword()
    {
        return view('pages.auth.forgotpass');
    }

    public function showchangePassword()
    {
        return view('pages.auth.changepass');
    }

    // public function showverification()
    // {
    //     return view('pages.auth.verification');
    // }
};