<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Provider;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Facade\LPanelService;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\PermissionEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\RoleEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\UserEloquentRepository;

final class UserServiceProvider extends ServiceProvider
{
    const LPanel_Path = 'LaraPanel';

    private string $moduleName = 'User';

    private string $moduleNameLower = 'user';

    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();
        $this->loadUserAuthenticatedOnViewPages();

        Artisan::call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
        ]);

        $publishes = [
            //  User route file
            UserRouteServiceProvider::LP_USER_ROUTE => app_path('/../routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME),

            // configuration
            __DIR__.'/../../../Config/larapanel.php' => config_path('larapanel.php'),
            // Overwrite permission config from laravel permission package
            __DIR__.'/../Stub/Config/permission.php.stub' => config_path('permission.php'),

            // Models
            __DIR__.'/../Stub/Models/Permission.php.stub' => app_path('Models/Permission.php'),
            __DIR__.'/../Stub/Models/Role.php.stub' => app_path('Models/Role.php'),
            __DIR__.'/../Stub/Models/Team.php.stub' => app_path('Models/Team.php'),
            __DIR__.'/../Stub/Models/LPanelUser.php.stub' => app_path('Models/LPanelUser.php'),

            // SEEDERS
            __DIR__.'/../Stub/Seeder/PermissionSeeder.php.stub' => database_path('seeders/PermissionSeeder.php'),
            __DIR__.'/../Stub/Seeder/RoleSeeder.php.stub' => database_path('seeders/RoleSeeder.php'),
            __DIR__.'/../Stub/Seeder/TeamSeeder.php.stub' => database_path('seeders/TeamSeeder.php'),

            // LANG
            __DIR__.'/../../../Presentation/User/lang/' => resource_path('lang/'),

            // BASE VIEW LAYOUTS
            __DIR__.'/../../../Presentation/Panel/View/layouts' => resource_path(sprintf('views/%s/layouts', self::LPanel_Path)),

            // USER MODULE VIEW FILES
            __DIR__.sprintf('/../../../Presentation/%s/Stub/View', $this->moduleName) => resource_path(sprintf('views/%s/%s', self::LPanel_Path, $this->moduleName)),
        ];
        $publishes = array_merge($publishes, $this->getMigrationFilesToPublish());
        $publishes = array_merge($publishes, $this->getViewFilesToPublish());
        $this->publishes($publishes);

        //   CHECK IF ROUTE EXISTS IN BASE PROJECT, LOAD FROM THERE
        if (file_exists(base_path('routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME))) {
            $this->loadRoutesFrom(base_path('routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME));
        }

        $this->loadMigrationsFrom(base_path('database/migrations'));

        // LOADING VIEW FILES
        $this->loadViewsFrom(resource_path('/views'), self::LPanel_Path);
    }

    private function loadUserAuthenticatedOnViewPages()
    {
        // view()->composer('*', function ($view) {
        //     $userRepository = resolve(UserRepositoryInterface::class);
        //     $user = $userRepository->findCurrent();
        //     View::share([
        //         'auth' => $user,
        //     ]);
        // });
    }

    public function register()
    {
        $this->app->register(UserRouteServiceProvider::class);
        $this->app->register(UserEventServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY BINDING
        |--------------------------------------------------------------------------
        */
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionEloquentRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleEloquentRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepositoryInterface::class);

        /*
        |--------------------------------------------------------------------------
        | SERVICE BINDING
        |--------------------------------------------------------------------------
        */

        $this->app->bind('LPanel', function () {
            return new LPanelService;
        });
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = resource_path(sprintf('/views/%s/%s', self::LPanel_Path, $this->moduleName));

        $this->publishes(
            [
                $sourcePath => $viewPath,
            ],
            ['views', $this->moduleNameLower.'-module-views']
        );

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);

            return;
        }

        $this->loadJsonTranslationsFrom(
            base_path('/lang'),
            $this->moduleNameLower
        );
    }

    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }

    /**
     * Get the migration files to be published.
     *
     * @return array<string, string>
     */
    private function getMigrationFilesToPublish(): array
    {
        $timeFormat = 'Y_m_d_His';
        $now = Carbon::now();

        return [
            __DIR__.'/../Stub/Migrations/2024_01_01_111111_create_users_table.php.stub' => database_path('migrations/'.$now->addSeconds(5)->format($timeFormat).'_create_users_table.php'),
            __DIR__.'/../Stub/Migrations/2024_01_01_222222_create_teams_table.php.stub' => database_path('migrations/'.$now->addSeconds(10)->format($timeFormat).'_create_teams_table.php'),
            __DIR__.'/../Stub/Migrations/2024_01_01_333333_edit_permission_tables.php.stub' => database_path('migrations/'.$now->addSeconds(15)->format($timeFormat).'_edit_permission_tables.php'),
        ];
    }

    /**
     * Get the view files to be published.
     *
     * @return array<string, string>
     */
    private function getViewFilesToPublish(): array
    {
        $defaultTheme = config('larapanel.theme') ?? 'AdminLTE';

        return [
            // ASSETS, PUBLIC FILES
            __DIR__.sprintf('/../../../Presentation/Panel/Stub/Public/%s', $defaultTheme) => public_path(sprintf('/%s/%s', self::LPanel_Path, $defaultTheme)),

            // THEME LAYOUTS
            __DIR__.sprintf('/../../../Presentation/Panel/View/%s', $defaultTheme) => resource_path(sprintf('views/%s/%s', self::LPanel_Path, $defaultTheme)),
        ];
    }
}
