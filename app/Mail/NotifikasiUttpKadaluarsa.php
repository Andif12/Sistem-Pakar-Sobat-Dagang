<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiUttpKadaluarsa extends Mailable{
    
    use Queueable, SerializesModels;

    public $dataAlatUkur;

    public function __construct($dataAlatUkur)
    {
        $this->dataAlatUkur = $dataAlatUkur;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan UTTP Kadaluarsa')
            ->view('emails.kadaluarsa');
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Uttp Kadaluarsa',
        );
    }
}
