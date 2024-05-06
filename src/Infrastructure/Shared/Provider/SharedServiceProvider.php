<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Shared\Provider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class SharedServiceProvider extends ServiceProvider
{
    public static string $LPanel_Path;

    private string $publishGenericName = 'larapanel-install';

    public function boot()
    {
        self::$LPanel_Path = config('larapanel.namespace.directory', 'LaraPanel');
        $this->loadLaraPanelDataOnViewPages();

        // Configs
        $this->publishConfigs();
        // View Files
        $this->publishPurpleAdminViewFiles();

        // LOADING FROM
        $this->loadMigrationsFrom(base_path('database/migrations'));
        $this->loadViewsFrom(resource_path('/views'), self::$LPanel_Path);
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function () {
            View::share([
                'lp' => [
                    'name' => config('larapanel.name', 'LaraPanel'),
                    'directory' => self::$LPanel_Path,
                    'theme' => config('larapanel.theme', 'PurpleAdmin'),
                ],
            ]);
        });
    }

    public function register()
    {
    }

    private function publishConfigs(): void
    {
        $this->publishes([
            // Overwrite third party packages
            __DIR__ . '/../Stub/Config/permission.php.stub' => config_path('permission.php'),
            __DIR__ . '/../../../Config/laranav.php' => config_path('laranav.php'),
            // LaraPanel Config
            __DIR__ . '/../../../Config/larapanel.php' => config_path('larapanel.php'),
        ], [$this->publishGenericName, 'larapanel-config']);
    }

    private function publishPurpleAdminViewFiles(): void
    {
        $this->publishes([
            // ASSETS, PUBLIC FILES
            __DIR__ . '/../../../Presentation/Panel/Stub/Public/PurpleAdmin' => public_path(self::$LPanel_Path),

            __DIR__ . './../../../Presentation/Panel/View/PurpleAdmin' => resource_path(sprintf('views/%s', self::$LPanel_Path)),
        ], [$this->publishGenericName, 'larapanel-view-PurpleAdmin']);
    }
}
