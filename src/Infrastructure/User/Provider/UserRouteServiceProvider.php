<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Provider;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class UserRouteServiceProvider extends ServiceProvider
{
    protected string $moduleWebNamespace = 'WeProDev\LaraPanel\Presentation\User\Controller\Web';

    protected string $moduleApiNamespace = 'WeProDev\LaraPanel\Presentation\User\Controller\Api';

    public const LP_USER_ROUTE_FILE_NAME = 'lp.admin.user.web.php';

    public const LP_AUTH_ROUTE_FILE_NAME = 'lp.auth.web.php';

    public const LP_USER_ROUTE = __DIR__.'/../../../Presentation/User/Route/'.self::LP_USER_ROUTE_FILE_NAME;

    public const LP_AUTH_ROUTE = __DIR__.'/../../../Presentation/User/Route/'.self::LP_AUTH_ROUTE_FILE_NAME;

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAuthRoutes();
    }

    private function mapWebRoutes()
    {
        Route::middleware(['web', 'auth:web'])
            ->as('lp.admin.')
            ->namespace($this->moduleWebNamespace)
            ->group(UserRouteServiceProvider::LP_USER_ROUTE);
    }

    private function mapAuthRoutes()
    {
        Route::middleware(['web', 'auth:web'])
            ->as('lp.auth.')
            ->namespace($this->moduleWebNamespace)
            ->group(UserRouteServiceProvider::LP_AUTH_ROUTE);
    }
}
