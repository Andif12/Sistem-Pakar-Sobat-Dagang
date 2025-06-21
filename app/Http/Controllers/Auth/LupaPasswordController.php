<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Auth\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class LupaPasswordController extends Controller{
    public function showForm(){
        return view('pages.auth.forgotpass');
    }

    public function sendLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:user,email'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Kirim email
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        Mail::send('emails.reset-password', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Kata Sandi Sobat Dagang');
        });

        return back()->with('status', 'Link reset kata sandi telah dikirim ke email Anda.');
    }

    public function showResetForm(Request $request, $token){
        return view('pages.auth.resetpass', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['token' => 'Token tidak valid atau telah kedaluwarsa.']);
        }

        DB::table('user')->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Kata sandi berhasil direset!');
    }

    public function showVerifyForm(){
        return view('pages.auth.changepass');
    }   

    public function checkOldPassword(Request $request){
        $request->validate([
            'old_password' => 'required',
        ]);

        $userId = auth()->guard('user')->id();
        $user = \App\Models\User::find($userId);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Kata sandi lama tidak cocok.']);
        }

        session(['verified_old_password' => true]);
        return redirect()->route('password.resetPass');
    }

    public function resetPass(){
        if (!session('verified_old_password')) {
            return redirect()->route('password.verifyOldForm');
        }

        return view('pages.auth.resetNewPassword');
    }

    public function updateNewPassword(Request $request){
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*()_+\-=\[\]{};\'":\\\\|,.<>\/?]/',
                'confirmed'                
            ]
        ], [
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf, angka, dan simbol unik (@$!%*#?&).',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',

        ]);
    $userId = auth()->guard('user')->id();
    $user = \App\Models\User::find($userId);

    if (Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama.'])->withInput();
    }
    $user->password = Hash::make($request->password);
    $user->save();

    session()->forget('verified_old_password');
    return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah.');
    }  

}

