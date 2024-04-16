<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Team;

class TeamTableSeeder extends MasterTeamTableSeeder
{
    protected $teams = [
        [
            'name' => 'Clients',
            'title' => 'Clients',
            'parent' => null,
            'description' => 'Group all the clients in one team!',
        ],
    ];
}
