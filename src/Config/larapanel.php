<?php

declare(strict_types=1);

return [

    'path' => [
        // larapanel.path.admin
        'admin' => env('LP_ADMIN_PATH', '/lp-admin'),

        // larapanel.path.logo
        'logo' => env('LP_DEFAULT_LOGO_PATH', '/LaraPanel/PurpleAdmin/images/LaraPanel.png'),

        // larapanel.path.favicon
        'favicon' => env('LP_DEFAULT_FAVICON_PATH', '/LaraPanel/favicon.ico'),
    ],

    // larapanel.pagination
    'pagination' => env('LP_DEFAULT_PAGINATION', 15),

    // larapanel.theme
    'theme' => env('LP_DEFAULT_THEME', 'PurpleAdmin'),

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

        /**
         *  DEFAULT ROLE FOR USERS WANT TO REGISTER ON WEBSITE
         *  YOU SHOULD DEFINE THIS ROLE IN SEEDER OR CREATE IT IN ADMIN PANEL
         * **/
        // larapanel.auth.default_role
        'default_role' => env('LP_DEFAULT_ROLE', 'User'),

        // larapanel.auth.redirection_home_route
        'redirection_home_route' => env('LP_REDIRECT_HOME_ROUTE_NAME', 'home'),
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
                // required columns
                'first_name',
                'last_name',
                'email',        // unique
                'password',
                'status',
                'email_verified_at',    // DateTime, nullable
                // optional
                'mobile',   // unique, nullable
                'mobile_verified_at',  // DateTime, nullable
            ],
        ],

        'team' => [
            // larapanel.table.team.name
            'name' => 'teams',

            // larapanel.table.team.columns
            'columns' => [
                'title',
                'name', // unique
                'description',
                'parent_id',
            ],
        ],
    ],
];
