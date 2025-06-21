<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumDiskusi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ForumDiskusiController extends Controller
{
    public function index(){
    // Hanya untuk user
    if (!Auth::guard('user')->check()) {
        abort(403);
    }

    $chats = ForumDiskusi::with('user', 'disdag')
        ->orderBy('waktu', 'asc')
        ->get();

    return view('user.forum', compact('chats'));
    }

    public function adminForm()
    {
        // Hanya untuk admin (disdag)
        if (!Auth::guard('disdag')->check()) {
            abort(403);
        }

        $chats = ForumDiskusi::with('user', 'disdag')
            ->orderBy('waktu', 'asc')
            ->get();

        $pengaduan = ForumDiskusi::with('user')
            ->whereNotNull('id_user') // hanya pesan dari user
            ->orderBy('waktu', 'desc')
            ->get();

        return view('admin.adminSuper.pengaduanUser', compact('chats', 'pengaduan'));
    }

    public function kirimPesan(Request $request)
    {
        $request->validate(['chat' => 'required|string']);

        // Cek siapa yang sedang login
        if (Auth::guard('user')->check()) {
            // User login
            $chat = \App\Models\ForumDiskusi::create([
                'id_user' => Auth::guard('user')->id(),
                'id_disdag' => null,
                'chat' => $request->chat,
                'waktu' => now(),
                'status' => 'user',
            ]);
        } elseif (Auth::guard('disdag')->check()) {
            // Admin Disdag login
            $chat = \App\Models\ForumDiskusi::create([
                'id_user' => null,
                'id_disdag' => Auth::guard('disdag')->id(),
                'chat' => $request->chat,
                'waktu' => now(),
                'status' => 'disdag',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'chat' => $chat->load('user', 'disdag'),
        ]);
    }

    public function ambilPesan()
    {
        $chats = \App\Models\ForumDiskusi::with('user', 'disdag')->orderBy('waktu')->get();

        return response()->json($chats);
    }

    public function load()
    {
        $chats = \App\Models\ForumDiskusi::with('user', 'disdag')->orderBy('waktu')->get();
        
        return response()->json($chats);
    }


    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userId = auth()->guard('user')->id();
        $disdagId = auth()->guard('disdag')->id();

        // Cek apakah user atau disdag login
        if (!$userId && !$disdagId) {
            return response()->json([
                'success' => false,
                'message' => 'User atau admin belum login'
            ], 403);
        }

        try {
            DB::table('forum_diskusi')->insert([
                'id_user' => $userId,
                'id_disdag' => $disdagId,
                'chat' => $request->message,
                'status' => 'terkirim',
                'waktu' => now(), // ✅ Tambahkan ini!
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $chat = ForumDiskusi::findOrFail($id);

        if ($chat->id_user === null) {
            return back()->with('error', 'Pesan dari admin tidak bisa dihapus!');
        }

        $chat->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }


}