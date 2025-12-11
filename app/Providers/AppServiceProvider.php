<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

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
    public function boot()
    {
        //
        Carbon::setLocale(config('app.locale'));

        Paginator::useBootstrap();

        // Importation du fichier resources/helpers/user_helpers.php
        require_once resource_path("helpers/enleve_accent.php");

    }

    

}
