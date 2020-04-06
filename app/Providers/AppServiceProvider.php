<?php

namespace App\Providers;

use App\Http\Middleware\Officer\CanOfficer;
use App\Http\Middleware\Officer\ApplyUserLocale;
use App\Http\Middleware\Officer\RedirectIfAuthenticated;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        app(Router::class)->pushMiddlewareToGroup('officer', CanOfficer::class);
        app(Router::class)->pushMiddlewareToGroup('officer', ApplyUserLocale::class);
        app(Router::class)->aliasMiddleware('guest.officer', RedirectIfAuthenticated::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
