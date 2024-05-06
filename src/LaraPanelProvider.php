<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel;

use Illuminate\Support\ServiceProvider;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

final class LaraPanelProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->register(SharedServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
    }
}
