<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\suratMetrologi;
use App\Models\suratBalasan;
use Illuminate\Support\Facades\Auth;

class PersuratanController extends Controller
{
    public function showAdministrasiMetrologi()
    {
        if (Auth::guard('user')->check()) {
            $permohonan = suratMetrologi::where('user_id', Auth::guard('user')->id())
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.bidangMetrologi.administrasi', compact('permohonan'));
        }

        return redirect()->route('login');
    }

    public function storeSuratMetrologi(Request $request)
    {
        $request->validate([
            'alamat_alat' => 'required|string',
            'nomor_surat' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'jenis_surat' => 'required|string',
        ]);

        // Cek apakah nomor surat sudah ada
        $existingSurat = suratMetrologi::where('id_surat', $request->nomor_surat)->first();
        if ($existingSurat) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nomor_surat' => 'Nomor surat ini sudah digunakan. Silakan gunakan nomor surat yang berbeda.']);
        }

        $sanitizedNomorSurat = str_replace(['/', '\\', ' '], '_', $request->nomor_surat);
        $filename = $sanitizedNomorSurat . '_' . Auth::guard('user')->id(). '.' . $request->file('dokumen')->getClientOriginalExtension();
        $filePath = $request->file('dokumen')->storeAs('surat_masuk_metrologi', $filename, 'public');

        suratMetrologi::create([
            'id_surat' => $request->nomor_surat,
            'user_id' => Auth::guard('user')->id(),
            'alamat_alat' => $request->alamat_alat,
            'jenis_surat' => $request->jenis_surat,
            'dokumen' => $filePath,
            'status_surat_masuk' => 'Menunggu',
            'status_admin' => 'Menunggu',
        ]);

        // Check if redirect parameter is present
        if ($request->has('redirect') && $request->redirect === 'riwayat') {
            return redirect()->route('administrasi-metrologi')->with('success', 'Permohonan berhasil diajukan.')->with('show_riwayat', true);
        }

