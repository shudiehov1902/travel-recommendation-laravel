<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        $appUrl = config('app.url');
        $appPath = parse_url($appUrl, PHP_URL_PATH);

        if (is_string($appUrl) && is_string($appPath) && $appPath !== '' && $appPath !== '/') {
            URL::forceRootUrl(rtrim($appUrl, '/'));

            if (parse_url($appUrl, PHP_URL_SCHEME) === 'https') {
                URL::forceScheme('https');
            }
        }
    }
}
