<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Panel\Provider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;

final class PanelServiceProvider extends ServiceProvider
{
    private string $dirPath;

    private string $moduleName = 'Panel';

    public function boot()
    {
        $this->dirPath = SharedServiceProvider::$LPanel_Path;
        $this->loadLaraPanelDataOnViewPages();

        // Controller Files
        $this->publishControllerFiles();

        // Controller Files
        $this->publishComponentFiles();

        // View Files
        $this->publishPurpleAdminViewFiles();
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function () {
            View::share([]);
        });
    }

    public function register() {}

    private function publishPurpleAdminViewFiles(): void
    {
        $this->publishes([
            // ASSETS, PUBLIC FILES
            __DIR__.'/../../../Presentation/Panel/Stub/Public/PurpleAdmin' => public_path($this->dirPath.'/PurpleAdmin'),

            __DIR__.'/../../../Presentation/Panel/Stub/View/PurpleAdmin' => resource_path(sprintf('views/%s/PurpleAdmin', $this->dirPath)),
        ], [SharedServiceProvider::$publishGenericName, 'larapanel-view-PurpleAdmin']);
    }

    private function publishControllerFiles(): void
    {
        $this->publishes([
            __DIR__.'/../../../Presentation/Panel/Stub/Controller/DashboardController.php.stub' => app_path(sprintf('Http/Controllers/%s/%s/DashboardController.php', $this->dirPath, $this->moduleName)),
        ], [SharedServiceProvider::$publishGenericName, 'larapanel-panel-controller']);
    }

    private function publishComponentFiles(): void
    {
        $this->publishes([
            __DIR__.'/../../../Presentation/Panel/Stub/Components/BtnLinkComponent.php.stub' => app_path(sprintf('View/%s/Components/BtnLinkComponent.php', $this->dirPath, $this->moduleName)),
            __DIR__.'/../../../Presentation/Panel/Stub/Components/BtnFormDeleteListComponent.php.stub' => app_path(sprintf('View/%s/Components/BtnFormDeleteListComponent.php', $this->dirPath, $this->moduleName)),
        ], [SharedServiceProvider::$publishGenericName, 'larapanel-panel-components']);
    }
}
