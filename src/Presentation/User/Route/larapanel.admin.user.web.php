<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => "App\Http\Controllers\LaraPanel",
        'prefix' => 'admin/user-management',
        'as' => 'admin.user.',
        'middleware' => ['web', 'auth:web'],
    ],
    function () {
        ////    USER ROUTES
        ///////////////////////////////////////////////////////////////////
        Route::group(
            [
                'prefix' => 'user',
                'as' => 'user.',
            ],
            function () {
                // admin.user_management.user.index
                Route::get('/', 'UsersController@index')->name('index');

                // admin.user_management.user.create
                Route::get('/create', 'UsersController@create')->name('create');

                // admin.user_management.user.store
                Route::post('/store', 'UsersController@store')->name('store');

                // admin.user_management.user.edit
                Route::get('/edit/{ID}', 'UsersController@edit')->name('edit');

                // admin.user_management.user.update
                Route::put('/update/{ID}', 'UsersController@update')->name(
                    'update'
                );

                // admin.user_management.user.delete
                Route::delete('/delete/{ID}', 'UsersController@delete')->name(
                    'delete'
                );

                // admin.user_management.user.restore
                Route::put(
                    '/restore/{ID}',
                    'UsersController@restoreBackUser'
                )->name('restore');
            }
        );

        ////    ROLE ROUTES
        ///////////////////////////////////////////////////////////////////
        Route::group(
            [
                'prefix' => 'role',
                'as' => 'role.',
            ],
            function () {
                // admin.user_management.role.index
                Route::get('/', 'RolesController@index')->name('index');

                // admin.user_management.role.create
                Route::get('/create', 'RolesController@create')->name('create');

                // admin.user_management.role.store
                Route::post('/store', 'RolesController@store')->name('store');

                // admin.user_management.role.edit
                Route::get('/edit/{ID}', 'RolesController@edit')->name('edit');

                // admin.user_management.role.update
                Route::put('/update/{ID}', 'RolesController@update')->name(
                    'update'
                );

                // admin.user_management.role.delete
                Route::delete('/delete/{ID}', 'RolesController@delete')->name(
                    'delete'
                );
            }
        );

        ////    PERMISSION ROUTES
        ///////////////////////////////////////////////////////////////////
        Route::group(
            [
                'prefix' => 'permission',
                'as' => 'permission.',
            ],
            function () {
                // admin.user_management.permission.index
                Route::get('/', 'PermissionsController@index')->name('index');

                // admin.user_management.permission.create
                Route::get('/create', 'PermissionsController@create')->name(
                    'create'
                );

                // admin.user_management.permission.store
                Route::post('/store', 'PermissionsController@store')->name(
                    'store'
                );

                // admin.user_management.permission.edit
                Route::get('/edit/{ID}', 'PermissionsController@edit')->name(
                    'edit'
                );

                // admin.user_management.permission.update
                Route::put(
                    '/update/{ID}',
                    'PermissionsController@update'
                )->name('update');

                // admin.user_management.permission.delete
                Route::delete(
                    '/delete/{ID}',
                    'PermissionsController@delete'
                )->name('delete');
            }
        );

        ////    DEPARTMENT ROUTES
        ///////////////////////////////////////////////////////////////////
        Route::group(
            [
                'prefix' => 'department',
                'as' => 'department.',
            ],
            function () {
                // admin.user_management.department.index
                Route::get('/', 'DepartmentsController@index')->name('index');

                // admin.user_management.department.create
                Route::get('/create', 'DepartmentsController@create')->name(
                    'create'
                );

                // admin.user_management.department.store
                Route::post('/store', 'DepartmentsController@store')->name(
                    'store'
                );

                // admin.user_management.department.edit
                Route::get('/edit/{ID}', 'DepartmentsController@edit')->name(
                    'edit'
                );

                // admin.user_management.department.update
                Route::put(
                    '/update/{ID}',
                    'DepartmentsController@update'
                )->name('update');

                // admin.user_management.department.delete
                Route::delete(
                    '/delete/{ID}',
                    'DepartmentsController@delete'
                )->name('delete');
            }
        );
    }
);

/*
    |--------------------------------------------------------------------------
    | IF THE CONFIG USER AUTH ENABLED THIS ROUTE WILL BE AVAILABLE
    |--------------------------------------------------------------------------
    |
    |
    */

if (config('laravel_user_management.auth.enable')) {
    /// USER AUTH
    Route::group(
        [
            'namespace' => "App\Http\Controllers\UserManagement\Auth",
            'as' => 'auth.user.',
            'middleware' => ['web', 'guest'],
        ],
        function () {
            // auth.user.login
            Route::get(
                config('laravel_user_management.auth.login_url'),
                'AuthController@loginForm'
            )->name('login');

            // auth.user.login
            Route::post(
                config('laravel_user_management.auth.login_url'),
                'AuthController@login'
            )->name('login');

            // auth.user.register
            Route::get(
                config('laravel_user_management.auth.register_url'),
                'AuthController@registerForm'
            )->name('register');

            // auth.user.register
            Route::post(
                config('laravel_user_management.auth.register_url'),
                'AuthController@register'
            )->name('register');
        }
    );

    ///////////////////
    Route::group(
        [
            'namespace' => "App\Http\Controllers\UserManagement\Auth",
            'as' => 'auth.user.',
            'middleware' => ['web', 'auth'],
        ],
        function () {
            // auth.user.logout
            Route::get(
                config('laravel_user_management.auth.logout_url'),
                'AuthController@logout'
            )->name('logout');
        }
    );
}
