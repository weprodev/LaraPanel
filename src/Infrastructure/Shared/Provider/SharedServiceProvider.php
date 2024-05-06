<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Shared\Provider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class SharedServiceProvider extends ServiceProvider
{
    public static string $LPanel_Path;

    public function boot()
    {
        self::$LPanel_Path = config('larapanel.namespace.directory', 'LaraPanel');
        $this->loadLaraPanelDataOnViewPages();

        $publishes = [
            // configuration
            __DIR__ . '/../../../Config/larapanel.php' => config_path('larapanel.php'),

            // BASE VIEW LAYOUTS
            __DIR__ . '/../../../Presentation/Panel/View/layouts' => resource_path(sprintf('views/%s/layouts', self::$LPanel_Path)),
        ];
        $publishes = array_merge($publishes, $this->getViewFilesToPublish());
        $this->publishes($publishes);

        $this->loadMigrationsFrom(base_path('database/migrations'));

        // LOADING VIEW FILES
        $this->loadViewsFrom(resource_path('/views'), self::$LPanel_Path);
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function ($view) {
            View::share([
                'lp' => [
                    'name' => config('larapanel.name'),
                    'directory' => config('larapanel.namespace.directory'),
                    'theme' => config('larapanel.theme') ?? 'AdminLTE',
                ],
            ]);
        });
    }

    public function register()
    {
    }

    /**
     * Get the view files to be published.
     *
     * @return array<string, string>
     */
    private function getViewFilesToPublish(): array
    {
        $defaultTheme = config('larapanel.theme', 'PurpleAdmin');

        return [
            // ASSETS, PUBLIC FILES
            __DIR__ . sprintf('/../../../Presentation/Panel/Stub/Public/%s', $defaultTheme) => public_path(sprintf('/%s/%s', self::$LPanel_Path, $defaultTheme)),

            // THEME LAYOUTS
            __DIR__ . sprintf('/../../../Presentation/Panel/View/%s', $defaultTheme) => resource_path(sprintf('views/%s/%s', self::$LPanel_Path, $defaultTheme)),
        ];
    }
}
