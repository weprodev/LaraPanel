<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Factory;

use WeProDev\LaraPanel\Core\User\Domain\TeamDomain;
use WeProDev\LaraPanel\Infrastructure\User\Model\Team;

final class TeamFactory
{
    public static function fromEloquent(Team $team): TeamDomain
    {
        return TeamDomain::make(
            $team->id,
            $team->name,
            $team->title,
            $team->parent_id,
            $team->description,
        );
    }
}
