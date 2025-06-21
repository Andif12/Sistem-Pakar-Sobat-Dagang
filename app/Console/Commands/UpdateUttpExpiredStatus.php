<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DirectoryBookController;

class UpdateUttpExpiredStatus extends Command
{
    protected $signature = 'uttp:update-expired-status';
    protected $description = 'Update status UTTP yang sudah expired';

    public function handle()
    {
        $controller = new DirectoryBookController();
        $controller->updateExpiredStatus();
        $this->info('Status UTTP yang expired telah diperbarui.');
    }
} 