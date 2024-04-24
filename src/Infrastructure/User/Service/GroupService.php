<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Service;

use WeProDev\LaraPanel\Core\User\Domain\UserDomain;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Service\GroupServiceInterface;

class GroupService implements GroupServiceInterface
{
    public function __construct(
        private GroupRepositoryInterface $groupRepository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function getUserGroups(UserDomain $userDomain): array
    {

        return [];
    }

    public function userHasGroup(UserDomain $userDomain, string $groupName): bool
    {
        return true;
    }
}
