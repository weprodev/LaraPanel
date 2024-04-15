<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Provider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class UserRouteServiceProvider extends ServiceProvider
{
    protected string $moduleWebNamespace = 'WeProDev\LaraPanel\Presentation\User\Controller\Web';

    protected string $moduleApiNamespace = 'WeProDev\LaraPanel\Presentation\User\Controller\Api';

    public const LP_USER_ROUTE_FILE_NAME = 'larapanel.admin.user.web.php';

    public const LP_USER_ROUTE = __DIR__.'/../../../Presentation/User/Route/'.self::LP_USER_ROUTE_FILE_NAME;

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    private function mapWebRoutes()
    {
        Route::middleware(['web', 'auth:web'])
            ->as('lp.admin.user.')
            ->namespace($this->moduleWebNamespace)
            ->group(UserRouteServiceProvider::LP_USER_ROUTE);
    }
}
