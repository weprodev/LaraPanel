<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Shared\Provider;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class SharedServiceProvider extends ServiceProvider
{
    public static string $LPanel_Path;

    public static string $publishGenericName = 'larapanel-install';

    public function boot()
    {
        self::$LPanel_Path = config('larapanel.namespace.directory', 'LaraPanel');
        $this->loadLaraPanelDataOnViewPages();

        // Load Pagination View File
        $this->setupPaginationView();

        // Configs
        $this->publishConfigs();

        // Booting Components
        $this->bootComponents();

        // LOADING FROM
        $this->loadMigrationsFrom(base_path('database/migrations'));
        $this->loadViewsFrom(resource_path('/views'), self::$LPanel_Path);
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function () {
            View::share([
                'lp' => [
                    'dashboard_url' => url(config('larapanel.auth.default.redirection', '/')),
                    'name' => config('larapanel.name', 'LaraPanel'),
                    'directory' => self::$LPanel_Path,
                    'theme' => config('larapanel.theme', 'PurpleAdmin'),
                ],
            ]);
        });
    }

    public function register() {}

    private function publishConfigs(): void
    {
        $this->publishes([
            // Overwrite third party packages
            __DIR__.'/../Stub/Config/permission.php.stub' => config_path('permission.php'),
            __DIR__.'/../../../Config/laranav.php' => config_path('laranav.php'),
            // LaraPanel Config
            __DIR__.'/../../../Config/larapanel.php' => config_path('larapanel.php'),
        ], [self::$publishGenericName, 'larapanel-config']);
    }

    private function setupPaginationView(): void
    {
        $defaultTheme = config('larapanel.theme', 'PurpleAdmin');

        $bladePaginationViewPath = sprintf('%s/%s/layouts/pagination', self::$LPanel_Path, $defaultTheme);
        $paginationPath = resource_path(sprintf('views/%s.blade.php', $bladePaginationViewPath));
        if (file_exists($paginationPath)) {
            Paginator::defaultView($bladePaginationViewPath);
        }

        $bladeSimplePaginationViewPath = sprintf('%s/%s/layouts/simple-pagination', self::$LPanel_Path, $defaultTheme);
        $simplePaginationPath = resource_path(sprintf('views/%s.blade.php', $bladeSimplePaginationViewPath));
        if (file_exists($simplePaginationPath)) {
            Paginator::defaultSimpleView($bladeSimplePaginationViewPath);
        }
    }

    private function bootComponents(): void
    {
        $components = config('larapanel.view.boot', []);
        foreach ($components as $tag => $componentClass) {
            Blade::component($componentClass, $tag);
        }
    }
}
