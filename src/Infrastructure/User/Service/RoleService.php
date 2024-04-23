<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Service;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Service\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private TeamRepositoryInterface $teamRepository,
    ) {
    }

    public function getDefaultRole(): RoleDomain
    {
        $defaultTeam = $this->teamRepository->getDefaultTeam();
        $roleDto = RoleDto::make(
            config('larapanel.auth.default.role', 'User'),
            config('larapanel.auth.default.role', 'Default User Role'),
            $defaultTeam->getId()
        );

        return $this->roleRepository->firstOrCreate($roleDto);
    }
}
