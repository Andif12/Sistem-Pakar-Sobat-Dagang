<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterVerificationMail extends Mailable
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $url = url('/verifikasi-akun?token=' . $this->user->verifikasi_token);

        return $this->subject('Verifikasi Akun Sobat Dagang')
            ->view('emails.verifikasi')
            ->with(['url' => $url, 'nama' => $this->user->nama]);
    }
}

