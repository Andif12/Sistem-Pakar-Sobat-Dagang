<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController{

    public function show()
    {
        $daftarBerita = Berita::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.adminSuper.kelola_berita', compact('daftarBerita'));
    }

    public function tambahberita(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'lampiran' => 'required|image|mimes:jpg,jpeg,png,webp|max:51200',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        $id_disdag = session('id_disdag');

        Berita::create([
            'id_disdag' => $id_disdag,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'lampiran' => $lampiranPath,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, $id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();

        $berita->judul = $request->judul;
        $berita->tanggal = $request->tanggal;
        $berita->isi = $request->isi;

        // Cek apakah ada file lampiran yang di-upload
        if ($request->hasFile('lampiran')) {
            // Menghapus lampiran lama jika ada
            if ($berita->lampiran && file_exists(public_path('storage/' . $berita->lampiran))) {
                unlink(public_path('storage/' . $berita->lampiran));
            }

            // Simpan lampiran baru di folder storage/lampiran
            $filename = $request->file('lampiran')->store('lampiran', 'public'); // Menyimpan file ke storage/app/public/lampiran

            // Simpan nama file lampiran baru ke database
            $berita->lampiran = $filename; // Simpan path relatif (misalnya: lampiran/squfglYeGtj1oWJ0iV2ry5t3euhIFybiXDGWMmeJ)
        }

        $berita->save();

        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id_berita)
    {
        $berita = Berita::where('id_berita', $id_berita)->firstOrFail();

        // Hapus file lampiran jika ada
        if ($berita->lampiran && Storage::exists($berita->lampiran)) {
            Storage::delete($berita->lampiran);
        }

        $berita->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }
}
