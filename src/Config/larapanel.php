<?php

declare(strict_types=1);

use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;

return [

    // larapanel.name
    'name' => env('LP_DEFAULT_APP_NAME', 'LaraPanel'),

    'path' => [
        // larapanel.path.admin
        'admin' => env('LP_ADMIN_PATH', '/lp-admin'),

        // larapanel.path.logo
        'logo' => env('LP_DEFAULT_LOGO_PATH', '/LaraPanel/logo.png'),

        // larapanel.path.favicon
        'favicon' => env('LP_DEFAULT_FAVICON_PATH', '/LaraPanel/favicon.ico'),
    ],

    // larapanel.pagination
    'pagination' => env('LP_DEFAULT_PAGINATION', 5),

    // larapanel.theme
    'theme' => env('LP_DEFAULT_THEME', 'PurpleAdmin'),

    // larapanel.language
    'language' => env('LP_DEFAULT_LANG', LanguageEnum::EN->value),

    /*
    |--------------------------------------------------------------------------
    | Authentication Configurations
    |--------------------------------------------------------------------------
    |
    */
    'auth' => [
        // larapanel.auth.enable
        'enable' => env('LP_AUTH_ENABLED', true),

        'signin' => [
            // larapanel.auth.signin.enable
            'enable' => true,
            // larapanel.auth.signin.url
            'url' => '/lp-admin/sign-in',
        ],

        'signup' => [
            // larapanel.auth.signup.enable
            'enable' => true,
            // larapanel.auth.signup.url
            'url' => '/lp-admin/sign-up',
        ],

        'signout' => [
            // larapanel.auth.signout.url
            'url' => '/lp-admin/sign-out',
        ],

        // larapanel.auth.username
        'username' => env('LP_DEFAULT_USERNAME', 'BOTH'), // EMAIL, MOBILE, BOTH

        'default' => [
            /**
             *  DEFAULT ROLE FOR USERS WANT TO REGISTER ON WEBSITE
             *  YOU SHOULD DEFINE THIS ROLE IN SEEDER OR CREATE IT IN ADMIN PANEL
             * **/
            // larapanel.auth.default.role
            'role' => env('LP_DEFAULT_ROLE', 'User'),

            // larapanel.auth.default.group
            'group' => env('LP_DEFAULT_GROUP', 'Default'),

            // larapanel.auth.default.redirection
            'redirection' => env('LP_DEFAULT_REDIRECT', '/'), // path, dashboard page
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Tech Configurations
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [
        // larapanel.namespace.directory
        'directory' => 'LaraPanel',

        // larapanel.namespace.admin
        'admin' => sprintf('App\Http\Controllers\%s\Admin', config('larapanel.namespace.directory', 'LaraPanel')),

        // larapanel.namespace.auth
        'auth' => sprintf('App\Http\Controllers\%s\Auth', config('larapanel.namespace.directory', 'LaraPanel')),
    ],

    /*
    |--------------------------------------------------------------------------
    | DataBase Configurations
    |--------------------------------------------------------------------------
    |
    */
    'table' => [
        // larapanel.table.prefix
        'prefix' => env('LP_TABLE_PREFIX', 'lp_'),

        'user' => [
            // larapanel.table.user.name
            'name' => 'users',

            // larapanel.table.user.columns
            'columns' => [
                'id',
                'first_name',
                'last_name',
                'email',        // unique
                'password',
                'status',
                'language',     // default: EN
                'email_verified_at',    // DateTime, nullable
                // optional
                'mobile',   // unique, nullable
                'mobile_verified_at',  // DateTime, nullable
            ],
        ],

        'group' => [
            // larapanel.table.group.name
            'name' => 'groups',

            // larapanel.table.group.columns
            'columns' => [
                'id',
                'title',
                'name', // unique
                'description',
                'parent_id',    // nullable, FK: id
            ],
        ],

        'model_has_group' => [
            // larapanel.table.model_has_group.name
            'name' => 'model_has_group',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Config
    |--------------------------------------------------------------------------
    |
    */

    'permission' => [

        'guard' => [
            // larapanel.permission.guard.default
            'default' => 'WEB',
            // larapanel.permission.guard.names
            'names' => [
                'WEB' => 'WEB',
            ],
        ],

        'module' => [
            // larapanel.permission.module.default
            'default' => 'Default',
            // larapanel.permission.module.list
            'list' => [
                'Default',
                'Core',
                'User',
            ],
        ],
    ],
];
