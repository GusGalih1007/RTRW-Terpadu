<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\RtRwRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\RtRwRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryInterface::class,
            concrete: AuthRepository::class
        );
        $this->app->bind(
            RtRwRepositoryInterface::class,
            RtRwRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
