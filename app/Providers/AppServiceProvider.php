<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\services\LoggingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoggingService::class, function () {
            return new LoggingService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
