<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => config('larapanel.namespace.admin'),
        'prefix' => config('larapanel.path.admin', 'lp-admin'),
        'as' => 'lp.admin.',
        'middleware' => ['web', 'auth:web'],
    ],
    function () {

        Route::group(
            ['prefix' => 'users', 'as' => 'user.'],
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
            ['prefix' => 'roles', 'as' => 'role.'],
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
            ['prefix' => 'permissions', 'as' => 'permission.'],
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
            ['prefix' => 'groups', 'as' => 'group.'],
            function () {
                // lp.admin.group.index
                Route::get('/', 'GroupsController@index')->name('index');
                // lp.admin.group.create
                Route::get('/create', 'GroupsController@create')->name('create');
                // lp.admin.group.store
                Route::post('/store', 'GroupsController@store')->name('store');
                // lp.admin.group.edit
                Route::get('/edit/{ID}', 'GroupsController@edit')->name('edit');
                // lp.admin.group.update
                Route::put('/update/{ID}', 'GroupsController@update')->name('update');
                // lp.admin.group.delete
                Route::delete('/delete/{ID}', 'GroupsController@delete')->name('delete');
            }
        );
    }
);
