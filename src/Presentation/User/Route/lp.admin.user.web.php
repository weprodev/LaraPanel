<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => config('larapanel.namespace.admin'),
        'prefix' => config('larapanel.admin_url', 'lp-admin'),
        'as' => 'lp.admin.',
        'middleware' => ['web', 'auth:web'],
    ],
    function () {

        Route::group(
            ['prefix' => 'user', 'as' => 'user.'],
            function () {
                // lp.admin.user.index
                Route::get('/', 'UsersController@index')->name('index');
                // lp.admin.user.create
                Route::get('/create', 'UsersController@create')->name('create');
                // lp.admin.user.store
                Route::post('/store', 'UsersController@store')->name('store');
                // lp.admin.user.edit
                Route::get('/edit/{ID}', 'UsersController@edit')->name('edit');
                // lp.admin.user.update
                Route::put('/update/{ID}', 'UsersController@update')->name('update');
                // lp.admin.user.delete
                Route::delete('/delete/{ID}', 'UsersController@delete')->name('delete');
                // lp.admin.user.restore
                Route::put('/restore/{ID}', 'UsersController@restoreBackUser')->name('restore');
            }
        );

        Route::group(
            ['prefix' => 'role', 'as' => 'role.'],
            function () {
                // lp.admin.role.index
                Route::get('/', 'RolesController@index')->name('index');
                // lp.admin.role.create
                Route::get('/create', 'RolesController@create')->name('create');
                // lp.admin.role.store
                Route::post('/store', 'RolesController@store')->name('store');
                // lp.admin.role.edit
                Route::get('/edit/{ID}', 'RolesController@edit')->name('edit');
                // lp.admin.role.update
                Route::put('/update/{ID}', 'RolesController@update')->name('update');
                // lp.admin.role.delete
                Route::delete('/delete/{ID}', 'RolesController@delete')->name('delete');
            }
        );

        Route::group(
            ['prefix' => 'permission', 'as' => 'permission.'],
            function () {
                // lp.admin.permission.index
                Route::get('/', 'PermissionsController@index')->name('index');
                // lp.admin.permission.create
                Route::get('/create', 'PermissionsController@create')->name('create');
                // lp.admin.permission.store
                Route::post('/store', 'PermissionsController@store')->name('store');
                // lp.admin.permission.edit
                Route::get('/edit/{ID}', 'PermissionsController@edit')->name('edit');
                // lp.admin.permission.update
                Route::put('/update/{ID}', 'PermissionsController@update')->name('update');
                // lp.admin.permission.delete
                Route::delete('/delete/{ID}', 'PermissionsController@delete')->name('delete');
            }
        );

        Route::group(
            ['prefix' => 'team', 'as' => 'team.'],
            function () {
                // lp.admin.team.index
                Route::get('/', 'TeamsController@index')->name('index');
                // lp.admin.team.create
                Route::get('/create', 'TeamsController@create')->name('create');
                // lp.admin.team.store
                Route::post('/store', 'TeamsController@store')->name('store');
                // lp.admin.team.edit
                Route::get('/edit/{ID}', 'TeamsController@edit')->name('edit');
                // lp.admin.team.update
                Route::put('/update/{ID}', 'TeamsController@update')->name('update');
                // lp.admin.team.delete
                Route::delete('/delete/{ID}', 'TeamsController@delete')->name('delete');
            }
        );
    }
);
