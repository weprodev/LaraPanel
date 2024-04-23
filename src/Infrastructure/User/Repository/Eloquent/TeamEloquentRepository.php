<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use WeProDev\LaraPanel\Core\User\Domain\TeamDomain;
use WeProDev\LaraPanel\Core\User\Dto\TeamDto;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\Team;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\TeamFactory;

class TeamEloquentRepository implements TeamRepositoryInterface
{
    public function firstOrCreate(TeamDto $teamDto): TeamDomain
    {
        $teamModel = Team::firstOrCreate([
            "name" => $teamDto->getName(),
        ], [
            "name" => $teamDto->getName(),
            "title" => $teamDto->getTitle(),
            "parent_id" => $teamDto->getParentId(),
            "description" => $teamDto->getDescription()
        ]);

        return TeamFactory::fromEloquent($teamModel);
    }

    public function getDefaultTeam(): TeamDomain
    {
        $teamDto = TeamDto::make(
            config('larapanel.auth.default.team', 'Default'),
            config('larapanel.auth.default.team', 'Default Team')
        );

        return $this->firstOrCreate($teamDto);
    }
}
