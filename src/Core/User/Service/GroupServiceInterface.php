<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Service;

use WeProDev\LaraPanel\Core\User\Domain\UserDomain;

interface GroupServiceInterface
{
    /**
     * @return string[] An array of group names associated with the user.
     */
    public function getUserGroups(UserDomain $userDomain): array;

    public function userHasGroup(UserDomain $userDomain, string $groupName): bool;
}