        return redirect()->back()->with('success', 'Permohonan berhasil diajukan.');
    }

    public function showDokumenMetrologi($id)
    {
        $permohonan = suratMetrologi::findOrFail($id);

        if ($permohonan->user_id !== Auth::guard('user')->id()) {
            abort(403);
        }

        return Storage::disk('public')->download($permohonan->dokumen);
    }

    public function showcreateSuratBalasan($id)
    {
        $id_srt = str_replace('_', '/', $id);
        $surat = suratMetrologi::with('user')->where('id_surat', $id_srt)->firstOrFail();
        
        // Check if there's a draft
        $draft = suratBalasan::where('id_surat', $id_srt)
            ->where('status_surat_keluar', 'Draft')
            ->first();

        return view('admin.bidangMetrologi.buat_surat', compact('id', 'surat', 'draft'));
    }

    public function createSuratBalasan(Request $request, $id)
    {
        set_time_limit(300); // Tambah waktu jadi 2 menit
        $id_surat_masuk = str_replace('_', '/', $id);

        // Validasi input
        $validated = $request->validate([
            'id_surat_balasan' => 'required|string',
            'tanggal_pembuatan_surat' => 'required|date',
            'nama_yang_dituju' => 'required|string',
            'isi_surat' => 'required|string',
        ]);

        // Cek apakah nomor surat balasan sudah ada dan bukan dalam status draft
        $existingSuratBalasan = suratBalasan::where('id_surat_balasan', $validated['id_surat_balasan'])
            ->where('status_surat_keluar', '!=', 'Draft')
            ->first();
            
        if ($existingSuratBalasan) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_surat_balasan' => 'Nomor surat balasan ini sudah digunakan. Silakan gunakan nomor surat yang berbeda.']);
        }

        // Cek apakah ini adalah draft
        $isDraft = $request->input('action') === 'draft';

        // Simpan lampiran jika ada
        $lampiranPath = '-';
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_surat', 'public');
        }

        // Generate PDF hanya jika bukan draft
        $path_dokumen = null;
        if (!$isDraft) {
            // Generate PDF dari view blade
            $pdf = Pdf::loadView('SuratBalasan.surat-metrologi', [
                'nomor_surat' => $validated['id_surat_balasan'],
                'tanggal_pembuatan_surat' => $validated['tanggal_pembuatan_surat'],
                'nama_yang_dituju' => $validated['nama_yang_dituju'],
                'isi_surat' => $validated['isi_surat'],
            ])->setPaper('legal', 'portrait');

            // Simpan PDF ke storage
            $namaFile = str_replace('/', '_', $validated['id_surat_balasan']) . '_' . now()->format('Ymd_His') . '.pdf';
            Storage::disk('public')->put('surat_balasan/' . $namaFile, $pdf->output());
            $path_dokumen = 'surat_balasan/' . $namaFile;
        }

        // Cek apakah sudah ada draft
        $existingDraft = SuratBalasan::where('id_surat', $id_surat_masuk)
            ->where('status_surat_keluar', 'Draft')
            ->first();

        if ($existingDraft) {
            // Update draft yang sudah ada
            $existingDraft->update([
                'id_surat_balasan' => $validated['id_surat_balasan'],
                'tanggal' => $validated['tanggal_pembuatan_surat'],
                'path_dokumen' => $path_dokumen,
                'status_surat_keluar' => $isDraft ? 'Draft' : 'Menunggu',
                'status_kepalaBidang' => $isDraft ? 'Draft' : 'Menunggu',
                'isi_surat' => $validated['isi_surat'],
            ]);

            $surat = $existingDraft;
        } else {
            // Buat draft baru
            $surat = new SuratBalasan();
            $surat->id_surat_balasan = $validated['id_surat_balasan'];
            $surat->id_surat = $id_surat_masuk;
            $surat->tanggal = $validated['tanggal_pembuatan_surat'];
            $surat->path_dokumen = $path_dokumen;
            $surat->status_surat_keluar = $isDraft ? 'Draft' : 'Menunggu';
            $surat->status_kepalaBidang = $isDraft ? 'Draft' : 'Menunggu';
            $surat->isi_surat = $validated['isi_surat'];
            $surat->save();
        }

        if (!$isDraft) {
            $id_srt = str_replace(['_'], '/', $id);
            $surat = suratMetrologi::where('id_surat', $id_srt)->firstOrFail();
            $surat->status_admin = 'Menunggu Persetujuan';
            $surat->save();
        }

        $message = $isDraft ? 'Draft surat balasan berhasil disimpan.' : 'Surat balasan berhasil dibuat dan disimpan sebagai PDF.';
        return redirect($request->redirect_to)->with('success', $message);
    }

    public function editBalasan($id)
    {
        $id_surat = str_replace('_', '/', $id);
        $suratMasuk = suratMetrologi::where('id_surat', $id_surat)->firstOrFail();
        $suratBalasan = SuratBalasan::where('id_surat', $id_surat)->firstOrFail();

        return view('admin.bidangMetrologi.suratbalasan_edit', [
            'suratMasuk' => $suratMasuk,
            'suratBalasan' => $suratBalasan,
            'redirect_to' => url()->previous(),
        ]);
    }

    public function updateBalasan(Request $request, $id)
    {
        set_time_limit(300);
        $id_surat = str_replace('_', '/', $id);

        $validated = $request->validate([
            'id_surat_balasan' => 'required|string',
            'tanggal_pembuatan_surat' => 'required|date',
            'nama_yang_dituju' => 'required|string',
            'isi_surat' => 'required|string',
        ]);

        // Check if the new surat balasan ID already exists (excluding the current one)
        $existingSuratBalasan = suratBalasan::where('id_surat_balasan', $validated['id_surat_balasan'])
            ->where('id_surat', '!=', $id_surat)
            ->first();
            
        if ($existingSuratBalasan) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_surat_balasan' => 'Nomor surat balasan ini sudah digunakan. Silakan gunakan nomor surat yang berbeda.']);
        }

        $suratBalasan = SuratBalasan::where('id_surat', $id_surat)->firstOrFail();

        // Hapus dokumen sebelumnya (opsional)
        if ($suratBalasan->path_dokumen && Storage::disk('public')->exists($suratBalasan->path_dokumen)) {
            Storage::disk('public')->delete($suratBalasan->path_dokumen);
        }

        $pdf = Pdf::loadView('SuratBalasan.surat-metrologi', [
            'nomor_surat' => $validated['id_surat_balasan'],
            'tanggal_pembuatan_surat' => $validated['tanggal_pembuatan_surat'],
            'nama_yang_dituju' => $validated['nama_yang_dituju'],
            'isi_surat' => $validated['isi_surat'],
        ])->setPaper('legal', 'portrait');

        $namaFile = str_replace('/', '_', $validated['id_surat_balasan']) . '_' . now()->format('Ymd_His') . '.pdf';
        Storage::disk('public')->put('surat_balasan/' . $namaFile, $pdf->output());

        // Update surat balasan
        $suratBalasan->update([
            'id_surat_balasan' => $validated['id_surat_balasan'],
            'tanggal' => $validated['tanggal_pembuatan_surat'],
            'path_dokumen' => 'surat_balasan/' . $namaFile,
            'status_surat_keluar' => 'Menunggu',
            'isi_surat' => $validated['isi_surat'],
            'status_kepalaBidang' => 'Menunggu',
        ]);

        // Update status surat masuk
        $suratMasuk = suratMetrologi::where('id_surat', $id_surat)->firstOrFail();
        $suratMasuk->status_admin = 'Menunggu Persetujuan';
        $suratMasuk->save();

        return redirect($request->redirect_to)->with('success', 'Surat berhasil direvisi dan disimpan.');
    }

    public function checkNomorSurat(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string'
        ]);

        $exists = suratMetrologi::where('id_surat', $request->nomor_surat)->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function checkNomorSuratBalasan(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'current_surat_id' => 'nullable|string'
        ]);

        // Cek apakah nomor surat sudah ada dan bukan dalam status draft
        // Exclude the current surat being revised if provided
        $query = suratBalasan::where('id_surat_balasan', $request->nomor_surat)
            ->where('status_surat_keluar', '!=', 'Draft');
            
        if ($request->filled('current_surat_id')) {
            $query->where('id_surat', '!=', $request->current_surat_id);
        }
        
        $exists = $query->exists();
        
        return response()->json(['exists' => $exists]);
    }

    public function terimaSurat($id)
    {
        $id_srt= str_replace(['_'], '/', $id);
        $surat = suratMetrologi::where('id_surat', $id_srt)->firstOrFail();
        $surat->status_admin = 'Diproses';
        $surat->save();

        return redirect()->back()->with('success', 'Surat berhasil diterima.');
    }

    public function tolakSurat(Request $request, $encoded_id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:1000',
        ]);

        $id = base64_decode($encoded_id);
        $surat = SuratMetrologi::where('id_surat', $id)->firstOrFail();
        $surat->status_admin = 'Ditolak';
        $surat->status_surat_masuk = 'Ditolak';
        $surat->keterangan = $request->keterangan;
        $surat->save();

        return redirect()->back()->with('success', 'Surat berhasil ditolak dengan keterangan.');
    }


    public function terimaKabid($encoded_id, Request $request)
    {
        $id = base64_decode($encoded_id);
        $suratBalasan = SuratBalasan::findOrFail($id);
        $suratBalasan->status_kepalaBidang = 'Disetujui';
        $suratBalasan->status_kadis = 'Menunggu';
        $suratBalasan->save();

        return redirect()->back()->with('success', 'Surat berhasil diterima');
    }

    public function tolakKabid($encoded_id, Request $request)
    {
        $id = base64_decode($encoded_id);
        $suratBalasan = SuratBalasan::findOrFail($id);
        $suratBalasan->status_kepalaBidang = 'Ditolak';
        $suratBalasan->save();

        $suratMetrologi = $suratBalasan->suratMetrologi;
        if ($suratMetrologi) {
            $suratMetrologi->status_admin = 'Butuh Revisi';
            $suratMetrologi->save();
        }

        return back()->with('success', 'Surat berhasil ditolak.');
    }

    public function setujuiKadis($encoded_id)
    {
        $id = base64_decode($encoded_id);
        $surat = suratBalasan::findOrFail($id);
        $surat->status_kadis = 'Disetujui';
        $surat->save();

        // Update status surat masuk ke Diterima
        $suratMetrologi = $surat->suratMetrologi;
        if ($suratMetrologi) {
            $suratMetrologi->status_admin = 'Diterima';
            $suratMetrologi->status_surat_masuk = 'Disetujui'; // Update status permohonan user
            $suratMetrologi->save();
        }

        return redirect()->back()->with('success', 'Surat berhasil disetujui');
    }

    public function tolakKadis(Request $request, $encoded_id)
    {
        $id = base64_decode($encoded_id);
        $surat = suratBalasan::findOrFail($id);
        $surat->status_kadis = 'Ditolak';
        $surat->save();

        // Update status surat masuk ke Butuh Revisi
        $suratMetrologi = $surat->suratMetrologi;
        if ($suratMetrologi) {
            $suratMetrologi->status_admin = 'Butuh Revisi';
            $suratMetrologi->save();
        }

        return redirect()->back()->with('success', 'Surat berhasil ditolak');
    }

    public function tandaiSelesai($id)
    {
        $id_srt = str_replace('_', '/', $id);
        $surat = suratMetrologi::where('id_surat', $id_srt)->firstOrFail();
        $surat->status_admin = 'Selesai';
        $surat->save();

        return redirect()->back()->with('success', 'Surat berhasil ditandai sebagai selesai');
    }
}
