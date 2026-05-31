<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') === 'production') {
            URL::forceRootUrl(config('app.url'));

            if (env('APP_FORCE_HTTPS', false)) {
                URL::forceScheme('https');
            } else {
                URL::forceScheme('http');
            }
        }

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });
    }
}
