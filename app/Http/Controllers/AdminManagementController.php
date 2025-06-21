<?php

namespace App\Http\Controllers;

use App\Models\Disdag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    public function index()
    {
        $disdagUsers = Disdag::all();
        return view('admin.adminSuper.manajemen_admin', compact('disdagUsers'));
    }

    public function create()
    {
        $json = file_get_contents(public_path('assets/data/wilayah.json'));
        $wilayah = json_decode($json, true);
        return view('admin.adminSuper.tambah_admin', compact('wilayah'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'nip' => 'required|string|unique:disdag,nip|max:255',
        'email' => 'required|email|unique:disdag,email|max:255',
        'phone' => 'required|string|max:15',
        'role' => 'required|string|in:master_admin,admin_perdagangan,admin_industri,admin_metrologi,kabid_perdagangan,kabid_industri,kabid_metrologi,kepala_dinas',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $admin = new Disdag();
    $admin->nip = $request->nip;
    $admin->email = $request->email;
    $admin->telp = $request->phone;
    $admin->role = $request->role;
    $admin->password = Hash::make($request->password);
    $admin->save();

    return redirect()->route('manajemen.admin')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $user = Disdag::findOrFail($id);
        $user->delete();

        return redirect()->route('manajemen.admin')->with('success', 'Pengguna berhasil dihapus');
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

        return redirect()->route('manajemen.admin')->with('success', 'Data pengguna Disdag berhasil diperbarui');
    }
}