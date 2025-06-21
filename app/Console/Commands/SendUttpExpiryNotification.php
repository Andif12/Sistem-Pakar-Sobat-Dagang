<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DirectoryBookController;

class SendUttpExpiryNotification extends Command
{
    protected $signature = 'uttp:notify-expiry';
    protected $description = 'Kirim email notifikasi UTTP yang hampir expired';

    public function handle()
    {
        $controller = new DirectoryBookController();
        $controller->periksaKadaluarsa();

        $this->info('Notifikasi masa expired UTTP sudah dikirim.');
    }
}
