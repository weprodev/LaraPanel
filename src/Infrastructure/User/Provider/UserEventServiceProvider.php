<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class UserEventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot()
    {
        parent::boot();
    }
}
