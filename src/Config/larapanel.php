<?php

declare(strict_types=1);

return [
    // larapanel.admin_url
    'admin_url' => env('APP_URL').env('LP_ADMIN_PATH', '/lp-admin'),

    // larapanel.logo_url
    'logo_url' => env('APP_URL').env('LP_DEFAULT_LOGO_PATH', '/images/larapanel.png'),

    // larapanel.pagination
    'pagination' => env('LP_DEFAULT_PAGINATION', 15),

    // larapanel.theme
    'theme' => env('LP_DEFAULT_THEME', 'AdminLTE'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Configurations
    |--------------------------------------------------------------------------
    |
    */
    'auth' => [
        // larapanel.auth.enable
        'enable' => env('LP_AUTH_ENABLED', true),

        'url' => [
            // larapanel.auth.url.login
            'login' => '/login',

            // larapanel.auth.url.signup
            'signup' => '/signup',

            // larapanel.auth.url.logout
            'logout' => '/panel/logout',
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
