<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SertifikasiHalal;

class UserHalalController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $data = SertifikasiHalal::when($keyword, function ($query) use ($keyword) {
            $query->where('nama_usaha', 'like', '%' . $keyword . '%')
                  ->orWhere('no_sertifikasi_halal', 'like', '%' . $keyword . '%')
                  ->orWhere('alamat', 'like', '%' . $keyword . '%');
        })
        ->orderBy('tanggal_sah', 'desc')
        ->get();

        return view('user.halal', compact('data'));
    }
}