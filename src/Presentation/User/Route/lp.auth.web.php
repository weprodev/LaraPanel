<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

if (config('larapanel.auth.enable')) {
    Route::group(
        [
            'namespace' => "App\Http\Controllers\LaraPanel\Auth",
            'as' => 'lp.auth.user.',
            'middleware' => ['web', 'guest'],
        ],
        function () {
            // lp.auth.user.login
            Route::get(config('larapanel.auth.url.login'), 'AuthController@loginForm')->name('login');
            // lp.auth.user.login
            Route::post(config('larapanel.auth.url.login'), 'AuthController@login')->name('login');
            // lp.auth.user.signup
            Route::get(config('larapanel.auth.url.signup'), 'AuthController@signupForm')->name('signup');
            // lp.auth.user.signup
            Route::post(config('larapanel.auth.url.signup'), 'AuthController@signup')->name('signup');
        }
    );

    Route::group(
        [
            'namespace' => "App\Http\Controllers\LaraPanel\Auth",
            'as' => 'lp.auth.user.',
            'middleware' => ['web', 'auth'],
        ],
        function () {
            // lp.auth.user.logout
            Route::get(config('larapanel.auth.url.logout'), 'AuthController@logout')->name('logout');
        }
    );
}
