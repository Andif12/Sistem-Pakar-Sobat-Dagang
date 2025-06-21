<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.adminSuper.kelola_faq', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        Faq::create($request->only('pertanyaan', 'jawaban'));
        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $faq = FAQ::findOrFail($id);
        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->back()->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->back()->with('success', 'FAQ berhasil dihapus.');
    }
}

