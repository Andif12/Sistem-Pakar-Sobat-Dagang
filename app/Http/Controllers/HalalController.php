<?php

namespace App\Http\Controllers;

use App\Models\SertifikasiHalal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HalalController extends Controller
{
        
    public function index(Request $request)
    {
        $data = SertifikasiHalal::orderBy('tanggal_sah', 'desc')->get()->map(function ($item) {
            return [
                'id_halal' => $item->id_halal,
                'nama_usaha' => $item->nama_usaha,
                'no_sertifikasi_halal' => $item->no_sertifikasi_halal,
                'tanggal_sah' => $item->tanggal_sah
                    ? Carbon::parse($item->tanggal_sah)->format('Y-m-d')
                    : null,
                'tanggal_exp' => $item->tanggal_exp
                    ? Carbon::parse($item->tanggal_exp)->format('Y-m-d')
                    : null,

                'tanggal_sah_formatted' => $item->tanggal_sah
                    ? Carbon::parse($item->tanggal_sah)->translatedFormat('d F Y')
                    : '-',
                'tanggal_exp_formatted' => $item->tanggal_exp
                    ? Carbon::parse($item->tanggal_exp)->translatedFormat('d F Y')
                    : '-',

                'alamat' => $item->alamat,
                'status' => $item->status,  
                'sertifikat' => $item->sertifikat,
            ];
        });

       
        $query = SertifikasiHalal::query();

        if ($searchTerm = request('search')) {
            $search = strtolower(trim($searchTerm));

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama_usaha) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(no_sertifikasi_halal) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(alamat) LIKE ?', ["%$search%"])
                    ->orWhereRaw('DATE_FORMAT(tanggal_sah, "%d-%m-%Y") LIKE ?', ["%$search%"])
                    ->orWhereRaw('DATE_FORMAT(tanggal_exp, "%d-%m-%Y") LIKE ?', ["%$search%"]);
            });
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        return view('admin.bidangIndustri.halal',[
            'data' => $data,
            'items' => $items,
           
        ]);
    }


    public function store(Request $request)
    {
        try {
            $rules =[
                'nama_usaha'            => 'required|string|max:255',
                'no_sertifikasi_halal'  => 'nullable|string|max:255',
                'tanggal_sah'           => 'required|date',
                'tanggal_exp'           => 'required|date|after_or_equal:tanggal_sah',
                'alamat'                => 'required|string',
                'status'                => 'required|string|in:Berlaku,Perlu Pembaruan',
                'sertifikat'            => 'required|file|mimes:pdf|max:512',
            ];

            $messages = [ 'status' => 'Status sertifikat wajib diisi.',
                    'sertifikat.required' => 'File sertifikat wajib diunggah.',
                    'sertifikat.mimes' => 'File sertifikat harus berformat pdf.',
                    'sertifikat.max' => 'File sertifikat tidak boleh lebih dari 512 kilobyte.',
                ];

            $validated = $request->validate($rules, $messages);

        
            if ($request->hasFile('sertifikat')) {
                $file = $request->file('sertifikat');
                $fileName = time() . '' . preg_replace('/\s+/', '', $file->getClientOriginalName());
                $filePath = $file->storeAs('sertifikat_halal', $fileName, 'public');
                $validated['sertifikat'] = $filePath;
            }

            SertifikasiHalal::create($validated);

            return redirect()->route('admin.industri.halal')->with('success', 'Data sertifikasi halal berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error("Gagal menambahkan sertifikasi halal: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->with('openAdd', true);
        }
    }
    

    public function update(Request $request, $id)
    {
        $item = SertifikasiHalal::findOrFail($id);

        $validated = $request->validate([
            'nama_usaha'            => 'required|string|max:255',
            'no_sertifikasi_halal'  => 'nullable|string|max:255',
            'tanggal_sah'           => 'required|date',
            'tanggal_exp'           => 'required|date|after_or_equal:tanggal_sah',
            'alamat'                => 'required|string',
            'status'                => 'required|string|in:Berlaku,Perlu Pembaruan',
            'sertifikat'            => 'nullable|file|mimes:pdf|max:512',
        ]);

        if ($request->hasFile('sertifikat')) {
            if ($item->sertifikat && Storage::disk('public')->exists($item->sertifikat)) {
                Storage::disk('public')->delete($item->sertifikat);
            }

            $file = $request->file('sertifikat');
            $fileName = time() . '' . preg_replace('/\s+/', '', $file->getClientOriginalName());
            $filePath = $file->storeAs('sertifikat_halal', $fileName, 'public');
            $validated['sertifikat'] = $filePath;
        }

        $item->update($validated);

        if ($request->ajax()) {
            return response()->json(['message' => 'Data berhasil diupdate.'], 200);
        }

        return redirect()->route('halal')
            ->with('success', 'Data berhasil diupdate.');
    }


    public function destroy(Request $request, $id)
    {
        $item = SertifikasiHalal::findOrFail($id);

        if ($item->sertifikat && Storage::disk('public')->exists($item->sertifikat)) {
            Storage::disk('public')->delete($item->sertifikat);
        }

        $item->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Data berhasil dihapus.'], 200);
        }

        return redirect()->route('halal')
            ->with('success', 'Data berhasil dihapus.');
    }
}