<?php

namespace App\Providers;

use App\Http\Middleware\Officer\CanOfficer;
use App\Http\Middleware\Officer\ApplyUserLocale as ApplyOfficerLocale;
use App\Http\Middleware\Officer\RedirectIfAuthenticated as RedirectOfficerIfAuthenticated;
use App\Http\Middleware\Citizen\CanCitizen;
use App\Http\Middleware\Citizen\ApplyUserLocale as ApplyCitizenLocale;
use App\Http\Middleware\Citizen\RedirectIfAuthenticated as RedirectCitizenIfAuthenticated;
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
        app(Router::class)->pushMiddlewareToGroup('officer', ApplyOfficerLocale::class);
        app(Router::class)->aliasMiddleware('guest.officer', RedirectOfficerIfAuthenticated::class);

        app(Router::class)->pushMiddlewareToGroup('citizen', CanCitizen::class);
        app(Router::class)->pushMiddlewareToGroup('citizen', ApplyCitizenLocale::class);
        app(Router::class)->aliasMiddleware('guest.citizen', RedirectCitizenIfAuthenticated::class);
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
