<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Panel\Provider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;

final class PanelServiceProvider extends ServiceProvider
{
    private string $moduleName = 'Panel';

    public function boot()
    {
        $this->loadLaraPanelDataOnViewPages();

        // Controller Files
        $this->publishControllerFiles();

        // View Files
        $this->publishPurpleAdminViewFiles();
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function () {
            View::share([]);
        });
    }

    public function register()
    {
    }

    private function publishPurpleAdminViewFiles(): void
    {
        $this->publishes([
            // ASSETS, PUBLIC FILES
            __DIR__.'/../../../Presentation/Panel/Stub/Public/PurpleAdmin' => public_path(SharedServiceProvider::$LPanel_Path.'/PurpleAdmin'),

            __DIR__.'/../../../Presentation/Panel/Stub/View/PurpleAdmin' => resource_path(sprintf('views/%s/PurpleAdmin', SharedServiceProvider::$LPanel_Path)),
        ], [SharedServiceProvider::$publishGenericName, 'larapanel-view-PurpleAdmin']);
    }

    private function publishControllerFiles(): void
    {
        $this->publishes([
            __DIR__.'/../../../Presentation/Panel/Stub/Controller/DashboardController.php.stub' => app_path(sprintf('Http/Controllers/%s/%s/DashboardController.php', SharedServiceProvider::$LPanel_Path, $this->moduleName)),
        ], [SharedServiceProvider::$publishGenericName, 'larapanel-panel-controller']);
    }
}
