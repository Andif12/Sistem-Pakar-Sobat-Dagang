<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportWilayah;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\PerbaruiIndexHarga;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportWilayah::class,
        PerbaruiIndexHarga::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('index-harga:perbarui')
        ->dailyAt('05:00') // jam 5 pagi server time
        ->timezone('Asia/Makassar'); // WITA (GMT+8)
        // $schedule->command('index-harga:perbarui')->everyMinute();
        // Menjadwalkan command untuk jalan setiap pagi jam 00:00

        $schedule->command('uttp:notify-expiry')->dailyAt('14:30');
        
        // Update expired status daily at midnight
        $schedule->command('uttp:update-expired-status')->dailyAt('00:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
