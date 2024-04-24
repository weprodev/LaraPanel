<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Group;

class GroupTableSeeder extends MasterGroupTableSeeder
{
    protected $groups = [
        [
            'name' => 'Default',
            'title' => 'Default Group',
            'parent' => null,
            'description' => 'Default group!',
        ],
    ];
}
