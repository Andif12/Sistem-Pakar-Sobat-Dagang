<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use App\Models\ForumDiskusi;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}