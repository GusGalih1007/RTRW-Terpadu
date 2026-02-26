<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterface;
use App\Interfaces\RtRwRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\RtRwRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(
            ProgramRepositoryInterface::class,
            ProgramRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
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
