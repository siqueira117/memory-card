<?php

namespace App\Providers;

use App\Listeners\LogGameCreation;
use App\Listeners\LogManualCreation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
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

        // Configurar o HTTP client para evitar problemas com SSL no Windows
        // Esta configuração é necessária para que o pacote IGDB Laravel funcione corretamente
        Http::macro('igdb', function () {
            return Http::withOptions([
                'verify' => false, // Desabilita verificação SSL
                'timeout' => 30,
            ]);
        });

        // Configuração global padrão para todas as requisições HTTP
        Http::globalOptions([
            'verify' => false,
            'timeout' => 30,
        ]);
    }
}
