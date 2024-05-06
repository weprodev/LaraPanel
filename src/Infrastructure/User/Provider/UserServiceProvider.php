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

        $publishes = [
            //  route files
            UserRouteServiceProvider::LP_USER_ROUTE => app_path('/../routes/' . UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME),
            UserRouteServiceProvider::LP_AUTH_ROUTE => app_path('/../routes/' . UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME),

            // Overwrite permission config from laravel permission package
            __DIR__ . '/../Stub/Config/permission.php.stub' => config_path('permission.php'),

            // SEEDERS
            __DIR__ . '/../Stub/Seeder/PermissionSeeder.php.stub' => database_path('seeders/PermissionSeeder.php'),
            __DIR__ . '/../Stub/Seeder/RoleSeeder.php.stub' => database_path('seeders/RoleSeeder.php'),
            __DIR__ . '/../Stub/Seeder/GroupSeeder.php.stub' => database_path('seeders/GroupSeeder.php'),

            // LANG
            __DIR__ . '/../../../Presentation/User/lang/' => resource_path('lang/'),

            // USER MODULE VIEW FILES
            __DIR__ . sprintf('/../../../Presentation/%s/Stub/View', $this->moduleName) => resource_path(sprintf('views/%s/%s', self::$LPanel_Path, $this->moduleName)),
        ];
        $publishes = array_merge($publishes, $this->getMigrationFilesToPublish());
        $publishes = array_merge($publishes, $this->getAdminControllersToPublish());
        $publishes = array_merge($publishes, $this->getAuthControllersToPublish());
        $publishes = array_merge($publishes, $this->getModelsToPublish());
        $this->publishes($publishes);

        // //   CHECK IF ROUTE EXISTS IN BASE PROJECT, LOAD FROM THERE
        if (file_exists(base_path('routes/' . UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME))) {
            $this->loadRoutesFrom(base_path('routes/' . UserRouteServiceProvider::LP_USER_ROUTE_FILE_NAME));
        }
        if (file_exists(base_path('routes/' . UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME))) {
            $this->loadRoutesFrom(base_path('routes/' . UserRouteServiceProvider::LP_AUTH_ROUTE_FILE_NAME));
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
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = resource_path(sprintf('/views/%s/%s', self::$LPanel_Path, $this->moduleName));

        $this->publishes(
            [
                $sourcePath => $viewPath,
            ],
            ['views', $this->moduleNameLower . '-module-views']
        );

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths(), [$sourcePath]),
            $this->moduleNameLower
        );
    }

    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

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
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
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
            __DIR__ . '/../Stub/Migrations/2024_01_01_111111_create_users_table.php.stub' => database_path('migrations/' . $now->addSeconds(5)->format($timeFormat) . '_create_users_table.php'),
            __DIR__ . '/../Stub/Migrations/2024_01_01_222222_create_groups_table.php.stub' => database_path('migrations/' . $now->addSeconds(10)->format($timeFormat) . '_create_groups_table.php'),
            __DIR__ . '/../Stub/Migrations/2024_01_01_333333_edit_permission_tables.php.stub' => database_path('migrations/' . $now->addSeconds(15)->format($timeFormat) . '_edit_permission_tables.php'),
        ];
    }

    /**
     * Get controllers and form requests to be published.
     *
     * @return array<string, string>
     */
    private function getAdminControllersToPublish(): array
    {
        return [
            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Admin/PermissionsController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/PermissionsController.php', self::$LPanel_Path)),

            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Admin/RolesController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/RolesController.php', self::$LPanel_Path)),

            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Admin/GroupsController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/GroupsController.php', self::$LPanel_Path)),

            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Admin/UsersController.php.stub') => app_path(sprintf('Http/Controllers/%s/Admin/UsersController.php', self::$LPanel_Path)),

            // Form Request
            // __DIR__ . sprintf('/../../../Presentation/User/Stub/Requests') => resource_path(sprintf('Http/Requests/%s', self::$LPanel_Path)),
        ];
    }

    /**
     * Get Auth controllers and form requests to be published.
     *
     * @return array<string, string>
     */
    private function getAuthControllersToPublish(): array
    {
        return [
            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Auth/SignInController.php.stub') => app_path(sprintf('Http/Controllers/%s/Auth/SignInController.php', self::$LPanel_Path)),
            __DIR__ . sprintf('/../../../Presentation/User/Stub/Controller/Auth/SignUpController.php.stub') => app_path(sprintf('Http/Controllers/%s/Auth/SignUpController.php', self::$LPanel_Path)),

            // FormRequest Validation
            __DIR__ . sprintf('/../../../Presentation/User/Stub/Requests/Auth/SignInFormRequest.php.stub') => app_path(sprintf('Http/Requests/%s/Auth/SignInFormRequest.php', self::$LPanel_Path)),
            __DIR__ . sprintf('/../../../Presentation/User/Stub/Requests/Auth/SignUpFormRequest.php.stub') => app_path(sprintf('Http/Requests/%s/Auth/SignUpFormRequest.php', self::$LPanel_Path)),
        ];
    }

    private function getModelsToPublish(): array
    {
        return [
            __DIR__ . '/../Stub/Models/Permission.php.stub' => app_path(sprintf('Models/%s/Permission.php', self::$LPanel_Path)),
            __DIR__ . '/../Stub/Models/Role.php.stub' => app_path(sprintf('Models/%s/Role.php', self::$LPanel_Path)),
            __DIR__ . '/../Stub/Models/Group.php.stub' => app_path(sprintf('Models/%s/Group.php', self::$LPanel_Path)),
            __DIR__ . '/../Stub/Models/User.php.stub' => app_path(sprintf('Models/%s/User.php', self::$LPanel_Path)),
        ];
    }
}
