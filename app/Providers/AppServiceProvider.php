<?php

namespace App\Providers;

use App\Listeners\LogGameCreation;
use App\Listeners\LogManualCreation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Event::listen(
            LogGameCreation::class,
            LogManualCreation::class
        );
    }
}
