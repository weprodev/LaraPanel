<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\TeamDomain;
use WeProDev\LaraPanel\Core\User\Dto\TeamDto;

interface TeamRepositoryInterface
{
    public function firstOrCreate(TeamDto $teamDto): TeamDomain;

    public function getDefaultTeam(): TeamDomain;
}
