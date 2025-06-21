<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Disdag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        $disdagUsers = Disdag::all();
        return view('admin.adminSuper.manajemen_pengguna', compact('users', 'disdagUsers'));
    }

    public function create()
    {
        $json = file_get_contents(public_path('assets/data/wilayah.json'));
        $wilayah = json_decode($json, true);
        return view('admin.adminSuper.tambah_pengguna', compact('wilayah'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'telp' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'alamat_lengkap' => 'required|string',
            'nik' => 'required|string|unique:user',
            'nib' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->kabupaten = $request->kabupaten;
        $user->kecamatan = $request->kecamatan;
        $user->kelurahan = $request->kelurahan;
        $user->email = $request->email;
        $user->telp = $request->telp;
        $user->password = Hash::make($request->password);
        $user->alamat_lengkap = $request->alamat_lengkap;
        $user->nik = $request->nik;
        $user->nib = $request->nib;
        $user->save();

        return redirect()->route('manajemen.pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $json = file_get_contents(public_path('assets/data/wilayah.json'));
        $wilayah = json_decode($json, true);
        return view('admin.adminSuper.edit_pengguna', compact('user', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $id . ',id_user',
            'telp' => 'required|string|max:15',
            'alamat_lengkap' => 'required|string',
            'nik' => 'required|string|unique:user,nik,' . $id . ',id_user',
            'nib' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->nama = $request->nama;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->kabupaten = $request->kabupaten;
        $user->kecamatan = $request->kecamatan;
        $user->kelurahan = $request->kelurahan;
        $user->email = $request->email;
        $user->telp = $request->telp;
        $user->alamat_lengkap = $request->alamat_lengkap;
        $user->nik = $request->nik;
        $user->nib = $request->nib;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('manajemen.pengguna')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('manajemen.pengguna')->with('success', 'Pengguna berhasil dihapus');
    }

    public function editDisdag($id)
    {
        $user = Disdag::findOrFail($id);
        return view('admin.adminSuper.edit_disdag', compact('user'));
    }

    public function updateDisdag(Request $request, $id)
    {
        $user = Disdag::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:18|unique:disdag,nip,' . $id . ',id_disdag',
            'email' => 'required|string|email|max:255|unique:disdag,email,' . $id . ',id_disdag',
            'telp' => 'required|string|max:15',
            'role' => 'required|string|in:master_admin,admin_perdagangan,admin_industri,admin_metrologi,kabid_perdagangan,kabid_industri,kabid_metrologi,kepala_dinas',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->nip = $request->nip;
        $user->email = $request->email;
        $user->telp = $request->telp;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('manajemen.pengguna')->with('success', 'Data pengguna Disdag berhasil diperbarui');
    }
} 