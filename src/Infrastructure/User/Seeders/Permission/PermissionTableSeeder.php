<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Permission;

final class PermissionTableSeeder extends MasterPermissionTableSeeder
{
    protected $permissions = [
        [
            'name' => 'admin.manager',
            'title' => 'Admin Panel',
            'guard_name' => 'web',
            'description' => 'This permission is for access to admin panel.',
            'module' => 'User',
            'roles' => ['Admin'],
        ],
    ];
}
