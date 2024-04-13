<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Team;

class TeamTableSeeder extends MasterTeamTableSeeder
{
    protected $teams = [
        [
            'title' => 'Clients',
            'parent' => '',
        ],
    ];
}
