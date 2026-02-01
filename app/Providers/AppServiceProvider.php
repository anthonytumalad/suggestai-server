<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Services\FormService;
use App\Services\GoogleAuthService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthService::class, fn() => new AuthService());
        $this->app->singleton(FormService::class, fn() => new FormService());
        $this->app->singleton(GoogleAuthService::class, fn() => new GoogleAuthService());
    }

    public function boot(): void
    {
        //
    }
}
