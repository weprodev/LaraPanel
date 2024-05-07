<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Provider;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Service\GroupServiceInterface;
use WeProDev\LaraPanel\Infrastructure\User\Facade\LPanelService;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\GroupEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\PermissionEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\RoleEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent\UserEloquentRepository;
use WeProDev\LaraPanel\Infrastructure\User\Service\GroupService;

final class UserServiceProvider extends ServiceProvider
{
    public static string $LPanel_Path;

    private string $publishGenericName = 'larapanel-install';

    private string $moduleName = 'User';

    private string $moduleNameLower = 'user';

    public function boot()
    {
        self::$LPanel_Path = config('larapanel.namespace.directory', 'LaraPanel');

        $this->registerTranslations();
        $this->registerViews();
        $this->loadLaraPanelDataOnViewPages();

        Artisan::call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
        ]);

        // USER MODULE VIEW FILES
        $this->publishes([
            UserRouteServiceProvider::LP_USER_ROUTE => app_path('/../routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME),
            UserRouteServiceProvider::LP_AUTH_ROUTE => app_path('/../routes/'.UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME),
        ], [$this->publishGenericName, 'larapanel-route-user']);

        // USER MODULE VIEW FILES
        $this->publishes([
            __DIR__.sprintf('/../../../Presentation/%s/Stub/View', $this->moduleName) => resource_path(sprintf('views/%s/%s', self::$LPanel_Path, $this->moduleName)),
        ], [$this->publishGenericName, 'larapanel-view-user']);

        // LANG
        $this->publishes([
            __DIR__.'/../../../Presentation/User/lang/' => resource_path('lang/'),
        ], [$this->publishGenericName, 'larapanel-lang']);

        // SEEDERS
        $this->publishSeeders();
        // MODELS
        $this->publishModels();
        // MIGRATIONS
        $this->publishMigrationFiles();
        // ADMIN CONTROLLERS
        $this->publishAdminControllers();
        // AUTH CONTROLLERS
        $this->publishAuthControllers();

        // CHECK IF ROUTE EXISTS IN BASE PROJECT, LOAD FROM THERE
        if (file_exists(base_path('routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME))) {
            $this->loadRoutesFrom(base_path('routes/'.UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME));
        }
        if (file_exists(base_path('routes/'.UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME))) {
            $this->loadRoutesFrom(base_path('routes/'.UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME));
        }
    }

    private function loadLaraPanelDataOnViewPages()
    {
        view()->composer('*', function ($view) {
            View::share([]);
        });
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
        $this->app->bind(GroupRepositoryInterface::class, GroupEloquentRepository::class);

        /*
        |--------------------------------------------------------------------------
        | SERVICE BINDING
        |--------------------------------------------------------------------------
        */
        $this->app->bind(GroupServiceInterface::class, GroupService::class);

        // Facade Pattern
        $this->app->bind('LPanel', function () {
            return new LPanelService;
        });
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = resource_path(sprintf('/views/%s/%s', self::$LPanel_Path, $this->moduleName));

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
            $this->loadJsonTranslationsFrom($langPath);

            return;
        }

        $this->loadJsonTranslationsFrom(base_path('/lang'));
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
    private function publishMigrationFiles(): void
    {
        $timeFormat = 'Y_m_d_His';
        $now = Carbon::now();

        $this->publishes([
            __DIR__.'/../Stub/Migrations/2024_01_01_111111_create_users_table.php.stub' => database_path('migrations/'.$now->addSeconds(5)->format($timeFormat).'_create_users_table.php'),
            __DIR__.'/../Stub/Migrations/2024_01_01_222222_create_groups_table.php.stub' => database_path('migrations/'.$now->addSeconds(10)->format($timeFormat).'_create_groups_table.php'),
            __DIR__.'/../Stub/Migrations/2024_01_01_333333_edit_permission_tables.php.stub' => database_path('migrations/'.$now->addSeconds(15)->format($timeFormat).'_edit_permission_tables.php'),
        ], [$this->publishGenericName, 'larapanel-migrations']);
    }

    /**
     * Get controllers and form requests to be published.
     *
     * @return array<string, string>
     */
    private function publishAdminControllers(): void
    {
        $this->publishes([
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Admin/PermissionsController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/PermissionsController.php', self::$LPanel_Path)),
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Admin/RolesController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/RolesController.php', self::$LPanel_Path)),
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Admin/GroupsController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/GroupsController.php', self::$LPanel_Path)),
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Admin/UsersController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/UsersController.php', self::$LPanel_Path)),

            // Form Request
            // __DIR__ . sprintf('/../../../Presentation/User/Stub/Requests') => resource_path(sprintf('Http/Requests/%s', self::$LPanel_Path)),
        ], [$this->publishGenericName, 'larapanel-admin-controller']);
    }

    /**
     * Get Auth controllers and form requests to be published.
     *
     * @return array<string, string>
     */
    private function publishAuthControllers(): void
    {
        $this->publishes([
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Auth/SignInController.php.stub') => app_path(sprintf('Http/Controllers/%s/Auth/SignInController.php', self::$LPanel_Path)),
            __DIR__.sprintf('/../../../Presentation/User/Stub/Controller/Auth/SignUpController.php.stub') => app_path(sprintf('Http/Controllers/%s/Auth/SignUpController.php', self::$LPanel_Path)),

            // FormRequest Validation
            __DIR__.sprintf('/../../../Presentation/User/Stub/Requests/Auth/SignInFormRequest.php.stub') => app_path(sprintf('Http/Requests/%s/Auth/SignInFormRequest.php', self::$LPanel_Path)),
            __DIR__.sprintf('/../../../Presentation/User/Stub/Requests/Auth/SignUpFormRequest.php.stub') => app_path(sprintf('Http/Requests/%s/Auth/SignUpFormRequest.php', self::$LPanel_Path)),
        ], [$this->publishGenericName, 'larapanel-auth-controller']);
    }

    private function publishModels(): void
    {
        $this->publishes([
            __DIR__.'/../Stub/Models/Permission.php.stub' => app_path(sprintf('Models/%s/Permission.php', self::$LPanel_Path)),
            __DIR__.'/../Stub/Models/Role.php.stub' => app_path(sprintf('Models/%s/Role.php', self::$LPanel_Path)),
            __DIR__.'/../Stub/Models/Group.php.stub' => app_path(sprintf('Models/%s/Group.php', self::$LPanel_Path)),
            __DIR__.'/../Stub/Models/User.php.stub' => app_path(sprintf('Models/%s/User.php', self::$LPanel_Path)),
        ], ['larapanel-install', 'larapanel-models']);
    }

    private function publishSeeders(): void
    {
        $this->publishes([
            __DIR__.'/../Stub/Seeder/PermissionSeeder.php.stub' => database_path('seeders/PermissionSeeder.php'),
            __DIR__.'/../Stub/Seeder/RoleSeeder.php.stub' => database_path('seeders/RoleSeeder.php'),
            __DIR__.'/../Stub/Seeder/GroupSeeder.php.stub' => database_path('seeders/GroupSeeder.php'),
        ], [$this->publishGenericName, 'larapanel-seeders']);
    }
}
